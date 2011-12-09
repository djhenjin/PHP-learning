<?php
require_once("config.php");


class Chat
{
    public function submitchat($user, $message)
    {
        global $dbhost, $dbname, $dbuser, $dbpass;
        
        $db = new PDO(  'mysql:host=' . $dbhost . ';dbname=' . $dbname . '', $dbuser, $dbpass);

        $stmt1 = $db->prepare ("INSERT INTO messages (id, message, user) VALUES ('', :message,:user)"); // "INSERT INTO messages (message, user) VALUES (:messgae, :user)" should be the query.
        $stmt1->bindParam(':message', $message);
        $stmt1->bindParam(':user', $user);
        $stmt1->execute();
        header("Location: index.php"); 
    }
    public function displaychat()
    {
        global $dbhost, $dbname, $dbuser, $dbpass;
        $db = new PDO(  'mysql:host=' . $dbhost . ';dbname=' . $dbname . '', $dbuser, $dbpass);
        echo "<div id=\"Messages\">";
        foreach($db->query('SELECT * FROM messages ORDER BY id DESC') as $row) 
        {
            echo "Message: $row[1]  </br>\r\n";
            echo "User: $row[2] </br>\r\n";
            echo "<hr>\r\n";
        }
	echo "</div>";
    }
}    
?>
