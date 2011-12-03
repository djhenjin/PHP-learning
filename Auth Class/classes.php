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

    function register($usrinfo)
    {
        global $dbhost, $dbname, $dbuser, $dbpass;
        try {
        $conn = new PDO('mysql:host=$dbhost;dbname=$dbname', $dbuser, $dbpass);
        $register = $conn->prepare ("INSERT INTO users (id,user, password, email, registrationdate, sessionid) VALUES ('', :user, :pass, :email, '','')");
        $register->bindParam(':user', $usrinfo['0']);
        $register->bindParam(':pass', $usrinfo['1']);
        $register->bindParam(':email', $usrinfo['2']);
        $register->execute();
        }catch (PDOException $e)
        {
            echo "An error occured!";
            die();
        }
    
    }
    
    function auth($sessionid)
    {
        global $dbhost, $dbname, $dbuser, $dbpass;
        $conn = new PDO('mysql:host=$dbhost;dbname=$dbname', $dbuser, $dbpass);
        $auth = $conn->prepare ("SELECT * FROM users WHERE sessionid = :sessionid");
        $auth->bindParam(':sessionid',$sessionid);
        if($auth->rowCount() == 1)
        {
            //keep connection alive
            
        }
        else
        {
            //require login again
        }
    
    
    }
    
    
    
    
    
    


}








?>