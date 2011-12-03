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
    function randkey()
    {
        
        for($i = 0; $i < 20; $i++) 
        { 
            $nums[$i] = mt_rand(1, 30); 
        } 
            for($i = 0; $i < 20; $i++) 
        { 
            switch($nums[$i]) 
            { 
                case 1: $key[$i] = 'a'; 
                break;
                case 2: $key[$i] = 'b';
                break;
                case 3: $key[$i] = 'c';
                break;
                case 4: $key[$i] = 'd';
                break;
                case 5: $key[$i] = 'e'; 
                break;
                case 6: $key[$i] = 'f';
                break;
                case 7: $key[$i] = 'g';
                break;
                case 8: $key[$i] = 'h';
                break;
                case 9: $key[$i] = 'i';
                break;
                case 10: $key[$i] = 'j';
                break;
                case 11: $key[$i] = 'k'; 
                break;
                case 12: $key[$i] = 'l';
                break;
                case 13: $key[$i] = 'm';
                break;
                case 14: $key[$i] = 'n';
                break;
                case 15: $key[$i] = 'o'; 
                break;
                case 16: $key[$i] = 'p';
                break;
                case 17: $key[$i] = 'q';
                break;
                case 18: $key[$i] = 'r';
                break;
                case 19: $key[$i] = 's';
                break;
                case 20: $key[$i] = 't';
                break;
                case 21: $key[$i] = 'u'; 
                break;
                case 22: $key[$i] = 'v';
                break;
                case 23: $key[$i] = 'w';
                break;
                case 24: $key[$i] = 'x';
                break;
                case 25: $key[$i] = 'y'; 
                break;
                case 26: $key[$i] = 'z';
                break;
                case 27: $key[$i] = '0';
                break;
                case 28: $key[$i] = '1';
                break;
                case 29: $key[$i] = '2';
                break;
                case 30: $key[$i] = '3';
                break;
                
            }
        }
        $key = implode($key);
        return $key;
    
    }
    
    
    
    
    
    


}








?>