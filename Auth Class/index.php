<?php
header('Refresh: 120');
echo "<html>\r\n"
$head = "<head>\r\n" .
	"	<title>Chat</title>\r\n" .
		// Requires JQuery.js in the same folder as index.php
	"	<script src=\"jquery.js\"></script>\r\n" .
	"	<script>\r\n".
	"		$(document).ready(function() {\r\n".
        		//ajaxTime.php is called every second to get time from server
        "		var refreshId = setInterval(function() {\r\n".
	"			$('#Messages').load('loadMessagesFromDB.php');\r\n".
	"		}, 30000);\r\n" .
	"	});\r\n".
	"	</script>\r\n" .
	"</head>";
echo $head;
ob_start();
require_once("config.php");
require_once("authentication.php");
require_once("chat.php");
$session = new Authentication();
$chat = new Chat();


if($session->auth($_COOKIE['session'])) 
{
    echo " <a href=\"http://testing.thesprocketworld.com/index.php?action=logout\"> Logout</a></br>\r\n";
    echo " <a href=\"http://testing.thesprocketworld.com/index.php\"> Refresh This Page</a></br>\r\n";
    if($_GET['action'] == 'logout')
    {
        $session->logout();
        header("Location: index.php?msg=loggedout");
    }    

    
    echo "<form name=\"chat\" action=\"index.php\" method=\"post\">\r\n";
    echo "Message: <textarea rows=\"10\" cols=\"40\" wrap=\"physical\" name=\"chatmsg\"></textarea></br>\r\n";
    echo "<input type=\"submit\" value=\"Submit Chat!\"></form>\r\n";
    if(isset($_POST['chatmsg']))
    {
        $message = $_POST['chatmsg'];
        $sessionid = $_COOKIE['session'];
        $user = $session->loggedin($sessionid);
        $chat->submitchat($user['1'], $message);
        
    }
    $chat->displaychat();
} 
else 
{
    echo "<a href=\"http://testing.thesprocketworld.com/index.php?page=login\"> Have an account already?</a></br>\r\n";
    echo "<a href=\"http://testing.thesprocketworld.com/index.php?page=register\"> Need an account?</a></br>\r\n";

    if($_GET['page'] == 'login')
    {
        echo " <form name=\"login\" action=\"index.php?action=login\" method=\"post\">\r\n";
        echo " Username: <input type=\"text\" name=\"username\"/> </br>\r\n";
        echo " Password: <input type=\"password\" name=\"password\"/> </br>\r\n";
        echo " <input type=\"submit\" value=\"Login\" /> </br> </form> \r\n";
    }
    else if($_GET['page'] == 'register')
    {
        echo "<form name=\"register\" action=\"index.php?action=register\" method=\"post\"> \r\n";
        echo "Desired Username: <input type=\"text\" name=\"username\"/></br> \r\n";
        echo "Password: <input type=\"password\" name=\"pass1\"/></br> \r\n";
        echo "Re-confirm Password: <input type=\"password\" name=\"pass2\"/></br> \r\n";
        echo "Email Address <input type=\"text\" name=\"email\"/></br> \r\n";
        echo "<input type=\"submit\" value=\"Register\"/> </form></br> \r\n";
    }
    else if($_GET['action'] == 'register')
    {
        $usrinfo['0'] = $_POST['username'];
        $usrinfo['1'] = sha1($_POST['pass1']);
        $usrinfo['2'] = $_POST['email'];
        if($session->register($usrinfo))
        {
            echo "Thank you for registering!\r\n";
        }
        else
        {
            echo "Please <a href=\"testing.thesprocketworld.com/index.php?page=register\"> Try Again</a>\r\n";
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
            echo "A Problem occured, Please <a href=\"http://testing.thesprocketworld.com/index.php?page=login\"> Try again</a></br>\r\n";
            echo "Or check your email for the Activation Link.\r\n";
        }
    
    }
    else if($_GET['activation'])
    {
        
        if($session->checkemailconf($_GET['activation']))
        {
            echo "Your account has been activated\r\n";
        }
        else
        {
            echo "Something went wrong, Please try that again or contact the administrator\r\n";
        }
    
    }
    

}
echo "</html>";
ob_end_flush();
?>
