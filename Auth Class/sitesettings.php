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
    public function ViewSite($userid)
    {
        global $dbhost, $dbname, $dbuser, $dbpass;
        $conn = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname . '', $dbuser, $dbpass);
        $showsite = $conn->prepare("SELECT * FROM sites WHERE AdvertiserID = :advertiserid");
        $showsite->bindParam(':advertiserid', $userid);
        $site = $showsite->execute();
        foreach($site as $results);
        {
            echo $results;
        }
        
    }
    public function AddSite($siteinfo $holder $only $so $far)
    {
        global $dbhost, $dbname, $dbuser, $dbpass;
        $conn = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname . '', $dbuser, $dbpass);
        $newsite = $conn->prepare("INSERT INTO sites (SiteName, SiteUrl, ViewsRemaining, DayViewLimit, ViewLength, Balance)
        (:sitename, :siteurl, :viewsremain, :daylimit, :length, :balance) WHERE AdvertiserID = :advertiser");
        $newsite->bindParam(':sitename',$sitename);
        $newsite->bindParam(':siteurl',$siteurl);
        $newsite->bindParam(':viewsremain',$viewsremain);
        $newsite->bindParam(':daylimit',$daylimit);
        $newsite->bindParam(':length',$length);
        $newsite->bindParam(':balance',$balance);
        $newsite->bindParam(':advertiser',$advertiserid);
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
} 




?>