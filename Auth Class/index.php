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
else
{
    echo "get not set yet";
}


?>