<?php 
require("common_user.php");
ob_start();
?>
<?php include ("cvinfo.php") ?>
<?php include ("ewupload.php") ?>
<?php
// Get key
$x_cvid = @$_GET["cvid"];
if (($x_cvid == "") || (is_null($x_cvid))) {
	ob_end_clean();
	header("Location: cvlist.php");
	exit();
}
if (!is_numeric($x_cvid)) {
	ob_end_clean();
	header("Location: cvlist.php");
	exit();
}

// Get action
$sAction = @$_POST["a_view"];
if (($sAction == "") || ((is_null($sAction)))) {
	$sAction = "I";	// Display record
}

// Open connection to the database
$conn = phpmkr_db_connect(HOST, USER, PASS, DB, PORT);
switch ($sAction)
{
	case "I": // Display record
		if (!LoadData($conn)) { // Load record
			$_SESSION[ewSessionMessage] = "No records found";
			phpmkr_db_close($conn);
			ob_end_clean();
			header("Location: cvlist.php");
			exit();
		}
}
?>
<?php include ("top.php"); ?>
<script type="text/javascript" src="scripts/ewp.js"></script>
 <h2 style = "margin-left:5px;">View CV</h2>
<a href="cvlist.php">Back to List</a>&nbsp;
<a href="<?php if ($x_cvid <> "") {echo "cvedit.php?cvid=" . urlencode($x_cvid); } else { echo "javascript:alert('Invalid Record! Key is null');";} ?>">Edit</a>&nbsp;
</span></p>
<p>
<form>
<table class="ewTable">
	<tr>
		<td class="ewTableHeader"><span>cvid</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_cvid; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>onlineuserid</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_onlineuser_onlineuserid; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Picture</span></td>
		<td class="ewTableRow"><span>
<?php if ((!is_null($x_picture)) &&  $x_picture <> "") { ?>
<a href="<?php echo ewUploadPathEx(False, EW_UploadDestPath) . $x_picture ?>"><?php echo $x_picture; ?></a>
<?php } ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>First Name</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_first_name; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Middle Name</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_mid_name; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Last Name</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_last_name; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Age</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_age; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Sex</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_sex; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Nationality</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_nationality; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Legally entitled to work in UK</span></td>
		<td class="ewTableRow"><span>
<?php
switch ($x_is_legal) {
	case "1":
		$sTmp = "yes";
		break;
	case "0":
		$sTmp = "no";
		break;
	default:
		$sTmp = "";
}
$ox_is_legal = $x_is_legal; // Backup original value
$x_is_legal = $sTmp;
?>
<?php echo $x_is_legal; ?>
<?php $x_is_legal = $ox_is_legal; // Restore original value ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>No of years residence in UK</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_years_of_residence; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Address line 1</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_address_1; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>line 2</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_address_2; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>line 3</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_address_3; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Post code</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_postcode; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Email Address</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_email; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Mobile number</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_mobile; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Land line number</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_tel; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Current Employer</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_employer; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Full clean UK driving license </span></td>
		<td class="ewTableRow"><span>
<?php
switch ($x_uk_license) {
	case "1":
		$sTmp = "yes";
		break;
	case "0":
		$sTmp = "no";
		break;
	default:
		$sTmp = "";
}
$ox_uk_license = $x_uk_license; // Backup original value
$x_uk_license = $sTmp;
?>
<?php echo $x_uk_license; ?>
<?php $x_uk_license = $ox_uk_license; // Restore original value ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>European license held</span></td>
		<td class="ewTableRow"><span>
<?php
switch ($x_european_license) {
	case "1":
		$sTmp = "yes";
		break;
	case "0":
		$sTmp = "no";
		break;
	default:
		$sTmp = "";
}
$ox_european_license = $x_european_license; // Backup original value
$x_european_license = $sTmp;
?>
<?php echo $x_european_license; ?>
<?php $x_european_license = $ox_european_license; // Restore original value ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Number of points on license</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_license_points; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Marital Status</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_marital_status; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Any dependents</span></td>
		<td class="ewTableRow"><span>
<?php
switch ($x_has_dependent) {
	case "1":
		$sTmp = "yes";
		break;
	case "0":
		$sTmp = "no";
		break;
	default:
		$sTmp = "";
}
$ox_has_dependent = $x_has_dependent; // Backup original value
$x_has_dependent = $sTmp;
?>
<?php echo $x_has_dependent; ?>
<?php $x_has_dependent = $ox_has_dependent; // Restore original value ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Willing to relocate</span></td>
		<td class="ewTableRow"><span>
<?php
switch ($x_can_relocate) {
	case "1":
		$sTmp = "yes";
		break;
	case "0":
		$sTmp = "no";
		break;
	default:
		$sTmp = "";
}
$ox_can_relocate = $x_can_relocate; // Backup original value
$x_can_relocate = $sTmp;
?>
<?php echo $x_can_relocate; ?>
<?php $x_can_relocate = $ox_can_relocate; // Restore original value ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Willing to travel</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_can_travel; ?> miles
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Current Employment Status</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_employement_status; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Current work location</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_work_location; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Current / Last position held</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_position_held; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Current / last salary</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_salary; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Current / last annual bonus paid </span></td>
		<td class="ewTableRow"><span>
<?php echo $x_bonus; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Ambitions within next 2-3 years</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_ambitions; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Salary Expectations Start</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_salary_expectation_start; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Within a year</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_salary_expectation_one; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Within 2-3 years</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_salary_expectation_two; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Achievement last 12 months Sales</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_achievement_sales; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Food Cost</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_achievement_food; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Labour Cost</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_achievement_labour; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Interests / Hobbies</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_interests; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Qualifications Held</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_qualifications; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Tell us about yourself: max 50 words</span></td>
		<td class="ewTableRow"><span>
<?php echo str_replace(chr(10), "<br>", $x_tell_us); ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Notice required in current position</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_notice; ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>Date created</span></td>
		<td class="ewTableRow"><span>
<?php echo FormatDateTime($x_dt_created,5); ?>
</span></td>
	</tr>
	<tr>
		<td class="ewTableHeader"><span>CV Status</span></td>
		<td class="ewTableRow"><span>
<?php echo $x_cv_status; ?>
</span></td>
	</tr>
</table>
</form>
<p>
<?php include ("bottom.php") ?>
<?php
phpmkr_db_close($conn);
?>
<?php

//-------------------------------------------------------------------------------
// Function LoadData
// - Variables setup: field variables

function LoadData($conn)
{
	global $x_cvid;
	$sFilter = ewSqlKeyWhere;
	if (!is_numeric($x_cvid)) return false;
	$x_cvid =  (get_magic_quotes_gpc()) ? stripslashes($x_cvid) : $x_cvid;
	$sFilter = str_replace("@cvid", AdjustSql($x_cvid), $sFilter); // Replace key value
	$sSql = ewBuildSql(ewSqlSelect, ewSqlWhere, ewSqlGroupBy, ewSqlHaving, ewSqlOrderBy, $sFilter, "");
	$rs = phpmkr_query($sSql,$conn) or die("Failed to execute query at line " . __LINE__ . ": " . phpmkr_error($conn) . '<br>SQL: ' . $sSql);
	if (phpmkr_num_rows($rs) == 0) {
		$bLoadData = false;
	} else {
		$bLoadData = true;
		$row = phpmkr_fetch_array($rs);

		// Get the field contents
		$GLOBALS["x_cvid"] = $row["cvid"];
		$GLOBALS["x_onlineuser_onlineuserid"] = $row["onlineuser_onlineuserid"];
		$GLOBALS["x_picture"] = $row["picture"];
		$GLOBALS["x_first_name"] = $row["first_name"];
		$GLOBALS["x_mid_name"] = $row["mid_name"];
		$GLOBALS["x_last_name"] = $row["last_name"];
		$GLOBALS["x_age"] = $row["age"];
		$GLOBALS["x_sex"] = $row["sex"];
		$GLOBALS["x_nationality"] = $row["nationality"];
		$GLOBALS["x_is_legal"] = $row["is_legal"];
		$GLOBALS["x_years_of_residence"] = $row["years_of_residence"];
		$GLOBALS["x_address_1"] = $row["address_1"];
		$GLOBALS["x_address_2"] = $row["address_2"];
		$GLOBALS["x_address_3"] = $row["address_3"];
		$GLOBALS["x_postcode"] = $row["postcode"];
		$GLOBALS["x_email"] = $row["email"];
		$GLOBALS["x_mobile"] = $row["mobile"];
		$GLOBALS["x_tel"] = $row["tel"];
		$GLOBALS["x_employer"] = $row["employer"];
		$GLOBALS["x_uk_license"] = $row["uk_license"];
		$GLOBALS["x_european_license"] = $row["european_license"];
		$GLOBALS["x_license_points"] = $row["license_points"];
		$GLOBALS["x_marital_status"] = $row["marital_status"];
		$GLOBALS["x_has_dependent"] = $row["has_dependent"];
		$GLOBALS["x_can_relocate"] = $row["can_relocate"];
		$GLOBALS["x_can_travel"] = $row["can_travel"];
		$GLOBALS["x_employement_status"] = $row["employement_status"];
		$GLOBALS["x_work_location"] = $row["work_location"];
		$GLOBALS["x_position_held"] = $row["position_held"];
		$GLOBALS["x_salary"] = $row["salary"];
		$GLOBALS["x_bonus"] = $row["bonus"];
		$GLOBALS["x_ambitions"] = $row["ambitions"];
		$GLOBALS["x_salary_expectation_start"] = $row["salary_expectation_start"];
		$GLOBALS["x_salary_expectation_one"] = $row["salary_expectation_one"];
		$GLOBALS["x_salary_expectation_two"] = $row["salary_expectation_two"];
		$GLOBALS["x_achievement_sales"] = $row["achievement_sales"];
		$GLOBALS["x_achievement_food"] = $row["achievement_food"];
		$GLOBALS["x_achievement_labour"] = $row["achievement_labour"];
		$GLOBALS["x_interests"] = $row["interests"];
		$GLOBALS["x_qualifications"] = $row["qualifications"];
		$GLOBALS["x_tell_us"] = $row["tell_us"];
		$GLOBALS["x_notice"] = $row["notice"];
		$GLOBALS["x_dt_created"] = $row["dt_created"];
		$GLOBALS["x_cv_status"] = $row["cv_status"];
	}
	phpmkr_free_result($rs);
	return $bLoadData;
}
?>
