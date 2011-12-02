<form name="selectleaderboard" action="index.php" method="post">
<select name="test">
<option value="ALL.mcmmo">All</option>
<option value="ARCHERY.mcmmo">Archery</option>
<option value="ACROBATICS.mcmmo">Acrobatics</option>
<option value="AXES.mcmmo">Axes</option>
<option value="EXCAVATION.mcmmo">Excavation</option>
<option value="HERBALISM.mcmmo">Herbalism</option>
<option value="MINING.mcmmo">Mining</option>
<option value="REPAIR.mcmmo">Repair</option>
<option value="SWORDS.mcmmo">Swords</option>
<option value="TAMING.mcmmo">Taming</option>
<option value="UNARMED.mcmmo">Unarmed</option>
<option value="WOODCUTTING.mcmmo">Woodcutting</option>
</select>
<input type="submit" value="Submit" />

</form> 

<table border="0" width="75%" cellpadding="5" cellspacing="5">
<tr>
<td align="center">Player</td>
<td align="center">Score</td>
</tr>


<?php
//------------------------------------------------------------------//
// $dir is the only thing you need to change to have this script working on your server
//change /var/www/.../testing/datadir to /path/to/your/Leaderboard folder in your MCMMO folder
//$dir is case sensitive so make sure you get the case right.
$dir = "/var/www/vhosts/thesprocketworld.com/thesprocketworld.com/httpdocs/subdomains/testing/datadir";
//in between the <?php tag and the bottom of the file to use HTML code you must use it in the following format
// echo "<h1>header1</h1>"; above the <?php tag you can use raw HTML as normal
chdir($dir);

    
    $selection = $_POST[test];
    if (empty($selection))
    {
        $selection = "ALL.mcmmo";
    }
    $leaderboard = explode('.', $selection);
    $str = mb_convert_case($leaderboard[0], MB_CASE_TITLE, "UTF-8");
    echo "You are vieweing: $str </br>";
    
    $fname = $dir."/".$selection;
    foreach(file($fname, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line)
        {
        $exploded = explode(':', $line);
        $lines[] = $exploded;
        $lsort[] = $exploded[1];
        }

        array_multisort($lsort, SORT_DESC, SORT_NUMERIC, $lines);

        foreach($lines as $row)
        {
            echo '<tr>';
            echo '<td align="center">'.$row[0].'</td>';
            echo '<td align="center">'.$row[1].'</td>';
            echo '</tr>';

        }

?>