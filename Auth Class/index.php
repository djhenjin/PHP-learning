<?php
require_once("config.php");
require_once("classes.php");

if($_GET['page'] == 'login')
{
    echo " <form name=\"login\" action=\"index.php\" method=\"post\"> ";
    echo " Username: <input type=\"text\" name=\"username\"/> </br> ";
    echo " Password: <input type=\"text\" name=\"password\"/> </br> ";
    echo " <input type=\"submit\" value=\"Login\" /> </br> </form> ";
}
else if($_GET['page'] == 'register')
{
    echo "<form name=\"register\" action=\"index.php\" method=\"post\"> ";
    echo "Desired Username: <input type=\"text\" name=\"username\"/></br> ";
    echo "Password: <input type=\"text\" name=\"pass1\"/></br> ";
    echo "Re-confirm Password: <input type=\"text\" name=\"pass2\"/></br> ";
    echo "Email Address <input type=\"text\" name=\"email\"/></br> ";
    echo "<input type=\"submit\" value=\"Register\"/> </form></br> ";
}
else
{
    echo "<a href=\"http://testing.thesprocketworld.com/index.php?page=login\"> Have an account already?</a></br>";
    echo "<a href=\"http://testing.thesprocketworld.com/index.php?page=register\"> Need an account?</a></br>";
    
    
    
    
}


?>