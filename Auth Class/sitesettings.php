<?php
require_once('config.php');
//for hidden form use type="hidden" value and name only
class SiteSettings
{
    public function ModifyViewsPerDay($viewsperday, $siteid)
    {
        global $dbhost, $dbname, $dbpass, $dbuser;
        $conn = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname . '', $dbuser, $dbpass);
        $updateviews = $conn->prepare("UPDATE sites SET DayViewLimit = :viewsperday WHERE SiteID = :siteid");
        $updateviews->bindParam(':viewsperday', $viewsperday);
        $updateviews->bindParam(':siteid', $siteid);
        $updateviews->execute();
        
    }
    public function ViewSite($siteid)
    {
        global $dbhost, $dbname, $dbuser, $dbpass;
        $conn = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname . '', $dbuser, $dbpass);
        $showsite = $conn->prepare("SELECT * FROM sites WHERE SiteID = :siteid");
        $showsite->bindParam(':siteid', $siteid);
        $site = $showsite->execute();
        foreach($site as $results);
        {
            echo $results; 
        }
        
    }

} 






















?>