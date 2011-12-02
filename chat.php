<form name="chat" action="chat.php" method="post">
Message: <textarea rows="10" cols="30" wrap="physical" name="chatmsg">
Insert Chat Message Here!
</textarea></br>
Name: <input type="text" name="Name"></br>
<input type="submit" value="Submit Chat!">
</form>
<?php

$fname = "chat.txt";
$seperator = "-------------------------------------- \n";

if (isset($_POST[chatmsg]))
{
    $chatmsg = $_POST[chatmsg]."\n";
    $name = $_POST[Name]."\n";
   file_put_contents($fname,$chatmsg , FILE_APPEND);
   file_put_contents($fname,$name , FILE_APPEND);
   file_put_contents($fname,$seperator , FILE_APPEND);
}    
$messages = file_get_contents ($fname);
echo $messages;


fclose($fp);



















?>