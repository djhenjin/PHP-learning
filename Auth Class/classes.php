<?php
require_once("config.php");


class Authentication
{
    function login($credentials)
    {
        global $dbhost, $dbname, $dbuser, $dbpass;
        
        $conn = new PDO('mysql:host=$dbhost;dbname=$dbname', $dbuser, $dbpass );
        $login = $conn->prepare ("SELECT * FROM users where user = :username AND password = :password")
        $login->bindParam(':username', $credentials['user']);
        $login->bindParam(':password', $credentials['passhashed']);
        $result = $login->execute();
        if(isset($result))
        {
            setcookie("session", $randkey, "0", "/", "testing.thesprocketworld.com");
            $sessionupdate = $conn->prepare ("INSERT INTO sessions (id, user, sessionid) VALUES (,, $randkey, $credentials['user'])");
        }
        else
        {
            echo "Failed to Login, Please make sure to supply correct User and Password";
        }
            
        
        
        
        
        
        
    
    }

    
    
    
    
    
    
    
    
    


}








?>