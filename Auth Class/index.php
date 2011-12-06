<?php
require_once("config.php");
require_once("authentication.php");
require_once("chat.php");
$session = new Authentication();
$chat = new Chat();


if($session->auth($_COOKIE['session'])) 
{
	echo " <a href=\"http://testing.thesprocketworld.com/index.php?action=logout\"> Logout</a>";
    if($_GET['action'] == 'logout')
    {
        $session->logout();
        header("Location: index.php?msg=loggedout");
    }    

    echo "<form name=\"chat\" action=\"index.php\" method=\"post\">";
    echo "Message: <textarea rows=\"10\" cols=\"40\" wrap=\"physical\" name=\"chatmsg\"></textarea></br>";
    echo "<input type=\"submit\" value=\"Submit Chat!\"></form>";
    if(isset($_GET['chatmsg']))
    {
        $message = $_POST['chatmsg'];
        $user = $session->loggedin($_COOKIE['session']);
        $chat->submitchat($user, $message);
        echo $user;
    }
    $chat->displaychat();
} 
else 
{
    echo "<a href=\"http://testing.thesprocketworld.com/index.php?page=login\"> Have an account already?</a></br>";
    echo "<a href=\"http://testing.thesprocketworld.com/index.php?page=register\"> Need an account?</a></br>";

    if($_GET['page'] == 'login')
    {
        echo " <form name=\"login\" action=\"index.php?action=login\" method=\"post\"> ";
        echo " Username: <input type=\"text\" name=\"username\"/> </br> ";
        echo " Password: <input type=\"text\" name=\"password\"/> </br> ";
        echo " <input type=\"submit\" value=\"Login\" /> </br> </form> ";
    }
    else if($_GET['page'] == 'register')
    {
        echo "<form name=\"register\" action=\"index.php?action=register\" method=\"post\"> ";
        echo "Desired Username: <input type=\"text\" name=\"username\"/></br> ";
        echo "Password: <input type=\"text\" name=\"pass1\"/></br> ";
        echo "Re-confirm Password: <input type=\"text\" name=\"pass2\"/></br> ";
        echo "Email Address <input type=\"text\" name=\"email\"/></br> ";
        echo "<input type=\"submit\" value=\"Register\"/> </form></br> ";
    }
    else if($_GET['action'] == 'register')
    {
        $usrinfo['0'] = $_POST['username'];
        $usrinfo['1'] = sha1($_POST['pass1']);
        $usrinfo['2'] = $_POST['email'];
        if($session->register($usrinfo))
        {
            echo "Thank you for registering!";
        }
        else
        {
            echo "Please <a href=\"testing.thesprocketworld.com/index.php?page=register\"> Try Again</a>";
        }
        
    }
    else if($_GET['action'] == 'login')
    {
        $credentials['0'] = $_POST['username'];
        $credentials['1'] = sha1($_POST['password']);
        if($session->login($credentials) == TRUE)
        {
            header("Location: index.php?msg=loggedin");
        }
        else
        {
            echo "A Problem occured, Please <a href=\"http://testing.thesprocketworld.com/index.php?page=login\"> Try again</a></br>";
            echo "Or check your email for the Activation Link.";
        }
    
    }
    else if($_GET['activation'])
    {
        
        if($session->checkemailconf($_GET['activation']))
        {
            echo "Your account has been activated";
        }
        else
        {
            echo "Something went wrong, Please try that again or contact the administrator";
        }
    
    }
    

}









?>