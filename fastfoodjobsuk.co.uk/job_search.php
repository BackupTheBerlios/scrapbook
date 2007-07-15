<?php 
require("common_all.php");
ob_start();
?>
<?php include ("jobinfo.php") ?>

<?php

// Get action
$sAction = @$_POST["a_search"];
switch ($sAction) {
	case "S": // Get search criteria

	// Build search string for advanced search, remove blank field
	$sSrchStr = "";

	// Field position
	$x_position = @$_POST["x_position"];
	$z_position = (get_magic_quotes_gpc()) ? stripslashes(@$_POST["z_position"]) : @$_POST["z_position"]; 
	$sSrchWrk = "";
	if ($x_position <> "") {
		$sSrchWrk .= "x_position=" . urlencode($x_position);
		$sSrchWrk .= "&z_position=" . urlencode($z_position);
	}
	if ($sSrchWrk <> "") {
		if ($sSrchStr <> "") $sSrchStr .= "&";
		$sSrchStr .= $sSrchWrk;
	}

	// Field salary
	$x_salary = @$_POST["x_salary"];
	$z_salary = (get_magic_quotes_gpc()) ? stripslashes(@$_POST["z_salary"]) : @$_POST["z_salary"]; 
	$y_salary = @$_POST["y_salary"];
	$w_salary = (get_magic_quotes_gpc()) ? stripslashes(@$_POST["w_salary"]) : @$_POST["w_salary"]; 
	$sSrchWrk = "";
	if ($x_salary <> "") {
		$sSrchWrk .= "x_salary=" . urlencode($x_salary);
		$sSrchWrk .= "&z_salary=" . urlencode($z_salary);
	}
	if ($y_salary <> "" ) {
		if ($sSrchWrk <> "") { $sSrchWrk .= "&";}
		$sSrchWrk .= "y_salary=" . urlencode($y_salary);
		$sSrchWrk .= "&w_salary=" . urlencode($w_salary);
	}
	if ($sSrchWrk <> "") {
		if ($sSrchStr <> "") $sSrchStr .= "&";
		$sSrchStr .= $sSrchWrk;
	}

	// Field location
	$x_location = @$_POST["x_location"];
	$z_location = (get_magic_quotes_gpc()) ? stripslashes(@$_POST["z_location"]) : @$_POST["z_location"]; 
	$sSrchWrk = "";
	if ($x_location <> "") {
		$sSrchWrk .= "x_location=" . urlencode($x_location);
		$sSrchWrk .= "&z_location=" . urlencode($z_location);
	}
	if ($sSrchWrk <> "") {
		if ($sSrchStr <> "") $sSrchStr .= "&";
		$sSrchStr .= $sSrchWrk;
	}
	if ($sSrchStr <> "") {
		ob_end_clean();
		header("Location: joblist.php" . "?" . $sSrchStr);
		exit();
	}
	break;
	default: // Restore search settings
		$x_position = @$_SESSION[ewSessionTblAdvSrch . "_x_position"];
		$x_salary = @$_SESSION[ewSessionTblAdvSrch . "_x_salary"];
		$y_salary = @$_SESSION[ewSessionTblAdvSrch . "_y_salary"];
		$x_location = @$_SESSION[ewSessionTblAdvSrch . "_x_location"];
}

// Open connection to the database
$conn = phpmkr_db_connect(HOST, USER, PASS, DB, PORT);
?>
<?php include ("top.php") ?>
<script type="text/javascript" src="scripts/ewp.js"></script>
<script type="text/javascript">
<!--
EW_dateSep = "/"; // set date separator
//-->
</script>
<script type="text/javascript">
<!--
function EW_checkMyForm(EW_this) {
if (EW_this.x_salary && !EW_checkinteger(EW_this.x_salary.value)) {
	if (!EW_onError(EW_this, EW_this.x_salary, "TEXT", "Incorrect integer - salary"))
		return false; 
}
return true;
}

//-->
</script>
<p>Job Search<br>
    <br>
</p>
<form name="fjobsearch" id="fjobsearch" action="job_search.php" method="post" onsubmit="return EW_checkMyForm(this);">
<p>
<input type="hidden" name="a_search" value="S">
<table>
	<tr>
	    <td>Position</td>
		    <td>&nbsp;</td>
		    <td> <select id='x_position' name='x_position'>
            <option value="all">All</option>
                  <?php
        if (isset($x_position)){
          $f=fopen("position_list.htm","r");
          while (!feof($f)){
            $d=fgets($f);
            $start=strpos($d,"\"")+1;
            $end=strrpos($d,"\"");
            $val=substr($d,$start,$end-$start);
            if ($val==$x_position){
              $newD=substr($d,0,$end+1);
              $newD.=" SELECTED";
              $newD.=substr($d,$end+1);
              $d=$newD;
            }
            echo $d;
          }
          fclose($f);
        } else {
          require("position_list.htm");
        }
      ?></select>
		        <input type="hidden" name="z_position" value="=,," />   </td>
	    </tr>
	<tr>
	    <td>Salary</td>
		    <td>between
	        <input type="hidden" name="z_salary" value="BETWEEN,,"></td>
		    <td>                <input type="text" name="x_salary" id="x_salary" size="30" value="<?php echo htmlspecialchars(@$x_salary) ?>">    </td>
	    </tr>
	<tr>
	    <td align="right">&nbsp;	        </td>
		    <td>and
	        <input type="hidden" name="w_salary" value="AND,,"></td>
		    <td>                <input type="text" name="y_salary" id="y_salary" size="30" value="<?php echo htmlspecialchars(@$y_salary) ?>">    </td>
	    </tr>
	<tr>
	    <td>Location</td>
		    <td>&nbsp;</td>
		    <td>       <select d='x_location' name='x_location'>
            <option value='all'>All</option>
      <?php
        if (isset($x_location)){
          $f=fopen("county_list.htm","r");
          while (!feof($f)){
            $d=fgets($f);
            $start=strpos($d,"\"")+1;
            $end=strrpos($d,"\"");
            $val=substr($d,$start,$end-$start);
            if ($val==$x_location){
              $newD=substr($d,0,$end+1);
              $newD.=" SELECTED";
              $newD.=substr($d,$end+1);
              $d=$newD;
            }
            echo $d;
          }
          fclose($f);
        } else {
          require("county_list.htm");
        }
      ?>
      </select>
		        <input type="hidden" name="z_location" value="=,','" /></td>
	    </tr>
</table>
<p>
<input type="submit" name="Action" value="Search">
</form>
<?php include ("bottom.php") ?>
<?php
phpmkr_db_close($conn);
?>
