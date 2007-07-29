<?php 
require("common_user.php");
$user->canSearchCV();
ob_start();
?>
<?php include ("cvinfo.php") ?>
<?php

// Get action
$sAction = @$_POST["a_search"];
switch ($sAction) {
	case "S": // Get search criteria

	// Build search string for advanced search, remove blank field
	$sSrchStr = "";

	// Field uk_license
	$x_uk_license = @$_POST["x_uk_license"];
	$z_uk_license = (get_magic_quotes_gpc()) ? stripslashes(@$_POST["z_uk_license"]) : @$_POST["z_uk_license"]; 
	$sSrchWrk = "";
	if ($x_uk_license <> "") {
		$sSrchWrk .= "x_uk_license=" . urlencode($x_uk_license);
		$sSrchWrk .= "&z_uk_license=" . urlencode($z_uk_license);
	}
	if ($sSrchWrk <> "") {
		if ($sSrchStr <> "") $sSrchStr .= "&";
		$sSrchStr .= $sSrchWrk;
	}

	// Field european_license
	$x_european_license = @$_POST["x_european_license"];
	$z_european_license = (get_magic_quotes_gpc()) ? stripslashes(@$_POST["z_european_license"]) : @$_POST["z_european_license"]; 
	$sSrchWrk = "";
	if ($x_european_license <> "") {
		$sSrchWrk .= "x_european_license=" . urlencode($x_european_license);
		$sSrchWrk .= "&z_european_license=" . urlencode($z_european_license);
	}
	if ($sSrchWrk <> "") {
		if ($sSrchStr <> "") $sSrchStr .= "&";
		$sSrchStr .= $sSrchWrk;
	}

	// Field marital_status
	$x_marital_status = @$_POST["x_marital_status"];
	$z_marital_status = (get_magic_quotes_gpc()) ? stripslashes(@$_POST["z_marital_status"]) : @$_POST["z_marital_status"]; 
	$sSrchWrk = "";
	if ($x_marital_status <> "") {
		$sSrchWrk .= "x_marital_status=" . urlencode($x_marital_status);
		$sSrchWrk .= "&z_marital_status=" . urlencode($z_marital_status);
	}
	if ($sSrchWrk <> "") {
		if ($sSrchStr <> "") $sSrchStr .= "&";
		$sSrchStr .= $sSrchWrk;
	}

	// Field has_dependent
	$x_has_dependent = @$_POST["x_has_dependent"];
	$z_has_dependent = (get_magic_quotes_gpc()) ? stripslashes(@$_POST["z_has_dependent"]) : @$_POST["z_has_dependent"]; 
	$sSrchWrk = "";
	if ($x_has_dependent <> "") {
		$sSrchWrk .= "x_has_dependent=" . urlencode($x_has_dependent);
		$sSrchWrk .= "&z_has_dependent=" . urlencode($z_has_dependent);
	}
	if ($sSrchWrk <> "") {
		if ($sSrchStr <> "") $sSrchStr .= "&";
		$sSrchStr .= $sSrchWrk;
	}

	// Field can_relocate
	$x_can_relocate = @$_POST["x_can_relocate"];
	$z_can_relocate = (get_magic_quotes_gpc()) ? stripslashes(@$_POST["z_can_relocate"]) : @$_POST["z_can_relocate"]; 
	$sSrchWrk = "";
	if ($x_can_relocate <> "") {
		$sSrchWrk .= "x_can_relocate=" . urlencode($x_can_relocate);
		$sSrchWrk .= "&z_can_relocate=" . urlencode($z_can_relocate);
	}
	if ($sSrchWrk <> "") {
		if ($sSrchStr <> "") $sSrchStr .= "&";
		$sSrchStr .= $sSrchWrk;
	}

	// Field can_travel
	$x_can_travel = @$_POST["x_can_travel"];
	$z_can_travel = (get_magic_quotes_gpc()) ? stripslashes(@$_POST["z_can_travel"]) : @$_POST["z_can_travel"]; 
	$sSrchWrk = "";
	if ($x_can_travel <> "") {
		$sSrchWrk .= "x_can_travel=" . urlencode($x_can_travel);
		$sSrchWrk .= "&z_can_travel=" . urlencode($z_can_travel);
	}
	if ($sSrchWrk <> "") {
		if ($sSrchStr <> "") $sSrchStr .= "&";
		$sSrchStr .= $sSrchWrk;
	}

	// Field employement_status
	$x_employement_status = @$_POST["x_employement_status"];
	$z_employement_status = (get_magic_quotes_gpc()) ? stripslashes(@$_POST["z_employement_status"]) : @$_POST["z_employement_status"]; 
	$sSrchWrk = "";
	if ($x_employement_status <> "") {
		$sSrchWrk .= "x_employement_status=" . urlencode($x_employement_status);
		$sSrchWrk .= "&z_employement_status=" . urlencode($z_employement_status);
	}
	if ($sSrchWrk <> "") {
		if ($sSrchStr <> "") $sSrchStr .= "&";
		$sSrchStr .= $sSrchWrk;
	}

	// Field position_held
	$x_position_held = @$_POST["x_position_held"];
	$z_position_held = (get_magic_quotes_gpc()) ? stripslashes(@$_POST["z_position_held"]) : @$_POST["z_position_held"]; 
	$sSrchWrk = "";
	if ($x_position_held <> "") {
		$sSrchWrk .= "x_position_held=" . urlencode($x_position_held);
		$sSrchWrk .= "&z_position_held=" . urlencode($z_position_held);
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

	// Field salary_expectation_start
	$x_salary_expectation_start = @$_POST["x_salary_expectation_start"];
	$z_salary_expectation_start = (get_magic_quotes_gpc()) ? stripslashes(@$_POST["z_salary_expectation_start"]) : @$_POST["z_salary_expectation_start"]; 
	$sSrchWrk = "";
	if ($x_salary_expectation_start <> "") {
		$sSrchWrk .= "x_salary_expectation_start=" . urlencode($x_salary_expectation_start);
		$sSrchWrk .= "&z_salary_expectation_start=" . urlencode($z_salary_expectation_start);
	}
	if ($sSrchWrk <> "") {
		if ($sSrchStr <> "") $sSrchStr .= "&";
		$sSrchStr .= $sSrchWrk;
	}

	// Field salary_expectation_one
	$x_salary_expectation_one = @$_POST["x_salary_expectation_one"];
	$z_salary_expectation_one = (get_magic_quotes_gpc()) ? stripslashes(@$_POST["z_salary_expectation_one"]) : @$_POST["z_salary_expectation_one"]; 
	$sSrchWrk = "";
	if ($x_salary_expectation_one <> "") {
		$sSrchWrk .= "x_salary_expectation_one=" . urlencode($x_salary_expectation_one);
		$sSrchWrk .= "&z_salary_expectation_one=" . urlencode($z_salary_expectation_one);
	}
	if ($sSrchWrk <> "") {
		if ($sSrchStr <> "") $sSrchStr .= "&";
		$sSrchStr .= $sSrchWrk;
	}

	// Field salary_expectation_two
	$x_salary_expectation_two = @$_POST["x_salary_expectation_two"];
	$z_salary_expectation_two = (get_magic_quotes_gpc()) ? stripslashes(@$_POST["z_salary_expectation_two"]) : @$_POST["z_salary_expectation_two"]; 
	$sSrchWrk = "";
	if ($x_salary_expectation_two <> "") {
		$sSrchWrk .= "x_salary_expectation_two=" . urlencode($x_salary_expectation_two);
		$sSrchWrk .= "&z_salary_expectation_two=" . urlencode($z_salary_expectation_two);
	}
	if ($sSrchWrk <> "") {
		if ($sSrchStr <> "") $sSrchStr .= "&";
		$sSrchStr .= $sSrchWrk;
	}

	// Field achievement_sales
	$x_achievement_sales = @$_POST["x_achievement_sales"];
	$z_achievement_sales = (get_magic_quotes_gpc()) ? stripslashes(@$_POST["z_achievement_sales"]) : @$_POST["z_achievement_sales"]; 
	$sSrchWrk = "";
	if ($x_achievement_sales <> "") {
		$sSrchWrk .= "x_achievement_sales=" . urlencode($x_achievement_sales);
		$sSrchWrk .= "&z_achievement_sales=" . urlencode($z_achievement_sales);
	}
	if ($sSrchWrk <> "") {
		if ($sSrchStr <> "") $sSrchStr .= "&";
		$sSrchStr .= $sSrchWrk;
	}

	// Field achievement_food
	$x_achievement_food = @$_POST["x_achievement_food"];
	$z_achievement_food = (get_magic_quotes_gpc()) ? stripslashes(@$_POST["z_achievement_food"]) : @$_POST["z_achievement_food"]; 
	$sSrchWrk = "";
	if ($x_achievement_food <> "") {
		$sSrchWrk .= "x_achievement_food=" . urlencode($x_achievement_food);
		$sSrchWrk .= "&z_achievement_food=" . urlencode($z_achievement_food);
	}
	if ($sSrchWrk <> "") {
		if ($sSrchStr <> "") $sSrchStr .= "&";
		$sSrchStr .= $sSrchWrk;
	}

	// Field achievement_labour
	$x_achievement_labour = @$_POST["x_achievement_labour"];
	$z_achievement_labour = (get_magic_quotes_gpc()) ? stripslashes(@$_POST["z_achievement_labour"]) : @$_POST["z_achievement_labour"]; 
	$sSrchWrk = "";
	if ($x_achievement_labour <> "") {
		$sSrchWrk .= "x_achievement_labour=" . urlencode($x_achievement_labour);
		$sSrchWrk .= "&z_achievement_labour=" . urlencode($z_achievement_labour);
	}
	if ($sSrchWrk <> "") {
		if ($sSrchStr <> "") $sSrchStr .= "&";
		$sSrchStr .= $sSrchWrk;
	}

	// Field notice
	$x_notice = @$_POST["x_notice"];
	$z_notice = (get_magic_quotes_gpc()) ? stripslashes(@$_POST["z_notice"]) : @$_POST["z_notice"]; 
	$sSrchWrk = "";
	if ($x_notice <> "") {
		$sSrchWrk .= "x_notice=" . urlencode($x_notice);
		$sSrchWrk .= "&z_notice=" . urlencode($z_notice);
	}
	if ($sSrchWrk <> "") {
		if ($sSrchStr <> "") $sSrchStr .= "&";
		$sSrchStr .= $sSrchWrk;
	}
	if ($sSrchStr <> "") {
		ob_end_clean();
		header("Location: cvlist.php" . "?" . $sSrchStr);
		exit();
	}
	break;
	default: // Restore search settings
		$x_uk_license = @$_SESSION[ewSessionTblAdvSrch . "_x_uk_license"];
		$x_european_license = @$_SESSION[ewSessionTblAdvSrch . "_x_european_license"];
		$x_marital_status = @$_SESSION[ewSessionTblAdvSrch . "_x_marital_status"];
		$x_has_dependent = @$_SESSION[ewSessionTblAdvSrch . "_x_has_dependent"];
		$x_can_relocate = @$_SESSION[ewSessionTblAdvSrch . "_x_can_relocate"];
		$x_can_travel = @$_SESSION[ewSessionTblAdvSrch . "_x_can_travel"];
		$x_employement_status = @$_SESSION[ewSessionTblAdvSrch . "_x_employement_status"];
		$x_position_held = @$_SESSION[ewSessionTblAdvSrch . "_x_position_held"];
		$x_salary = @$_SESSION[ewSessionTblAdvSrch . "_x_salary"];
		$x_salary_expectation_start = @$_SESSION[ewSessionTblAdvSrch . "_x_salary_expectation_start"];
		$x_salary_expectation_one = @$_SESSION[ewSessionTblAdvSrch . "_x_salary_expectation_one"];
		$x_salary_expectation_two = @$_SESSION[ewSessionTblAdvSrch . "_x_salary_expectation_two"];
		$x_achievement_sales = @$_SESSION[ewSessionTblAdvSrch . "_x_achievement_sales"];
		$x_achievement_food = @$_SESSION[ewSessionTblAdvSrch . "_x_achievement_food"];
		$x_achievement_labour = @$_SESSION[ewSessionTblAdvSrch . "_x_achievement_labour"];
		$x_notice = @$_SESSION[ewSessionTblAdvSrch . "_x_notice"];
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
if (EW_this.x_can_travel && !EW_checkinteger(EW_this.x_can_travel.value)) {
	if (!EW_onError(EW_this, EW_this.x_can_travel, "TEXT", "Incorrect integer - Willing to travel"))
		return false; 
}
return true;
}

//-->
</script>

 <table width="459" border="0" cellspacing="0" cellpadding="0" >
  <tr>
   <td><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /></td>
  </tr>
  <tr>
   <td><div class="roundcont">
     <div class="roundtop"> <img class="corner" src="images/bl_01.gif" alt="edge" style=" display: none;" /></div>
    <h1>Search Job Seeker Profile</h1>
    <div class="roundbottom"> <img src="images/bl_06.gif" alt="edge" class="corner" style=" display: none;" /></div>
   </div></td>
  </tr>
 </table>
 <table border="0" cellspacing="0" cellpadding="0">
  <tr>
   <td valign="top" width="445"><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /> </td>
  </tr>
  <tr>
   <td valign="top" width="445">
     </td>
  </tr>
  <tr>
   <td></td>
  </tr>
 </table>

<form name="fcvsearch" id="fcvsearch" action="cv_search.php" method="post" onsubmit="return EW_checkMyForm(this);">
<p>
<input type="hidden" name="a_search" value="S">
<table class = "job">
	<tr>
		<td><span>Full clean UK driving license </span></td>
		<td><span>
		<input type="hidden" name="z_uk_license" value="=,,"></span></td>
		<td><span>
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
		<td><span>
		  <input type="hidden" name="z_european_license" value="=,,"></span></td>
		<td><span>
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
		<td><span>Marital Status</span></td>
		<td><span>
		  <input type="hidden" name="z_marital_status" value="=,','"></span></td>
		<td><span>
<?php
$x_marital_statusList = "<select id='x_marital_status' name='x_marital_status'>";
$x_marital_statusList .= "<option value=''>Any</option>";
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
		<td><span>
		  <input type="hidden" name="z_has_dependent" value="=,,"></span></td>
		<td><span>
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
		<td><span>
		  <input type="hidden" name="z_can_relocate" value="=,,"></span></td>
		<td><span>
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
		<td><input type="hidden" name="z_can_travel" value=">=,,"></td>
		<td><span>
<input type="text" name="x_can_travel" id="x_can_travel" size="3" value="<?php echo htmlspecialchars(@$x_can_travel) ?>"> 
miles or more
</span></td>
	</tr>
	<tr>
		<td><span>Current Employment Status</span></td>
		<td><span>
		  <input type="hidden" name="z_employement_status" value="=,','"></span>
		 </td>
		<td>
		<select id='x_employement_status' name='x_employement_status'>
		<option value=''>Any</option>
		<?php
			   loadOptions("employement_status_list.htm",@$x_employement_status);
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td><span>Current / Last position held</span></td>
		<td><span>

		  <input type="hidden" name="z_position_held" value="=,','"></span></td>
		<td>
		<select name='x_position_held' size="6" multiple="multiple" id='x_position_held'>
		<?php
			   loadOptions("position_list.htm",@$x_position_held);
		?>
		</select>
		</td>
		<td class="ewTableRow">
	</tr>
	<tr>
		<td><span>Current / last salary</span></td>
		<td><span>
		  <input type="hidden" name="z_salary" value="=,','"></span></td>
		<td>
		<select id='x_salary' name='x_salary'>
		<option value=''>Any </option>
		<?php
			   loadOptions("salary_list.htm",@$x_salary);
		?>
		</select>		  
		</td>
	</tr>
	<tr>
		<td><span>Salary Expectations Start</span></td>
		<td><span>
		  <input type="hidden" name="z_salary_expectation_start" value="=,','"></span></td>
		<td>
		<select id='x_salary_expectation_start' name='x_salary_expectation_start'>
		<option value=''>Any </option>
		<?php
			   loadOptions("salary_list.htm",@$x_salary_expectation_start);
		?>
		</select>
		</td>	</tr>
	<tr>
		<td><span>Within a year</span></td>
		<td><span>
		  <input type="hidden" name="z_salary_expectation_one" value="=,','"></span></td>
		<td><select id='x_salary_expectation_one' name='x_salary_expectation_one'>
		<option value=''>Any </option>
		<?php
			   loadOptions("salary_list.htm",@$x_salary_expectation_one);
		?>
		</select></td>	</tr>
	<tr>
		<td><span>Within 2-3 years</span></td>
		<td><span>
		  <input type="hidden" name="z_salary_expectation_two" value="=,','"></span></td>
		<td>
		<select id='x_salary_expectation_two' name='x_salary_expectation_two'>
		<option value=''>Any </option>
		<?php
			   loadOptions("salary_list.htm",@$x_salary_expectation_two);
		?>
		</select>
		</td>	</tr>
	<tr>
		<td><span>Achievement last 12 months Sales</span></td>
		<td><span>
		  <input type="hidden" name="z_achievement_sales" value="=,','"></span></td>
		<td>
		<select id='x_achievement_sales' name='x_achievement_sales'>
		<option value=''>Any </option>
		<?php
			   loadOptions("achievement_list.htm",@$x_achievement_sales);
		?>
		</select>
		</td>		</tr>
	<tr>
		<td><span>Food Cost</span></td>
		<td><span>
		  <input type="hidden" name="z_achievement_food" value="=,','"></span></td>
		<td>
		<select id='x_achievement_food' name='x_achievement_food'>
		<option value=''>Any </option>
		<?php
			   loadOptions("achievement_list.htm",@$x_achievement_food);
		?>
		</select>
		</td>	
	</tr>
	<tr>
		<td><span>Labour Cost</span></td>
		<td><span>
		  <input type="hidden" name="z_achievement_labour" value="=,','"></span></td>
		<td>
		<select id='x_achievement_labour' name='x_achievement_labour'>
		<option value=''>Any </option>
		<?php
			   loadOptions("achievement_list.htm",@$x_achievement_labour);
		?>
		</select>
		</td>	
	</tr>
	<tr>
		<td><span>Notice required in current position</span></td>
		<td><input type="hidden" name="z_notice" value="<=,','"></td>
		<td>
		<select id='x_notice' name='x_notice'>
		<?php
			   loadOptions("notice_period_list_reverse.htm",@$x_notice);
		?>
		</select> 
		or less </td>		
	</tr>
</table>
<p>
<input type="submit" name="Action" value="Search">
<input type="button" name="Reset" value="Reset" onclick="EW_clearForm(this.form);">
</form>
<?php include ("bottom.php") ?>
<?php
phpmkr_db_close($conn);
?>
