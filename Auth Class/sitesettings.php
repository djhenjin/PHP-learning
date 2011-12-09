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
        $showsite->execute();
	$result = array();
        for($i = 0; $i < $showsite->rowCount(); $i++) {
		$result[i] = $showsite->fetch(PDO::FETCH_OBJ);
        }
	return $result;
    }
    public function AddSite($sitename, $siteurl, $viewsremain, $daylimit, $length, $balance, $advertiserid)
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
    public function AssignVisits($siteid, $visits)
    {
        global $dbhost, $dbname, $dbuser, $dbpass;
	/*
        $conn = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname . '', $dbuser, $dbpass);
        $currentviews = $conn->prepare("SELECT ViewsRemaining FROM sites WHERE SiteID = :siteid");
        $currentviews->bindParam(':siteid', $siteid);
        $currentviews->execute();
        $result = $currentviews(PDO::FETCH_ASSOC);
        $visitsadd = $result['ViewsRemaining'] + $visits;
        
        $assignviews = $conn->prepare("UPDATE sites SET ViewsRemaining = :visits WHERE SiteID = :siteid");
        $assignviews->bindParam(':visits', $visitsadd);
        $assignviews->bindParam(':siteid', $siteid);
        $assignviews->execute();
    	*/
	$conn = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $dbuser, $dbpass);
	$site = $conn->prepare("UPDTE sites SET ViewsRemaining += :visits WHERE SiteID = :siteid");
	$site->bindParam(':visits', $visits);
	$site->bindParam(':siteid', $siteid);
	$site->execute();
    }
    public function ModifySite($siteid, $modifications)
    {
        //function to modify a users site, needs to be created, currently placeholder.
    }
    public function UpdateUserBalance($userid, $modifications)
    {
        //function to update users balance, needs to be created, currently placeholder.
    }
    public function UpdateSiteBalance($siteid, $modifications)
    {
	
        //function to update sites balance, needs to be created, currently placeholder.
    }
    //should cover all remaining functions for this class. if any more need to be added, push to this file in above manner.
    
    
    
    
    
} 




?>
