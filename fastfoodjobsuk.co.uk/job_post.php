<?php 
require("common_user.php");
checkForAddress();
ob_start();
?>
<?php include ("jobinfo.php") ?>
<?php

// Load key from QueryString
$x_jobid = @$_GET["jobid"];

// Get action
$sAction = @$_POST["a_add"];
if (($sAction == "") || ((is_null($sAction)))) {
		$sAction = "I"; // Display blank record
} else {

	// Get fields from form
	$x_position = @$_POST["x_position"];
	$x_overview = @$_POST["x_overview"];
	$x_salary = @$_POST["x_salary"];
	$x_bonus = @$_POST["x_bonus"];
	$x_benifits = @$_POST["x_benifits"];
	$x_location = @$_POST["x_location"];
	$x_company = @$_POST["x_company"];
	$x_profile = @$_POST["x_profile"];
	$x_contact_email = @$_POST["x_contact_email"];
	$x_link = @$_POST["x_link"];
}
$conn = phpmkr_db_connect(HOST, USER, PASS, DB, PORT);
switch ($sAction) {
	case "A": // Add
		if (AddData($conn)) { // Add new record
			//$_SESSION[ewSessionMessage] = "Job Saved";
			phpmkr_db_close($conn);
			ob_end_clean();
			
			header("Location: job_success.php");
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
//-->
</script>
 <script type="text/javascript">
<!--
function EW_checkMyForm(EW_this) {
<?php if (!isSuperUser(false)){ ?> 
if (EW_this.x_company && !EW_hasValue(EW_this.x_company, "TEXT")) {
	if (!EW_onError(EW_this, EW_this.x_company, "TEXT", "Please enter required field - Company"))
		return false;
}
if (EW_this.x_profile && !EW_hasValue(EW_this.x_profile, "TEXTAREA")) {
	if (!EW_onError(EW_this, EW_this.x_profile, "TEXTAREA", "Please enter required field - Job Profile"))
		return false;
}
if (EW_this.x_contact_email && !EW_hasValue(EW_this.x_contact_email, "TEXT")) {
	if (!EW_onError(EW_this, EW_this.x_contact_email, "TEXT", "Please enter required field - Contact Email"))
		return false;
}
if (EW_this.x_contact_email && !EW_checkemail(EW_this.x_contact_email.value)) {
	if (!EW_onError(EW_this, EW_this.x_contact_email, "TEXT", "Incorrect email - Contact Email"))
		return false; 
}
<?php } ?> 
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
    <h1>Advertise Your Position</h1>
    <div class="roundbottom"> <img src="images/bl_06.gif" alt="edge" class="corner" style=" display: none;" /></div>
   </div></td>
  </tr>
 </table>
<form name="fjobadd" id="fjobadd" action="job_post.php" method="post" onsubmit="return EW_checkMyForm(this);" style= "margin:5px;">
<input type="hidden" name="a_add" value="A">

<?php
	$_SESSION[ewSessionMessage] = ""; // Clear message
?>
<table class="job">
	<tr>
	 <td colspan="2" class="smallRed">* required</td>
	 </tr>
	<tr>
		<td width="134"><span style="font-weight: bold">Position </span></td>
		<td width="316">
		<select id='x_position' name='x_position'>
       <?php
	   $listFile="position_list.htm";
       loadOptions($listFile,$x_position);
      ?></select></td>
	</tr>
	
	<tr>
  <td colspan="2" class="line">&nbsp;</td>
	 </tr>
	<tr>
	 <td colspan="2"><h3><br />
	  Financial Info:</h3></td>
	 </tr>
	<tr>
	 <td >&nbsp;</td>
	 <td class="backgroundBorderStriped">This is used in search</td>
	 </tr>
	<tr>
		<td><span style="font-weight: bold">Yearly Salary Range</span></td>
		<td>
		<select id='x_salary' name='x_salary'>
		<?php
			   loadOptions("salary_list.htm",@$x_salary);
		?>
		</select>
		</td>
	</tr>	
	<tr>
	 <td >&nbsp;</td>
	 <td class="backgroundBorderStriped">This will be displayed to jobseekers. e.g. £10/h+bonus</td>
	 </tr>	 
	<tr>
		<td><span style="font-weight: bold">Salary Detail</span></td>
		<td><input class = "detail" type="text" name="x_bonus" id="x_bonus" value="<?php echo htmlspecialchars(@$x_bonus) ?>"></td>
	</tr>
	<!--
	<tr>
		<td><span style="font-weight: bold">Benefits</span></td>
		<td>
			<input type="radio" name="x_benifits"<?php if (@$x_benifits == "yes") { ?> checked<?php } ?> value="yes">yes	
			<input type="radio" name="x_benifits"<?php if (@$x_benifits == "no") { ?> checked<?php } ?> value="no">no			</td>
	</tr>
	-->
	<tr>
	 <td colspan="2" class="line">&nbsp;</td>
	 </tr>
	<tr>
	 <td colspan="2"><h3><br />
	  Personal Info:</h3></td>
	 </tr>
	<tr>
		<td><span style="font-weight: bold">Location</span></td>
		<td>
        <select d='x_location' name='x_location'>
		<?php
       	loadOptions("county_list.htm",$x_location);
       ?>
      </select></td>
	</tr>

	<tr>
  <td>&nbsp;</td>
	 <td class="backgroundBorderStriped">Your job description must not discriminate directly or indirectly against an applicant on the basis of gender, marital status, nationality, race, disability, religious beliefs or sexual orientation.</td>
	 </tr>
	<tr>
		<td><span style="font-weight: bold">Job Description</span><span>&nbsp;*</span></td>
		<td>
<textarea  class = "detail" name="x_profile" cols="35" rows="6" id="x_profile"><?php echo @$x_profile; ?></textarea></td>
	</tr>
	<tr>
		<td><span style="font-weight: bold">Recruiter / Company</span><span>&nbsp;*</span></td>
		<td>
<input  class = "detail" type="text" name="x_company" id="x_company" value="<?php echo htmlspecialchars(@$x_company) ?>"></td>
	</tr>    
	<tr>
		<td><span style="font-weight: bold">Contact Email</span><span>&nbsp;*</span></td>
		<td>
<input  class = "detail" type="text" name="x_contact_email" id="x_contact_email" value="<?php echo htmlspecialchars(@$x_contact_email) ?>"></td>
	</tr>
    <?php if (isSuperUser(false)){ ?> 
	<tr>
		<td bgcolor="#FF9900"><span style="font-weight: bold">External Job Link (Super user only) </span></td>
		<td bgcolor="#FF9900">
<input  class = "detail" name="x_link" type="text" id="x_link" value="<?php echo htmlspecialchars(@$x_link) ?>" size="45"></td>
	</tr>    
    <?php } ?> <tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="btnAction" id="btnAction" value="Post Job"></td>
	</tr> 
</table>
<p>

</form>

<?php

//-------------------------------------------------------------------------------
// Function AddData
// - Add Data
// - Variables used: field variables

function AddData($conn)
{
	global $x_jobid, $user;
	$sFilter = ewSqlKeyWhere;

	// Check for duplicate key
	$bCheckKey = true;
	if ((@$x_jobid == "") || (is_null(@$x_jobid))) {
		$bCheckKey = false;
	} else {
		$sFilter = str_replace("@jobid", AdjustSql($x_jobid), $sFilter); // Replace key value
	}
	if ($bCheckKey) {
		$sSqlChk = ewBuildSql(ewSqlSelect, ewSqlWhere, ewSqlGroupBy, ewSqlHaving, ewSqlOrderBy, $sFilter, "");
		$rsChk = phpmkr_query($sSqlChk, $conn) or die("Failed to execute query at line " . __LINE__ . ": " . phpmkr_error($conn) . '<br>SQL: ' . $sSqlChk);
		if (phpmkr_num_rows($rsChk) > 0) {
			$_SESSION[ewSessionMessage] = "Duplicate value for primary key";
			phpmkr_free_result($rsChk);
			return false;
		}
		phpmkr_free_result($rsChk);
	}

	// Field onlineuser_onlineuserid
	$fieldList["`onlineuser_onlineuserid`"] = $user->onlineuserId;
	// Field job_status
	$fieldList["`job_status`"] = " 'active'";		
	// Field expiry
	$fieldList["`dt_expire`"] = "'".expiryDate()."'";			

	// Field position
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_position"]) : $GLOBALS["x_position"]; 	
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";	
	$fieldList["`position`"] = $theValue;

	// Field overview
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_overview"]) : $GLOBALS["x_overview"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`overview`"] = $theValue;

	// Field salary
	$theValue = ($GLOBALS["x_salary"] != "") ? intval($GLOBALS["x_salary"]) : "NULL";
	$fieldList["`salary`"] = $theValue;

	// Field bonus
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_bonus"]) : $GLOBALS["x_bonus"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";	
	$fieldList["`bonus`"] = $theValue;

	// Field benifits
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_benifits"]) : $GLOBALS["x_benifits"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`benifits`"] = $theValue;

	// Field location
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_location"]) : $GLOBALS["x_location"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`location`"] = $theValue;

	// Field company
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_company"]) : $GLOBALS["x_company"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`company`"] = $theValue;

	// Field profile
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_profile"]) : $GLOBALS["x_profile"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`profile`"] = $theValue;

	// Field contact_email
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_contact_email"]) : $GLOBALS["x_contact_email"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`contact_email`"] = $theValue;
	
	// Field link
	$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_link"]) : $GLOBALS["x_link"]; 
	$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
	$fieldList["`link`"] = $theValue;	


	// Inserting event
	if (Recordset_Inserting($fieldList)) {

		// Insert
		$sSql =  "INSERT INTO `job` (";
		$sSql .= implode(",", array_keys($fieldList));
		$sSql .= ") VALUES (";
		$sSql .= implode(",", array_values($fieldList));
		$sSql .= ")";	

		phpmkr_query($sSql, $conn) or die("Failed to execute query at line " . __LINE__ . ": " . phpmkr_error($conn) . '<br>SQL: ' . $sSql);
		$result = (phpmkr_affected_rows($conn) > 0);

		// Inserted event
		if ($result) 
			Recordset_Inserted($fieldList);
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
{//
}
?>
<?php
	include("bottom.php");
?>
<?php
phpmkr_db_close($conn);
?>
