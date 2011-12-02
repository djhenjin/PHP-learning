<form name="chat" action="chat.php" method="post">
Message: <textarea rows="10" cols="30" wrap="physical" name="chatmsg">
Insert Chat Message Here!
</textarea></br>
Name: <input type="text" name="Name"></br>
<input type="submit" value="Submit Chat!">
</form>
<?php

$fname = "chat.txt";
$fp = fopen("chat.txt", "a+");
if (!$fp) die("Unable to create file.");

fwrite($fp, "This is a test.\n");

/*
if (isset$_POST)
{
    foreach(file($fname, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line)
        {
            echo $line;
        }


}
    
*/
fclose($fp);



















?>