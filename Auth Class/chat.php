<?php
require_once("config.php");


class Chat
{
    public function submitchat($user, $message)
    {
        global $dbhost, $dbname, $dbuser, $dbpass;
        
        $db = new PDO(  'mysql:host=' . $dbhost . ';dbname=' . $dbname . '', $dbuser, $dbpass);

        $stmt1 = $db->prepare ("INSERT INTO messages (id, message, user) VALUES ('', :message,:user)");
        $stmt1->bindParam(':message', $message);
        $stmt1->bindParam(':user', $user);
        $stmt1->execute();
        
    }
    public function displaychat()
    {
        global $dbhost, $dbname, $dbuser, $dbpass;
        $db = new PDO(  'mysql:host=' . $dbhost . ';dbname=' . $dbname . '', $dbuser, $dbpass);
        
        foreach($db->query('SELECT * FROM messages ORDER BY id DESC') as $row) 
        {
            echo "Message: $row[1]  </br>";
            echo "User: $row[2] </br>";
            echo "<hr>";
        }
    }
}    
?>