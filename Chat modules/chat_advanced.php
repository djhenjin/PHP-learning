<title>Simple Webchat</title>
<h1> very simple webchat with no authentication</h1>


<form name="chat" action="chat_advanced.php" method="post">
Message: <textarea rows="10" cols="30" wrap="physical" name="chatmsg">
Type Chat Message Here, Then press submit!
</textarea></br>
Name: <input type="text" name="Name"></br>
<input type="submit" value="Submit Chat!">
</form>
<?php
$host = "localhost";
$dbname = "chatpage";
$user = "chat";
$pass = ""; 
try {
$db = new PDO('mysql:host=localhost;dbname=chatpage', $user , $pass );

if (isset($_POST["chatmsg"]))
{
$message = $_POST["chatmsg"];
$user = $_POST["Name"];

$stmt1 = $db->prepare ("INSERT INTO messages (id, message, user) VALUES ('', :message,:user)");
$stmt1->bindParam(':message', $message);
$stmt1->bindParam(':user', $user);


 
$stmt1->execute();

}    

//$stmt2= $db->prepare("SELECT * FROM mesages ORDER BY id");
//$stmt2->execute();


foreach($db->query('SELECT * FROM messages ORDER BY id DESC') as $row) 
{
    echo "Message: $row[1]  </br>";
    echo "User: $row[2] </br>";
    echo "<hr>";
}

} catch (PDOException $e)
{
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>