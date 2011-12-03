<?php
require_once("config.php");


class Authentication
{
    function login($credentials, $randkey)
    {
        global $dbhost, $dbname, $dbuser, $dbpass;
        
        $conn = new PDO('mysql:host=$dbhost;dbname=$dbname', $dbuser, $dbpass );
        $login = $conn->prepare ("SELECT * FROM users where user = :username AND password = :password")
        $login->bindParam(':username', $credentials['0']);
        $login->bindParam(':password', $credentials['1']);
        
        if($login->rowCount() == 1)
        {
            setcookie("session", $randkey, "0", "/", "testing.thesprocketworld.com");
            $sessionupdate = $conn->prepare ("UPDATE users SET sessionid = ':randkey' WHERE user = :username ");
            $sessionupdate->bindparam(':randkey', $randkey);
            $sessionupdate->bindparam(':username', $credentials['0']);
            $sessionupdate->execute();
        }
        else
        {
            echo "Failed to Login, Please make sure to supply correct User and Password";
        }
   
    }

    
    
    
    
    
    
    
    
    


}








?>