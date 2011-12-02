<form name="chat" action="chat.php" method="post">
Message: <textarea rows="10" cols="30" wrap="physical" name="chatmsg">
Insert Chat Message Here!
</textarea></br>
Name: <input type="text" name="Name"></br>
<input type="submit" value="Submit Chat!">
</form>
<?php
$fname = "chat.txt";


if (isset($_POST[chatmsg]))
{
    $chatmsg = "Message:\n</br>".$_POST["chatmsg"]."\n</br>User:\n</br>".$_POST["Name"]."\n</br><hr>";
   file_put_contents($fname,$chatmsg, FILE_APPEND);
}    
$messages = file_get_contents ($fname);
printf("%s", $messages);


fclose($fp);



















?>