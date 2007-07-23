<?php 
require("common_user.php");
ob_start();
?>
<?php include ("cvinfo.php") ?>
<?php include ("ewupload.php") ?>
<?php
$x_cvid = $user->getCVId();
if ($x_cvid>0)
{
	ob_end_clean();
	header("Location: cvedit.php");
	exit();
}
// Get action
$sAction = @$_POST["a_add"];
if (($sAction == "") || ((is_null($sAction)))) {
		$sAction = "I"; // Display blank record
} else {
	// Get fields from form
	$x_picture = @$_POST["x_picture"];
	$x_first_name = @$_POST["x_first_name"];
	$x_mid_name = @$_POST["x_mid_name"];
	$x_last_name = @$_POST["x_last_name"];
	$x_age = @$_POST["x_age"];
	$x_sex = @$_POST["x_sex"];
	$x_nationality = @$_POST["x_nationality"];
	$x_is_legal = @$_POST["x_is_legal"];
	$x_years_of_residence = @$_POST["x_years_of_residence"];
	$x_address_1 = @$_POST["x_address_1"];
	$x_address_2 = @$_POST["x_address_2"];
	$x_address_3 = @$_POST["x_address_3"];
	$x_postcode = @$_POST["x_postcode"];
	$x_email = @$_POST["x_email"];
	$x_mobile = @$_POST["x_mobile"];
	$x_tel = @$_POST["x_tel"];
	$x_employer = @$_POST["x_employer"];
	$x_uk_license = @$_POST["x_uk_license"];
	$x_european_license = @$_POST["x_european_license"];
	$x_license_points = @$_POST["x_license_points"];
	$x_marital_status = @$_POST["x_marital_status"];
	$x_has_dependent = @$_POST["x_has_dependent"];
	$x_can_relocate = @$_POST["x_can_relocate"];
	$x_can_travel = @$_POST["x_can_travel"];
	$x_employement_status = @$_POST["x_employement_status"];
	$x_work_location = @$_POST["x_work_location"];
	$x_position_held = @$_POST["x_position_held"];
	$x_salary = @$_POST["x_salary"];
	$x_bonus = @$_POST["x_bonus"];
	$x_ambitions = @$_POST["x_ambitions"];
	$x_salary_expectation_start = @$_POST["x_salary_expectation_start"];
	$x_salary_expectation_one = @$_POST["x_salary_expectation_one"];
	$x_salary_expectation_two = @$_POST["x_salary_expectation_two"];
	$x_achievement_sales = @$_POST["x_achievement_sales"];
	$x_achievement_food = @$_POST["x_achievement_food"];
	$x_achievement_labour = @$_POST["x_achievement_labour"];
	$x_interests = @$_POST["x_interests"];
	$x_qualifications = @$_POST["x_qualifications"];
	$x_tell_us = @$_POST["x_tell_us"];
	$x_notice = @$_POST["x_notice"];
	$x_dt_created = @$_POST["x_dt_created"];
	$x_cv_status = @$_POST["x_cv_status"];
}
$conn = phpmkr_db_connect(HOST, USER, PASS, DB, PORT);
switch ($sAction) {
	case "A": // Add
		if (AddData($conn)) { // Add new record
			//$_SESSION[ewSessionMessage] = "Add New Record Successful";
			phpmkr_db_close($conn);
			ob_end_clean();
			header("Location: cvlist.php");
			exit();
		}
		break;
}
?>
<?php include ("top.php") ?>
<script type="text/javascript" src="scripts/ewp.js"></script>
<script type="text/javascript">
<!--
EW_dateSep = "/"; // set date separator
EW_UploadAllowedFileExt = "gif,jpg,jpeg,bmp,png"; // allowed upload file extension
//-->
</script>
<script type="text/javascript">
<!--
function EW_checkMyForm(EW_this) {

if (EW_this.x_picture && !EW_checkfiletype(EW_this.x_picture.value)) { 
	if (!EW_onError(EW_this, EW_this.x_picture, "FILE", "File type is not allowed.")) 
	return false; 
}
if (EW_this.x_first_name && !EW_hasValue(EW_this.x_first_name, "TEXT")) {
	if (!EW_onError(EW_this, EW_this.x_first_name, "TEXT", "Please enter required field - First Name"))
		return false;
}
if (EW_this.x_last_name && !EW_hasValue(EW_this.x_last_name, "TEXT")) {
	if (!EW_onError(EW_this, EW_this.x_last_name, "TEXT", "Please enter required field - Last Name"))
		return false;
}
if (EW_this.x_age && !EW_hasValue(EW_this.x_age, "TEXT")) {
	if (!EW_onError(EW_this, EW_this.x_age, "TEXT", "Please enter required field - Age"))
		return false;
}
if (EW_this.x_age && !EW_checkinteger(EW_this.x_age.value)) {
	if (!EW_onError(EW_this, EW_this.x_age, "TEXT", "Incorrect integer - Age"))
		return false; 
}
if (EW_this.x_years_of_residence && !EW_checkinteger(EW_this.x_years_of_residence.value)) {
	if (!EW_onError(EW_this, EW_this.x_years_of_residence, "TEXT", "Incorrect integer - No of years residence in UK"))
		return false; 
}
if (EW_this.x_address_1 && !EW_hasValue(EW_this.x_address_1, "TEXT")) {
	if (!EW_onError(EW_this, EW_this.x_address_1, "TEXT", "Please enter required field - Address line 1"))
		return false;
}
if (EW_this.x_postcode && !EW_hasValue(EW_this.x_postcode, "TEXT")) {
	if (!EW_onError(EW_this, EW_this.x_postcode, "TEXT", "Please enter required field - Post code"))
		return false;
}
if (EW_this.x_email && !EW_hasValue(EW_this.x_email, "TEXT")) {
	if (!EW_onError(EW_this, EW_this.x_email, "TEXT", "Please enter required field - Email Address"))
		return false;
}
if (EW_this.x_email && !EW_checkemail(EW_this.x_email.value)) {
	if (!EW_onError(EW_this, EW_this.x_email, "TEXT", "Incorrect email - Email Address"))
		return false; 
}
if (EW_this.x_tel && !EW_hasValue(EW_this.x_tel, "TEXT")) {
	if (!EW_onError(EW_this, EW_this.x_tel, "TEXT", "Please enter required field - Land line number"))
		return false;
}
if (EW_this.x_license_points && !EW_checkinteger(EW_this.x_license_points.value)) {
	if (!EW_onError(EW_this, EW_this.x_license_points, "TEXT", "Incorrect integer - Number of points on license"))
		return false; 
}
if (EW_this.x_can_travel && !EW_checkinteger(EW_this.x_can_travel.value)) {
	if (!EW_onError(EW_this, EW_this.x_can_travel, "TEXT", "Incorrect integer - Willing to travel"))
		return false; 
}
return true;
}

//-->
</script>
 <h2 style = "margin-left:5px;">Create your CV</h2>
<form name="fcvadd" id="fcvadd" action="cv_form.php" method="post" enctype="multipart/form-data" onsubmit="return EW_checkMyForm(this);">
<p>
<input type="hidden" name="a_add" value="A">
<input type="hidden" name="EW_Max_File_Size" value="2000000">
<table>
	<tr>
		<td><span>Picture</span></td>
		<td><span id="cb_x_picture">
<?php $x_picture = ""; // Clear BLOB related fields ?>
<input type="file" id="x_picture" name="x_picture" >
</span></td>
	</tr>
	<tr>
		<td><span>First Name<span class='ewmsg'>&nbsp;*</span></span></td>
		<td><span id="cb_x_first_name">
<input type="text" name="x_first_name" id="x_first_name" maxlength="45" value="<?php echo htmlspecialchars(@$x_first_name) ?>">
</span></td>
	</tr>
	<tr>
		<td><span>Middle Name</span></td>
		<td><span id="cb_x_mid_name">
<input type="text" name="x_mid_name" id="x_mid_name" maxlength="45" value="<?php echo htmlspecialchars(@$x_mid_name) ?>">
</span></td>
	</tr>
	<tr>
		<td><span>Last Name<span class='ewmsg'>&nbsp;*</span></span></td>
		<td><span id="cb_x_last_name">
<input type="text" name="x_last_name" id="x_last_name" maxlength="45" value="<?php echo htmlspecialchars(@$x_last_name) ?>">
</span></td>
	</tr>
	<tr>
		<td><span>Age<span class='ewmsg'>&nbsp;*</span></span></td>
		<td><span id="cb_x_age">
<input type="text" name="x_age" id="x_age" value="<?php echo htmlspecialchars(@$x_age) ?>">
</span></td>
	</tr>
	<tr>
		<td><span>Sex</span></td>
		<td><span id="cb_x_sex">
<?php
$x_sexList = "<select id='x_sex' name='x_sex'>";
	$x_sexList .= "<option value=\"male\"";
	if (@$x_sex == "male") {
		$x_sexList .= " selected";
	}
	$x_sexList .= ">" . "male" . "</option>";
	$x_sexList .= "<option value=\"female\"";
	if (@$x_sex == "female") {
		$x_sexList .= " selected";
	}
	$x_sexList .= ">" . "female" . "</option>";
	$x_sexList .= "<option value=\"prefer not to say\"";
	if (@$x_sex == "prefer not to say") {
		$x_sexList .= " selected";
	}
	$x_sexList .= ">" . "prefer not to say" . "</option>";
$x_sexList .= "</select>";
echo $x_sexList;
?>
</span></td>
	</tr>
	<tr>
		<td><span>Nationality</span></td>
		<td><span id="cb_x_nationality">
<input type="text" name="x_nationality" id="x_nationality" maxlength="255" value="<?php echo htmlspecialchars(@$x_nationality) ?>">
</span></td>
	</tr>
	<tr>
		<td><span>Legally entitled to work in UK</span></td>
		<td><span id="cb_x_is_legal">
<?php if (!(!is_null($x_is_legal)) || ($x_is_legal == "")) { $x_is_legal = 1;} // Set default value ?>
<?php echo RenderControl(1, 0, 5, 1); ?>
<input type="radio" name="x_is_legal"<?php if (@$x_is_legal == "1") { ?> checked<?php } ?> value="<?php echo htmlspecialchars("1"); ?>">
<?php echo "yes"; ?>
<?php echo RenderControl(1, 0, 5, 2); ?>
<?php echo RenderControl(1, 1, 5, 1); ?>
<input type="radio" name="x_is_legal"<?php if (@$x_is_legal == "0") { ?> checked<?php } ?> value="<?php echo htmlspecialchars("0"); ?>">
<?php echo "no"; ?>
<?php echo RenderControl(1, 1, 5, 2); ?>
</span></td>
	</tr>
	<tr>
		<td><span>No of years residence in UK</span></td>
		<td><span id="cb_x_years_of_residence">
<input type="text" name="x_years_of_residence" id="x_years_of_residence" value="<?php echo htmlspecialchars(@$x_years_of_residence) ?>">
</span></td>
	</tr>
	<tr>
		<td><span>Address line 1<span class='ewmsg'>&nbsp;*</span></span></td>
		<td><span id="cb_x_address_1">
<input type="text" name="x_address_1" id="x_address_1" maxlength="255" value="<?php echo htmlspecialchars(@$x_address_1) ?>">
</span></td>
	</tr>
	<tr>
		<td><span>line 2</span></td>
		<td><span id="cb_x_address_2">
<input type="text" name="x_address_2" id="x_address_2" maxlength="255" value="<?php echo htmlspecialchars(@$x_address_2) ?>">
</span></td>
	</tr>
	<tr>
		<td><span>line 3</span></td>
		<td><span id="cb_x_address_3">
<input type="text" name="x_address_3" id="x_address_3" maxlength="255" value="<?php echo htmlspecialchars(@$x_address_3) ?>">
</span></td>
	</tr>
	<tr>
		<td><span>Post code<span class='ewmsg'>&nbsp;*</span></span></td>
		<td><span id="cb_x_postcode">
<input type="text" name="x_postcode" id="x_postcode" maxlength="20" value="<?php echo htmlspecialchars(@$x_postcode) ?>">
</span></td>
	</tr>
	<tr>
		<td><span>Email Address<span class='ewmsg'>&nbsp;*</span></span></td>
		<td><span id="cb_x_email">
<input type="text" name="x_email" id="x_email" maxlength="45" value="<?php echo htmlspecialchars(@$x_email) ?>">
</span></td>
	</tr>
	<tr>
		<td><span>Mobile number</span></td>
		<td><span id="cb_x_mobile">
<input type="text" name="x_mobile" id="x_mobile" maxlength="45" value="<?php echo htmlspecialchars(@$x_mobile) ?>">
</span></td>
	</tr>
	<tr>
		<td><span>Land line number<span class='ewmsg'>&nbsp;*</span></span></td>
		<td><span id="cb_x_tel">
<input type="text" name="x_tel" id="x_tel" maxlength="45" value="<?php echo htmlspecialchars(@$x_tel) ?>">
</span></td>
	</tr>
	<tr>
		<td><span>Current Employer</span></td>
		<td><span id="cb_x_employer">
<input type="text" name="x_employer" id="x_employer" maxlength="255" value="<?php echo htmlspecialchars(@$x_employer) ?>">
</span></td>
	</tr>
	<tr>
		<td><span>Full clean UK driving license </span></td>
		<td><span id="cb_x_uk_license">
<?php if (!(!is_null($x_uk_license)) || ($x_uk_license == "")) { $x_uk_license = 1;} // Set default value ?>
<?php echo RenderControl(1, 0, 5, 1); ?>
<input type="radio" name="x_uk_license"<?php if (@$x_uk_license == "1") { ?> checked<?php } ?> value="<?php echo htmlspecialchars("1"); ?>">
<?php echo "yes"; ?>
<?php echo RenderControl(1, 0, 5, 2); ?>
<?php echo RenderControl(1, 1, 5, 1); ?>
<input type="radio" name="x_uk_license"<?php if (@$x_uk_license == "0") { ?> checked<?php } ?> value="<?php echo htmlspecialchars("0"); ?>">
<?php echo "no"; ?>
<?php echo RenderControl(1, 1, 5, 2); ?>
</span></td>
	</tr>
	<tr>
		<td><span>European license held</span></td>
		<td><span id="cb_x_european_license">
<?php if (!(!is_null($x_european_license)) || ($x_european_license == "")) { $x_european_license = 0;} // Set default value ?>
<?php echo RenderControl(1, 0, 5, 1); ?>
<input type="radio" name="x_european_license"<?php if (@$x_european_license == "1") { ?> checked<?php } ?> value="<?php echo htmlspecialchars("1"); ?>">
<?php echo "yes"; ?>
<?php echo RenderControl(1, 0, 5, 2); ?>
<?php echo RenderControl(1, 1, 5, 1); ?>
<input type="radio" name="x_european_license"<?php if (@$x_european_license == "0") { ?> checked<?php } ?> value="<?php echo htmlspecialchars("0"); ?>">
<?php echo "no"; ?>
<?php echo RenderControl(1, 1, 5, 2); ?>
</span></td>
	</tr>
	<tr>
		<td><span>Number of points on license</span></td>
		<td><span id="cb_x_license_points">
<input type="text" name="x_license_points" id="x_license_points" value="<?php echo htmlspecialchars(@$x_license_points) ?>">
</span></td>
	</tr>
	<tr>
		<td><span>Marital Status</span></td>
		<td><span id="cb_x_marital_status">
<?php
$x_marital_statusList = "<select id='x_marital_status' name='x_marital_status'>";
	$x_marital_statusList .= "<option value=\"single\"";
	if (@$x_marital_status == "single") {
		$x_marital_statusList .= " selected";
	}
	$x_marital_statusList .= ">" . "single" . "</option>";
	$x_marital_statusList .= "<option value=\"married\"";
	if (@$x_marital_status == "married") {
		$x_marital_statusList .= " selected";
	}
	$x_marital_statusList .= ">" . "married" . "</option>";
	$x_marital_statusList .= "<option value=\"separated\"";
	if (@$x_marital_status == "separated") {
		$x_marital_statusList .= " selected";
	}
	$x_marital_statusList .= ">" . "separated" . "</option>";
	$x_marital_statusList .= "<option value=\"in relationship\"";
	if (@$x_marital_status == "in relationship") {
		$x_marital_statusList .= " selected";
	}
	$x_marital_statusList .= ">" . "in relationship" . "</option>";
$x_marital_statusList .= "</select>";
echo $x_marital_statusList;
?>
</span></td>
	</tr>
	<tr>
		<td><span>Any dependents</span></td>
		<td><span id="cb_x_has_dependent">
<?php if (!(!is_null($x_has_dependent)) || ($x_has_dependent == "")) { $x_has_dependent = 0;} // Set default value ?>
<?php echo RenderControl(1, 0, 5, 1); ?>
<input type="radio" name="x_has_dependent"<?php if (@$x_has_dependent == "1") { ?> checked<?php } ?> value="<?php echo htmlspecialchars("1"); ?>">
<?php echo "yes"; ?>
<?php echo RenderControl(1, 0, 5, 2); ?>
<?php echo RenderControl(1, 1, 5, 1); ?>
<input type="radio" name="x_has_dependent"<?php if (@$x_has_dependent == "0") { ?> checked<?php } ?> value="<?php echo htmlspecialchars("0"); ?>">
<?php echo "no"; ?>
<?php echo RenderControl(1, 1, 5, 2); ?>
</span></td>
	</tr>
	<tr>
		<td><span>Willing to relocate</span></td>
		<td><span id="cb_x_can_relocate">
<?php if (!(!is_null($x_can_relocate)) || ($x_can_relocate == "")) { $x_can_relocate = 1;} // Set default value ?>
<?php echo RenderControl(1, 0, 5, 1); ?>
<input type="radio" name="x_can_relocate"<?php if (@$x_can_relocate == "1") { ?> checked<?php } ?> value="<?php echo htmlspecialchars("1"); ?>">
<?php echo "yes"; ?>
<?php echo RenderControl(1, 0, 5, 2); ?>
<?php echo RenderControl(1, 1, 5, 1); ?>
<input type="radio" name="x_can_relocate"<?php if (@$x_can_relocate == "0") { ?> checked<?php } ?> value="<?php echo htmlspecialchars("0"); ?>">
<?php echo "no"; ?>
<?php echo RenderControl(1, 1, 5, 2); ?>
</span></td>
	</tr>
	<tr>
		<td><span>Willing to travel</span></td>
		<td><span id="cb_x_can_travel">
<?php if (!(!is_null($x_can_travel)) || ($x_can_travel == "")) { $x_can_travel = 0;} // Set default value ?>
<input type="text" name="x_can_travel" id="x_can_travel" size="10" value="<?php echo htmlspecialchars(@$x_can_travel) ?>"> 
miles
</span></td>
	</tr>
	<tr>
		<td><span>Current Employment Status</span></td>
		<td><span id="cb_x_employement_status">
<?php
$x_employement_statusList = "<select id='x_employement_status' name='x_employement_status'>";
	$x_employement_statusList .= "<option value=\"employed\"";
	if (@$x_employement_status == "employed") {
		$x_employement_statusList .= " selected";
	}
	$x_employement_statusList .= ">" . "employed" . "</option>";
	$x_employement_statusList .= "<option value=\"self employed\"";
	if (@$x_employement_status == "self employed") {
		$x_employement_statusList .= " selected";
	}
	$x_employement_statusList .= ">" . "self employed" . "</option>";
	$x_employement_statusList .= "<option value=\"un-employed\"";
	if (@$x_employement_status == "un-employed") {
		$x_employement_statusList .= " selected";
	}
	$x_employement_statusList .= ">" . "un-employed" . "</option>";
$x_employement_statusList .= "</select>";
echo $x_employement_statusList;
?>
</span></td>
	</tr>
	<tr>
		<td><span>Current work location</span></td>
		<td><span id="cb_x_work_location">
<input type="text" name="x_work_location" id="x_work_location" maxlength="255" value="<?php echo htmlspecialchars(@$x_work_location) ?>">
</span></td>
	</tr>
	<tr>
		<td><span>Current / Last position held</span></td>
		<td>
		<select id='x_position_held' name='x_position_held'>
		<?php
			   loadOptions("position_list.htm",@$x_position_held);
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td><span>Current / last salary</span></td>
		<td>
		<select id='x_salary' name='x_salary'>
		<?php
			   loadOptions("salary_list.htm",@$x_salary);
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td><span>Current / last annual bonus paid </span></td>
		<td><span id="cb_x_bonus">
<input type="text" name="x_bonus" id="x_bonus" maxlength="45" value="<?php echo htmlspecialchars(@$x_bonus) ?>">
</span></td>
	</tr>
	<tr>
		<td><span>Ambitions within next 2-3 years</span></td>
		<td><span id="cb_x_ambitions">
<input type="text" name="x_ambitions" id="x_ambitions" maxlength="255" value="<?php echo htmlspecialchars(@$x_ambitions) ?>">
</span></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;
		</td>
	</tr>	
	<tr>
		<td><span>Salary Expectations:</span></td>
		<td>&nbsp;
		</td>
	</tr>
	<tr>
		<td><span>Start</span></td>
		<td>
		<select id='x_salary_expectation_start' name='x_salary_expectation_start'>
		<option value=''>Please Select ... </option>
		<?php
			   loadOptions("salary_list.htm",@$x_salary_expectation_start);
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td><span>Within a year</span></td>
		<td><select id='x_salary_expectation_one' name='x_salary_expectation_one'>
		<option value=''>Please Select ... </option>
		<?php
			   loadOptions("salary_list.htm",@$x_salary_expectation_one);
		?>
		</select></td>
	</tr>
	<tr>
		<td><span>Within 2-3 years</span></td>
		<td>
		<select id='x_salary_expectation_two' name='x_salary_expectation_two'>
		<option value=''>Please Select ... </option>
		<?php
			   loadOptions("salary_list.htm",@$x_salary_expectation_two);
		?>
		</select>
		</td>

	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;
		</td>
	</tr>	
	<tr>
		<td><span>Achievement last 12 months :</span></td>
		<td>&nbsp;
		</td>
	</tr>	
	<tr>
		<td><span>Sales</span></td>
		<td>
		<select id='x_achievement_sales' name='x_achievement_sales'>
		<option value=''>Please Select ... </option>
		<?php
			   loadOptions("achievement_list.htm",@$x_achievement_sales);
		?>
		</select>
		</td>		
	</tr>
	<tr>
		<td><span>Food Cost</span></td>
		<td>
		<select id='x_achievement_food' name='x_achievement_food'>
		<option value=''>Please Select ... </option>
		<?php
			   loadOptions("achievement_list.htm",@$x_achievement_food);
		?>
		</select>
		</td>				
	</tr>
	<tr>
		<td><span>Labour Cost</span></td>
		<td>
		<select id='x_achievement_labour' name='x_achievement_labour'>
		<option value=''>Please Select ... </option>
		<?php
			   loadOptions("achievement_list.htm",@$x_achievement_labour);
		?>
		</select>
		</td>					
	</tr>
	<tr>
		<td><span>Interests / Hobbies</span></td>
		<td><span id="cb_x_interests">
<input type="text" name="x_interests" id="x_interests" maxlength="255" value="<?php echo htmlspecialchars(@$x_interests) ?>">
</span></td>
	</tr>
	<tr>
		<td><span>Qualifications Held</span></td>
		<td><span id="cb_x_qualifications">
<input type="text" name="x_qualifications" id="x_qualifications" maxlength="255" value="<?php echo htmlspecialchars(@$x_qualifications) ?>">
</span></td>
	</tr>
	<tr>
		<td><span>Tell us about yourself: max 50 words</span></td>
		<td><span id="cb_x_tell_us">
<textarea cols="35" rows="4" id="x_tell_us" name="x_tell_us"><?php echo @$x_tell_us; ?></textarea>
</span></td>
	</tr>
	<tr>
		<td><span>Notice required in current position</span></td>
		<td>
		<select id='x_notice' name='x_notice'>
		<?php
			   loadOptions("notice_period_list.htm",@$x_notice);
		?>
		</select>
		</td>		
	</tr>
</table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="ADD">
</form>
<?php include ("bottom.php") ?>
<?php
phpmkr_db_close($conn);
?>

<?php

//-------------------------------------------------------------------------------
// Function AddData
// - Add Data
// - Variables used: field variables

function AddData($conn)
{
	global $x_cvid,$user;
	$sFilter = ewSqlKeyWhere;

	// Check for duplicate key
	$bCheckKey = true;
	if ((@$x_cvid == "") || (is_null(@$x_cvid))) {
		$bCheckKey = false;
	} else {
		$sFilter = str_replace("@cvid", AdjustSql($x_cvid), $sFilter); // Replace key value
	}
	if ($bCheckKey) {
		$sSqlChk = ewBuildSql(ewSqlSelect, ewSqlWhere, ewSqlGroupBy, ewSqlHaving, ewSqlOrderBy, $sFilter, "");
		$rsChk = phpmkr_query($sSqlChk, $conn) or die("Failed to execute query at line " . __LINE__ . ": " . phpmkr_error($conn) . '<br>SQL: ' . $sSqlChk);
		if (phpmkr_num_rows($rsChk) > 0) {
			//$_SESSION[ewSessionMessage] = "Duplicate value for primary key";
			phpmkr_free_result($rsChk);
			return false;
		}
		phpmkr_free_result($rsChk);
	}
		$EW_MaxFileSize = @$_POST["EW_Max_File_Size"];

		// Check the file size
		if (!empty($_FILES["x_picture"]["size"])) {
			if (!empty($EW_MaxFileSize) && $_FILES["x_picture"]["size"] > $EW_MaxFileSize) {
				die(str_replace("%s", $EW_MaxFileSize, "Max. file size (%s bytes) exceeded."));
			}
		}
		$fn_x_picture = $_FILES["x_picture"]["name"];

		// Check the file type
		if (!empty($fn_x_picture)) {
			if (!ewUploadAllowedFileExt($fn_x_picture)) {
				die("File type is not allowed.");
			}
		}
		$ct_x_picture = @$_POST["x_picture"];
		$x_picture = @$_POST[ "x_picture"];
		$wd_x_picture = @$_POST["wd_x_picture"];
		$ht_x_picture = @$_POST["ht_x_picture"];
		$a_x_picture =  @$_POST["a_x_picture"];

	// Field onlineuser_onlineuserid
	$fieldList["`onlineuser_onlineuserid`"] = $user->onlineuserId;

	// Field picture
		if (is_uploaded_file($_FILES["x_picture"]["tmp_name"])) {
			$sTmpFolder = ewUploadPathEx(true, EW_UploadDestPath);
			$theName = ewUploadFileNameEx($sTmpFolder, $_FILES["x_picture"]["name"]);
			$destfile = $sTmpFolder . $theName;
			if (!move_uploaded_file($_FILES["x_picture"]["tmp_name"], $destfile)) // Move file to destination path
				die("" . $destfile);
			@chmod($destfile, defined(EW_UploadedFileMode) ? EW_UploadedFileMode : 0666);

			// File name
			$theName = (!get_magic_quotes_gpc()) ? addslashes($theName) : $theName;
			$fieldList["`picture`"] = " '" . $theName . "'";
			@unlink($_FILES["x_picture"]["tmp_name"]);
		}

	// Field first_name
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_first_name"]) : $GLOBALS["x_first_name"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`first_name`"] = $theValue;

	// Field mid_name
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_mid_name"]) : $GLOBALS["x_mid_name"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`mid_name`"] = $theValue;

	// Field last_name
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_last_name"]) : $GLOBALS["x_last_name"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`last_name`"] = $theValue;

	// Field age
	$theValue = ($GLOBALS["x_age"] != "") ? intval($GLOBALS["x_age"]) : "NULL";
	$fieldList["`age`"] = $theValue;

	// Field sex
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_sex"]) : $GLOBALS["x_sex"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`sex`"] = $theValue;

	// Field nationality
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_nationality"]) : $GLOBALS["x_nationality"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`nationality`"] = $theValue;

	// Field is_legal
	$theValue = ($GLOBALS["x_is_legal"] != "") ? intval($GLOBALS["x_is_legal"]) : "NULL";
	$fieldList["`is_legal`"] = $theValue;

	// Field years_of_residence
	$theValue = ($GLOBALS["x_years_of_residence"] != "") ? intval($GLOBALS["x_years_of_residence"]) : "NULL";
	$fieldList["`years_of_residence`"] = $theValue;

	// Field address_1
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_address_1"]) : $GLOBALS["x_address_1"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`address_1`"] = $theValue;

	// Field address_2
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_address_2"]) : $GLOBALS["x_address_2"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`address_2`"] = $theValue;

	// Field address_3
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_address_3"]) : $GLOBALS["x_address_3"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`address_3`"] = $theValue;

	// Field postcode
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_postcode"]) : $GLOBALS["x_postcode"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`postcode`"] = $theValue;

	// Field email
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_email"]) : $GLOBALS["x_email"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`email`"] = $theValue;

	// Field mobile
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_mobile"]) : $GLOBALS["x_mobile"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`mobile`"] = $theValue;

	// Field tel
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_tel"]) : $GLOBALS["x_tel"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`tel`"] = $theValue;

	// Field employer
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_employer"]) : $GLOBALS["x_employer"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`employer`"] = $theValue;

	// Field uk_license
	$theValue = ($GLOBALS["x_uk_license"] != "") ? intval($GLOBALS["x_uk_license"]) : "NULL";
	$fieldList["`uk_license`"] = $theValue;

	// Field european_license
	$theValue = ($GLOBALS["x_european_license"] != "") ? intval($GLOBALS["x_european_license"]) : "NULL";
	$fieldList["`european_license`"] = $theValue;

	// Field license_points
	$theValue = ($GLOBALS["x_license_points"] != "") ? intval($GLOBALS["x_license_points"]) : "NULL";
	$fieldList["`license_points`"] = $theValue;

	// Field marital_status
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_marital_status"]) : $GLOBALS["x_marital_status"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`marital_status`"] = $theValue;

	// Field has_dependent
	$theValue = ($GLOBALS["x_has_dependent"] != "") ? intval($GLOBALS["x_has_dependent"]) : "NULL";
	$fieldList["`has_dependent`"] = $theValue;

	// Field can_relocate
	$theValue = ($GLOBALS["x_can_relocate"] != "") ? intval($GLOBALS["x_can_relocate"]) : "NULL";
	$fieldList["`can_relocate`"] = $theValue;

	// Field can_travel
	$theValue = ($GLOBALS["x_can_travel"] != "") ? intval($GLOBALS["x_can_travel"]) : "NULL";
	$fieldList["`can_travel`"] = $theValue;

	// Field employement_status
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_employement_status"]) : $GLOBALS["x_employement_status"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`employement_status`"] = $theValue;

	// Field work_location
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_work_location"]) : $GLOBALS["x_work_location"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`work_location`"] = $theValue;

	// Field position_held
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_position_held"]) : $GLOBALS["x_position_held"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`position_held`"] = $theValue;

	// Field salary
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_salary"]) : $GLOBALS["x_salary"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`salary`"] = $theValue;

	// Field bonus
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_bonus"]) : $GLOBALS["x_bonus"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`bonus`"] = $theValue;

	// Field ambitions
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_ambitions"]) : $GLOBALS["x_ambitions"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`ambitions`"] = $theValue;

	// Field salary_expectation_start
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_salary_expectation_start"]) : $GLOBALS["x_salary_expectation_start"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`salary_expectation_start`"] = $theValue;

	// Field salary_expectation_one
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_salary_expectation_one"]) : $GLOBALS["x_salary_expectation_one"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`salary_expectation_one`"] = $theValue;

	// Field salary_expectation_two
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_salary_expectation_two"]) : $GLOBALS["x_salary_expectation_two"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`salary_expectation_two`"] = $theValue;

	// Field achievement_sales
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_achievement_sales"]) : $GLOBALS["x_achievement_sales"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`achievement_sales`"] = $theValue;

	// Field achievement_food
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_achievement_food"]) : $GLOBALS["x_achievement_food"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`achievement_food`"] = $theValue;

	// Field achievement_labour
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_achievement_labour"]) : $GLOBALS["x_achievement_labour"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`achievement_labour`"] = $theValue;

	// Field interests
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_interests"]) : $GLOBALS["x_interests"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`interests`"] = $theValue;

	// Field qualifications
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_qualifications"]) : $GLOBALS["x_qualifications"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`qualifications`"] = $theValue;

	// Field tell_us
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_tell_us"]) : $GLOBALS["x_tell_us"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`tell_us`"] = $theValue;

	// Field notice
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_notice"]) : $GLOBALS["x_notice"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`notice`"] = $theValue;

	// Inserting event
	if (Recordset_Inserting($fieldList)) {

		// Insert
		$sSql = "INSERT INTO `cv` (";
		$sSql .= implode(",", array_keys($fieldList));
		$sSql .= ") VALUES (";
		$sSql .= implode(",", array_values($fieldList));
		$sSql .= ")";	
		phpmkr_query($sSql, $conn) or die("Failed to execute query at line " . __LINE__ . ": " . phpmkr_error($conn) . '<br>SQL: ' . $sSql);
		$fieldList["`cvid`"] = phpmkr_insert_id($conn);
		$result = (phpmkr_affected_rows($conn) > 0);

		// Inserted event
		if ($result) Recordset_Inserted($fieldList);
	} else {
		$result = false;
	}
	return $result;
}

// Inserting event
function Recordset_Inserting(&$newrs)
{

	// Enter your customized codes here
	return true;
}

// Inserted event
function Recordset_Inserted($newrs)
{
	$table = "cv";
}
?>
