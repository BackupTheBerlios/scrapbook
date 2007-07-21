<?php 
session_start();
ob_start();
?>
<?php include ("ewconfig.php") ?>
<?php include ("db.php") ?>
<?php include ("cvinfo.php") ?>
<?php include ("advsecu.php") ?>
<?php include ("phpmkrfn.php") ?>
<?php include ("ewupload.php") ?>
<?php

// Initialize common variables
$x_cvid = NULL;
$ox_cvid = NULL;
$z_cvid = NULL;
$ar_x_cvid = NULL;
$ari_x_cvid = NULL;
$x_cvidList = NULL;
$x_cvidChk = NULL;
$cbo_x_cvid_js = NULL;
$x_onlineuser_onlineuserid = NULL;
$ox_onlineuser_onlineuserid = NULL;
$z_onlineuser_onlineuserid = NULL;
$ar_x_onlineuser_onlineuserid = NULL;
$ari_x_onlineuser_onlineuserid = NULL;
$x_onlineuser_onlineuseridList = NULL;
$x_onlineuser_onlineuseridChk = NULL;
$cbo_x_onlineuser_onlineuserid_js = NULL;
$x_picture = NULL;
$ox_picture = NULL;
$z_picture = NULL;
$fs_x_picture = 0;
$fn_x_picture = "";
$ct_x_picture = "";
$wd_x_picture = 0;
$ht_x_picture = 0;
$a_x_picture = "";
$ar_x_picture = NULL;
$ari_x_picture = NULL;
$x_pictureList = NULL;
$x_pictureChk = NULL;
$cbo_x_picture_js = NULL;
$fs_x_picture = 0;
$fn_x_picture = "";
$ct_x_picture = "";
$wd_x_picture = 0;
$ht_x_picture = 0;
$a_x_picture = "";
$x_first_name = NULL;
$ox_first_name = NULL;
$z_first_name = NULL;
$ar_x_first_name = NULL;
$ari_x_first_name = NULL;
$x_first_nameList = NULL;
$x_first_nameChk = NULL;
$cbo_x_first_name_js = NULL;
$x_mid_name = NULL;
$ox_mid_name = NULL;
$z_mid_name = NULL;
$ar_x_mid_name = NULL;
$ari_x_mid_name = NULL;
$x_mid_nameList = NULL;
$x_mid_nameChk = NULL;
$cbo_x_mid_name_js = NULL;
$x_last_name = NULL;
$ox_last_name = NULL;
$z_last_name = NULL;
$ar_x_last_name = NULL;
$ari_x_last_name = NULL;
$x_last_nameList = NULL;
$x_last_nameChk = NULL;
$cbo_x_last_name_js = NULL;
$x_age = NULL;
$ox_age = NULL;
$z_age = NULL;
$ar_x_age = NULL;
$ari_x_age = NULL;
$x_ageList = NULL;
$x_ageChk = NULL;
$cbo_x_age_js = NULL;
$x_sex = NULL;
$ox_sex = NULL;
$z_sex = NULL;
$ar_x_sex = NULL;
$ari_x_sex = NULL;
$x_sexList = NULL;
$x_sexChk = NULL;
$cbo_x_sex_js = NULL;
$x_nationality = NULL;
$ox_nationality = NULL;
$z_nationality = NULL;
$ar_x_nationality = NULL;
$ari_x_nationality = NULL;
$x_nationalityList = NULL;
$x_nationalityChk = NULL;
$cbo_x_nationality_js = NULL;
$x_is_legal = NULL;
$ox_is_legal = NULL;
$z_is_legal = NULL;
$ar_x_is_legal = NULL;
$ari_x_is_legal = NULL;
$x_is_legalList = NULL;
$x_is_legalChk = NULL;
$cbo_x_is_legal_js = NULL;
$x_years_of_residence = NULL;
$ox_years_of_residence = NULL;
$z_years_of_residence = NULL;
$ar_x_years_of_residence = NULL;
$ari_x_years_of_residence = NULL;
$x_years_of_residenceList = NULL;
$x_years_of_residenceChk = NULL;
$cbo_x_years_of_residence_js = NULL;
$x_address_1 = NULL;
$ox_address_1 = NULL;
$z_address_1 = NULL;
$ar_x_address_1 = NULL;
$ari_x_address_1 = NULL;
$x_address_1List = NULL;
$x_address_1Chk = NULL;
$cbo_x_address_1_js = NULL;
$x_address_2 = NULL;
$ox_address_2 = NULL;
$z_address_2 = NULL;
$ar_x_address_2 = NULL;
$ari_x_address_2 = NULL;
$x_address_2List = NULL;
$x_address_2Chk = NULL;
$cbo_x_address_2_js = NULL;
$x_address_3 = NULL;
$ox_address_3 = NULL;
$z_address_3 = NULL;
$ar_x_address_3 = NULL;
$ari_x_address_3 = NULL;
$x_address_3List = NULL;
$x_address_3Chk = NULL;
$cbo_x_address_3_js = NULL;
$x_postcode = NULL;
$ox_postcode = NULL;
$z_postcode = NULL;
$ar_x_postcode = NULL;
$ari_x_postcode = NULL;
$x_postcodeList = NULL;
$x_postcodeChk = NULL;
$cbo_x_postcode_js = NULL;
$x_email = NULL;
$ox_email = NULL;
$z_email = NULL;
$ar_x_email = NULL;
$ari_x_email = NULL;
$x_emailList = NULL;
$x_emailChk = NULL;
$cbo_x_email_js = NULL;
$x_mobile = NULL;
$ox_mobile = NULL;
$z_mobile = NULL;
$ar_x_mobile = NULL;
$ari_x_mobile = NULL;
$x_mobileList = NULL;
$x_mobileChk = NULL;
$cbo_x_mobile_js = NULL;
$x_tel = NULL;
$ox_tel = NULL;
$z_tel = NULL;
$ar_x_tel = NULL;
$ari_x_tel = NULL;
$x_telList = NULL;
$x_telChk = NULL;
$cbo_x_tel_js = NULL;
$x_employer = NULL;
$ox_employer = NULL;
$z_employer = NULL;
$ar_x_employer = NULL;
$ari_x_employer = NULL;
$x_employerList = NULL;
$x_employerChk = NULL;
$cbo_x_employer_js = NULL;
$x_uk_license = NULL;
$ox_uk_license = NULL;
$z_uk_license = NULL;
$ar_x_uk_license = NULL;
$ari_x_uk_license = NULL;
$x_uk_licenseList = NULL;
$x_uk_licenseChk = NULL;
$cbo_x_uk_license_js = NULL;
$x_european_license = NULL;
$ox_european_license = NULL;
$z_european_license = NULL;
$ar_x_european_license = NULL;
$ari_x_european_license = NULL;
$x_european_licenseList = NULL;
$x_european_licenseChk = NULL;
$cbo_x_european_license_js = NULL;
$x_license_points = NULL;
$ox_license_points = NULL;
$z_license_points = NULL;
$ar_x_license_points = NULL;
$ari_x_license_points = NULL;
$x_license_pointsList = NULL;
$x_license_pointsChk = NULL;
$cbo_x_license_points_js = NULL;
$x_marital_status = NULL;
$ox_marital_status = NULL;
$z_marital_status = NULL;
$ar_x_marital_status = NULL;
$ari_x_marital_status = NULL;
$x_marital_statusList = NULL;
$x_marital_statusChk = NULL;
$cbo_x_marital_status_js = NULL;
$x_has_dependent = NULL;
$ox_has_dependent = NULL;
$z_has_dependent = NULL;
$ar_x_has_dependent = NULL;
$ari_x_has_dependent = NULL;
$x_has_dependentList = NULL;
$x_has_dependentChk = NULL;
$cbo_x_has_dependent_js = NULL;
$x_can_relocate = NULL;
$ox_can_relocate = NULL;
$z_can_relocate = NULL;
$ar_x_can_relocate = NULL;
$ari_x_can_relocate = NULL;
$x_can_relocateList = NULL;
$x_can_relocateChk = NULL;
$cbo_x_can_relocate_js = NULL;
$x_can_travel = NULL;
$ox_can_travel = NULL;
$z_can_travel = NULL;
$ar_x_can_travel = NULL;
$ari_x_can_travel = NULL;
$x_can_travelList = NULL;
$x_can_travelChk = NULL;
$cbo_x_can_travel_js = NULL;
$x_employement_status = NULL;
$ox_employement_status = NULL;
$z_employement_status = NULL;
$ar_x_employement_status = NULL;
$ari_x_employement_status = NULL;
$x_employement_statusList = NULL;
$x_employement_statusChk = NULL;
$cbo_x_employement_status_js = NULL;
$x_work_location = NULL;
$ox_work_location = NULL;
$z_work_location = NULL;
$ar_x_work_location = NULL;
$ari_x_work_location = NULL;
$x_work_locationList = NULL;
$x_work_locationChk = NULL;
$cbo_x_work_location_js = NULL;
$x_position_held = NULL;
$ox_position_held = NULL;
$z_position_held = NULL;
$ar_x_position_held = NULL;
$ari_x_position_held = NULL;
$x_position_heldList = NULL;
$x_position_heldChk = NULL;
$cbo_x_position_held_js = NULL;
$x_salary = NULL;
$ox_salary = NULL;
$z_salary = NULL;
$ar_x_salary = NULL;
$ari_x_salary = NULL;
$x_salaryList = NULL;
$x_salaryChk = NULL;
$cbo_x_salary_js = NULL;
$x_bonus = NULL;
$ox_bonus = NULL;
$z_bonus = NULL;
$ar_x_bonus = NULL;
$ari_x_bonus = NULL;
$x_bonusList = NULL;
$x_bonusChk = NULL;
$cbo_x_bonus_js = NULL;
$x_ambitions = NULL;
$ox_ambitions = NULL;
$z_ambitions = NULL;
$ar_x_ambitions = NULL;
$ari_x_ambitions = NULL;
$x_ambitionsList = NULL;
$x_ambitionsChk = NULL;
$cbo_x_ambitions_js = NULL;
$x_salary_expectation_start = NULL;
$ox_salary_expectation_start = NULL;
$z_salary_expectation_start = NULL;
$ar_x_salary_expectation_start = NULL;
$ari_x_salary_expectation_start = NULL;
$x_salary_expectation_startList = NULL;
$x_salary_expectation_startChk = NULL;
$cbo_x_salary_expectation_start_js = NULL;
$x_salary_expectation_one = NULL;
$ox_salary_expectation_one = NULL;
$z_salary_expectation_one = NULL;
$ar_x_salary_expectation_one = NULL;
$ari_x_salary_expectation_one = NULL;
$x_salary_expectation_oneList = NULL;
$x_salary_expectation_oneChk = NULL;
$cbo_x_salary_expectation_one_js = NULL;
$x_salary_expectation_two = NULL;
$ox_salary_expectation_two = NULL;
$z_salary_expectation_two = NULL;
$ar_x_salary_expectation_two = NULL;
$ari_x_salary_expectation_two = NULL;
$x_salary_expectation_twoList = NULL;
$x_salary_expectation_twoChk = NULL;
$cbo_x_salary_expectation_two_js = NULL;
$x_achievement_sales = NULL;
$ox_achievement_sales = NULL;
$z_achievement_sales = NULL;
$ar_x_achievement_sales = NULL;
$ari_x_achievement_sales = NULL;
$x_achievement_salesList = NULL;
$x_achievement_salesChk = NULL;
$cbo_x_achievement_sales_js = NULL;
$x_achievement_food = NULL;
$ox_achievement_food = NULL;
$z_achievement_food = NULL;
$ar_x_achievement_food = NULL;
$ari_x_achievement_food = NULL;
$x_achievement_foodList = NULL;
$x_achievement_foodChk = NULL;
$cbo_x_achievement_food_js = NULL;
$x_achievement_labour = NULL;
$ox_achievement_labour = NULL;
$z_achievement_labour = NULL;
$ar_x_achievement_labour = NULL;
$ari_x_achievement_labour = NULL;
$x_achievement_labourList = NULL;
$x_achievement_labourChk = NULL;
$cbo_x_achievement_labour_js = NULL;
$x_interests = NULL;
$ox_interests = NULL;
$z_interests = NULL;
$ar_x_interests = NULL;
$ari_x_interests = NULL;
$x_interestsList = NULL;
$x_interestsChk = NULL;
$cbo_x_interests_js = NULL;
$x_qualifications = NULL;
$ox_qualifications = NULL;
$z_qualifications = NULL;
$ar_x_qualifications = NULL;
$ari_x_qualifications = NULL;
$x_qualificationsList = NULL;
$x_qualificationsChk = NULL;
$cbo_x_qualifications_js = NULL;
$x_tell_us = NULL;
$ox_tell_us = NULL;
$z_tell_us = NULL;
$ar_x_tell_us = NULL;
$ari_x_tell_us = NULL;
$x_tell_usList = NULL;
$x_tell_usChk = NULL;
$cbo_x_tell_us_js = NULL;
$x_notice = NULL;
$ox_notice = NULL;
$z_notice = NULL;
$ar_x_notice = NULL;
$ari_x_notice = NULL;
$x_noticeList = NULL;
$x_noticeChk = NULL;
$cbo_x_notice_js = NULL;
$x_dt_created = NULL;
$ox_dt_created = NULL;
$z_dt_created = NULL;
$ar_x_dt_created = NULL;
$ari_x_dt_created = NULL;
$x_dt_createdList = NULL;
$x_dt_createdChk = NULL;
$cbo_x_dt_created_js = NULL;
$x_cv_status = NULL;
$ox_cv_status = NULL;
$z_cv_status = NULL;
$ar_x_cv_status = NULL;
$ari_x_cv_status = NULL;
$x_cv_statusList = NULL;
$x_cv_statusChk = NULL;
$cbo_x_cv_status_js = NULL;
?>
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
<?php include ("header.php") ?>
<script type="text/javascript">
<!--
EW_LookupFn = "ewlookup.php"; // ewlookup file name
EW_AddOptFn = "ewaddopt.php"; // ewaddopt.php file name

//-->
</script>
<script type="text/javascript" src="ewp.js"></script>
<p><span>View TABLE: cv<br><br>
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
<?php echo $x_can_travel; ?>
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
<?php include ("footer.php") ?>
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
