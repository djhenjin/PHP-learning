<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //display form here
    echo "<form name='usrinfo' action='session.php' method='post'>";
    echo "Username: <input type='text' name='usrname'></br></input>";
    echo "FakePass: <input type='text' name='fakepass'></br></input>";
    echo "<input type='submit' value='Submit!' /></br></form>";
    




}
else
{   

    $_SESSION['usr'] = $_POST['usrname'];
    $_SESSION['pass'] = $_POST['fakepass'];
    $_SESSION['time'] = time();
    
    
    $sessionid = session_id();
    echo "Session ID: ".$sessionid." </br>";
    echo "Username: ".$_SESSION['usr']." </br>";
    echo "FakePass: ".$_SESSION['pass']." </br>";
    echo "Time Started: ".$_SESSION['time']." </br>";
}
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();
session_write_close();
?>
