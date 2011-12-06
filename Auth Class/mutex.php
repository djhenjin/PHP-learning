<?php
require_once("config.php");


class Mutex
{
    private $mutexname;
    public function __construct($mutexname) {
        $this->mutexname = $mutexname;
    }
    public function lock() {
	$locked = FALSE;
	while($locked != TRUE) {
            $locks = file_get_contents("mutex.locks");
            $locks = explode("\r\n", $locks);
            if(array_search($this->mutexname, $locks, TRUE) !== FALSE) {
	        $locked = FALSE;
	    } else {
                file_put_contents("mutex.locks", $this->mutexname . "\r\n", FILE_APPEND | LOCK_EX);
	        $locked = TRUE;
	    }
        }
	return $locked;
    }
    public function unlock() {
        $locks = file_get_contents("mutex.locks");
        $locks = explode("\r\n", $locks);
        foreach($locks as $key => $value) {
            if($value == $this->mutexname) {
                unset($locks[$key]);
            }
        }
        $locks = implode("\r\n", $locks);
        return file_put_contents("mutex.locks", $locks, LOCK_EX);
    }   
}    
?>
