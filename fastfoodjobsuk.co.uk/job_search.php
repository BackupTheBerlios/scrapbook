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
	$salary_range = @$_POST["salary_range"];

	if (strstr ($salary_range, ","))
	{

		$arrSalary = split(",",$salary_range);
		$x_salary = $arrSalary[0];
		$y_salary = $arrSalary[1];

		$z_salary = (get_magic_quotes_gpc()) ? stripslashes(@$_POST["z_salary"]) : @$_POST["z_salary"]; 
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

	ob_end_clean();
	if ($sSrchStr <> "") {
		header("Location: joblist.php" . "?" . $sSrchStr);
	}
	else //get all
	{
		header("Location: joblist.php?cmd=reset");

	}
	exit();
	break;
	default: // Restore search settings
	//nothing
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
        <td>Yearly Salary</td>
        <td> <input type="hidden" name="z_salary" value="BETWEEN,," />
        	<input type="hidden" name="w_salary" value="AND,," />
        </td>
        <td><select name="salary_range" id="salary_range" >
            <option value="">All</option>
            <option value="0,15000">Under &pound;15k</option>
            <option value="15000,20000">&pound;15k - &pound;20k</option>
            <option value="20000,25000">&pound;20k - &pound;25k</option>
            <option value="25000,30000">&pound;25k - &pound;30k</option>
            <option value="30000,9999999">&pound;30K and over</option>
        </select>
        </td>
    </tr>
    <tr>
        <td>Position</td>
        <td>&nbsp;
            <input type="hidden" name="z_position" value="=,','" /></td>
        <td><select id='x_position' name='x_position'>
            <option value="">All</option>
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
      ?>
        </select>
        </td>
    </tr>
    <tr>
        <td>Location</td>
        <td>&nbsp;
            <input type="hidden" name="z_location" value="=,','" /></td>
        <td><select d='x_location' name='x_location'>
            <option value=''>All</option>
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
        </select></td>
    </tr>
</table>
<p>
<input type="submit" name="Action" value="Search">
</form>
<?php include ("bottom.php") ?>
<?php
phpmkr_db_close($conn);
?>
