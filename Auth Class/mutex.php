<?php
require_once("config.php");


class Mutex
{
    public function mutexlock($username) 
    {
        $locks = file_get_contents(mutex.text);
        $locks = explode(" ", $locks);
        foreach($locks as $name);
        {
            if($name == $username)
            {
                //loop
            }
            
        }
        
    }
        
    
}    
?>