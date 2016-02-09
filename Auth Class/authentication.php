<?php
require_once("config.php");

class Authentication
{
    public function login($credentials)
    {
        global $dbhost, $dbname, $dbuser, $dbpass;
        
        $conn = new PDO(  'mysql:host=' . $dbhost . ';dbname=' . $dbname . '', $dbuser, $dbpass);
        $login = $conn->prepare ("SELECT * FROM users where user = :username AND password = :password AND validation = 'TRUE' ");
        $login->bindParam(':username', $credentials['0']);
        $login->bindParam(':password', $credentials['1']);
        $login->execute();
        if($login->rowCount() == 1)
        {
            $randkeytmp = $this->randkey();
            $randkey = $this->checkkey($randkeytmp);
            $randkey .= ":".$credentials['0'];
            $randkey .= ":".(time() + 300);
            setcookie("session", $randkey, time() + 3600  , "/", "testing.thesprocketworld.com");
            $sessionupdate = $conn->prepare ("UPDATE users SET sessionid = :randkey WHERE user = :username ");
            $sessionupdate->bindparam(':randkey', $randkey);
            $sessionupdate->bindparam(':username', $credentials['0']);
            $sessionupdate->execute();
            return TRUE;
        }
        else
        {
            return FALSE;
        }
   
    }
    public function referrer()
    {
        if(isset($_GET['ref']))
        {
            setcookie("referrer", $_GET['ref'], 0, "/", "testing.thesprocketworld.com");
        }
    }

    public function register($usrinfo)
    {
        global $dbhost, $dbname, $dbuser, $dbpass;
        
        $conn = new PDO(  'mysql:host=' . $dbhost . ';dbname=' . $dbname . '', $dbuser, $dbpass);
        $checkusr = $conn->prepare ("SELECT * FROM users WHERE user = :user");
        $checkusr->bindParam(':user', $usrinfo['0']);
        $checkusr->execute();
        $checkemail = $conn->prepare ("SELECT * FROM users WHERE email = :email");
        $checkemail->bindParam(':email', $usrinfo['2']);
        $checkemail->execute();
        
        if($checkusr->rowCount == 1 && $checkemail->rowCount == 1) 
        {
            return FALSE;
        }
        else
        {
            if(isset($_GET['ref']) || $_COOKIE['referer']))
            {   
                $referID = $conn->prepare("SELECT id FROM users WHERE user = :referer");
                $referID->bindParam(':referer', ((isset($_GET['ref']) ? $_GET['ref'] : $_COOKIE['referer']));
                $referID->execute();
                $results = $referID->fetch(PDO::FETCH_ASSOC);
                $referer = $results['id'];
                
            }
            else
            {
                $referer = 0;
            }
            $validationkey = sha1($usrinfo['0'].$this->randkey());
            $register = $conn->prepare ("INSERT INTO users (id,user, password, email, sessionid, validation, referedBy) VALUES ('', :user, :pass, :email, '',:validationkey,:referer)");
            $register->bindParam(':user', $usrinfo['0']);
            $register->bindParam(':pass', $usrinfo['1']);
            $register->bindParam(':email', $usrinfo['2']);
            $register->bindParam(':validationkey', $validationkey);
            $register->bindParam(':referer', $referer);
            $register->execute();
            $message = "thank you for registering at testing.thesprocketworld.com, Please click the following link to activate your account:";
            $message .= " http://testing.thesprocketworld.com/index.php?activate=".$validationkey ;
            mail($usrinfo['2'],'testing.thesprocketworld.com Confirmation Email',$message, 'From: djhenjin@thesprocketworld.com (DJHenjin)');
            
            return TRUE;
        }
        
    
    }
    
    public function checkemailconf($emailkey)
    {
        global $dbhost, $dbname, $dbuser, $dbpass;
        $conn = new PDO (  'mysql:host=' . $dbhost . ';dbname=' . $dbname . '', $dbuser, $dbpass);
        $validate = $conn->prepare ("UPDATE users SET validation = 'TRUE' WHERE validation = :emailkey");
        $validate->bindParam(":emailkey", $emailkey);
        $validate->execute();
        if($validate->rowcount() == 1)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function auth($sessionid)
    {
		if(empty($sessionid)) return FALSE;
        $username = $this->loggedin($_COOKIE['session']);
        global $dbhost, $dbname, $dbuser, $dbpass;
        $conn = new PDO(  'mysql:host=' . $dbhost . ';dbname=' . $dbname . '', $dbuser, $dbpass);
        $auth = $conn->prepare ("SELECT * FROM users WHERE sessionid = :sessionid AND validation = 'TRUE' ");
        $auth->bindParam(':sessionid',$sessionid);
        $auth->execute();
        if($auth->rowCount() == 1)
        {
            $timestamp = $this->loggedin($_COOKIE['session']);
            $timestamp = $timestamp['2'];
            if($timestamp < time())
            {
                $result = $auth->fetch(PDO::FETCH_ASSOC);
                $user = $result['user'];
                $newsess = $this->randkey();
                $newsessionid = $this->checkkey($newsess);
                $newsessionid .= ":".$user;
                $newsessionid .= ":".(time() + 300);
                $updatesessionid = $conn->prepare ("UPDATE users SET sessionid = :newid WHERE user = :user");
                $updatesessionid->bindParam(':newid', $newsessionid);
                $updatesessionid->bindParam(':user', $user);
                $updatesessionid->execute();
                setcookie("session", $newsessionid, time() + 3600, "/", "testing.thesprocketworld.com");
            }    

            return TRUE;
        }
        else
        {
            setcookie("session", "expired", time()+0, "/", "testing.thesprocketworld.com");

            return FALSE;
        }
    
    
    }
    public function randkey()
    {
        $options = "abcdefghijklmnopqrstuvwxyz0123456789";
        for($i = 0; $i < 20; $i++) 
        { 
            $nums[$i] = mt_rand(0, 35); 
        } 
            for($i = 0; $i < 20; $i++) 
        { 
            $key[$i] = mb_substr($options, $i, 1);
        }
        $key = implode($key);
        return $key;
    
    }
    public function checkkey($authkey)
    {
        global $dbhost, $dbname, $dbuser, $dbpass;
        $conn = new PDO(  'mysql:host=' . $dbhost . ';dbname=' . $dbname . '', $dbuser, $dbpass);
        $checkkey = $conn->prepare ("SELECT * FROM users WHERE sessionid = :sessionid");
        $checkkey->bindParam(':sessionid', $authkey);
        $checkkey->execute();
        if ($checkkey->rowCount() == 1)
        {
            return $this->checkkey($this->randkey());
        }
        else
        {
            return $authkey;
        }    
    
    }
    public function logout()
    {
        setcookie("session", "expired", time()+0, "/", "testing.thesprocketworld.com");
    }    
    public function loggedin($sessionid)
    {
        $logged = explode(":",$sessionid);
        
        return $logged;
        
    }
}

?>
