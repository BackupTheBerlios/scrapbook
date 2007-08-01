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
	$sSrchWrk = "";
	if ($x_salary <> "") {
		$sSrchWrk .= "x_salary=" . urlencode($x_salary);
		$sSrchWrk .= "&z_salary=" . urlencode($z_salary);
	}
	if ($sSrchWrk <> "") {
		if ($sSrchStr <> "") $sSrchStr .= "&";
		$sSrchStr .= $sSrchWrk;
	}	

	/*
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
	*/

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
<table width="459" border="0" cellspacing="0" cellpadding="0" >
 <tr>
  <td><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /></td>
 </tr>
 <tr>
  <td><div class="roundcont">
   <div class="roundtop"> <img class="corner" src="images/bl_01.gif" alt="edge" style=" display: none;" /></div>
   <h1>Job Search</h1>
   <div class="roundbottom"> <img src="images/bl_06.gif" alt="edge" class="corner" style=" display: none;" /></div>
  </div></td>
 </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top" width="445"><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /> </td>
 </tr>
  <td></td>
 </tr>
</table>
<form name="fjobsearch" id="fjobsearch" action="job_search.php" method="post"  style = "margin:0px;">
<input type="hidden" name="a_search" value="S">
<table class = "job">
    <tr>
        <td>Salary</td>
        <td>
			<input type="hidden" name="z_salary" value="=,','" />
        </td>
		<td>
		<select id='x_salary' name='x_salary'>
		<option value="">All</option>
		<?php
			   loadOptions("salary_list.htm",@$x_salary);
		?>
		</select>
		</td>	
		<!--
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
		-->
    </tr>
    <tr>
        <td>Position</td>
        <td>&nbsp;
            <input type="hidden" name="z_position" value="=,','" /></td>
        <td><select id='x_position' name='x_position'>
            <option value="">All</option>
            <?php
				loadOptions("position_list.htm",$x_position);
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
				loadOptions("county_list.htm",$x_location);
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
