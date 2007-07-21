<?php 
require("common_user.php");
checkForAddress();
ob_start();
?>
<?php include ("jobinfo.php") ?>
<?php

// Load key from QueryString
$x_jobid = @$_GET["jobid"];
if (($x_jobid == "") || (is_null($x_jobid))) 
	$sAction = "AI"; //new form

// Get action
$sAction = @$_POST["x_action"];
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
	$x_job_status = @$_POST["x_job_status"];
}
$conn = phpmkr_db_connect(HOST, USER, PASS, DB, PORT);
switch ($sAction) {
	case "A": // Add
		if (AddData($conn)) { // Add new record
			$_SESSION[ewSessionMessage] = "Job Saved";
			phpmkr_db_close($conn);
			ob_end_clean();
			
			header("Location: job_success.php");
			exit();
		}
		break;
	case "U": // Update
		if (EditData($conn)) { // Update record
			$_SESSION[ewSessionMessage] = "Update Record Successful";
			phpmkr_db_close($conn);
			ob_end_clean();
			header("Location: joblist.php");
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
if (EW_this.x_overview && !EW_hasValue(EW_this.x_overview, "TEXTAREA")) {
	if (!EW_onError(EW_this, EW_this.x_overview, "TEXTAREA", "Please enter required field - Overview"))
		return false;
}
if (EW_this.x_salary && !EW_checkinteger(EW_this.x_salary.value)) {
	if (!EW_onError(EW_this, EW_this.x_salary, "TEXT", "Incorrect amount - salary"))
		return false; 
}
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
return true;
}

//-->
</script>
 <h2 style = "margin-left:5px;">Create your job post </h2>
<form name="fjobadd" id="fjobadd" action="job_post.php" method="post" onsubmit="return EW_checkMyForm(this);" style= "margin:5px;">
<p>
<input type="hidden" name="x_action" value="A">
<input type="hidden" id="x_jobid" name="x_jobid" value="<?php echo @$x_jobid; ?>">
<?php
if (@$_SESSION[ewSessionMessage] <> "") {
?>
<p><?php echo $_SESSION[ewSessionMessage] ?></p>
<?php
	$_SESSION[ewSessionMessage] = ""; // Clear message
}
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
	 <td>&nbsp;</td>
	 <td class="backgroundBorderStriped">Your job description must not discriminate directly or indirectly against an applicant on the basis of gender, marital status, nationality, race, disability, religious beliefs or sexual orientation.</td>
	 </tr>
	<tr>
		<td><span style="font-weight: bold">Job description</span><span>&nbsp;* <br />
		    (Up to 255 letters)</span></td>
		<td>
        <textarea name="x_overview" cols="35" rows="3" id="x_overview"><?php echo @$x_overview; ?></textarea></td>
	</tr>
	<tr>
	 <td colspan="2" class="line">&nbsp;</td>
	 </tr>
	<tr>
	 <td colspan="2"><h3>Financial Info:</h3></td>
	 </tr>
	<tr>
		<td><span style="font-weight: bold">Yearly Salary</span></td>
		<td><input type="text" name="x_salary" id="x_salary" value="<?php echo htmlspecialchars(@$x_salary) ?>"> 
		    GBP		</td>
	</tr>
	<tr>
		<td><span style="font-weight: bold">Bonus</span></td>
		<td>
<input type="text" name="x_bonus" id="x_bonus" value="<?php echo htmlspecialchars(@$x_bonus) ?>">		</td>
	</tr>
	<tr>
		<td><span style="font-weight: bold">Benifits</span></td>
		<td>
<input type="text" name="x_benifits" id="x_benifits" value="<?php echo htmlspecialchars(@$x_benifits) ?>">		</td>
	</tr>
	<tr>
	 <td colspan="2" class="line">&nbsp;</td>
	 </tr>
	<tr>
	 <td colspan="2"><h3>Personal Info:</h3></td>
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
		<td><span style="font-weight: bold">Profile</span><span>&nbsp;*</span></td>
		<td>
<textarea name="x_profile" cols="35" rows="6" id="x_profile"><?php echo @$x_profile; ?></textarea></td>
	</tr>
	<tr>
		<td><span style="font-weight: bold">Recruiter / Company</span><span>&nbsp;*</span></td>
		<td>
<input type="text" name="x_company" id="x_company" value="<?php echo htmlspecialchars(@$x_company) ?>"></td>
	</tr>    
	<tr>
		<td><span style="font-weight: bold">Contact Email</span><span>&nbsp;*</span></td>
		<td>
<input type="text" name="x_contact_email" id="x_contact_email" value="<?php echo htmlspecialchars(@$x_contact_email) ?>"></td>
	</tr>
    <?php if (isSuperUser(false)){ ?> 
	<tr>
		<td bgcolor="#FF9900"><span style="font-weight: bold">External Job Link (Super user only) </span></td>
		<td bgcolor="#FF9900">
<input name="x_link" type="text" id="x_link" value="<?php echo htmlspecialchars(@$x_link) ?>" size="45"></td>
	</tr>    
    <?php } ?> 
<?php $x_job_status = "temp" // Set default value ?>
<input type="hidden" id="x_job_status" name="x_job_status" value="<?php echo @$x_job_status; ?>">
</table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="Post Job">
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
	// Field dt_expire
	$fieldList["`dt_expire`"] = " '".expiryDate()."'";
	// Field job_status, free for now
	$fieldList["`job_status`"] = " 'active'";		
	

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
{
	/*send admin eamil??
		global $sEmailSubject;
	global $sEmailFrom;
	global $sEmailTo;
	global $sEmailCc;
	global $sEmailBcc;
	global $sEmailFormat;
	global $sEmailContent;
	$table = "job";

	// Send email
	$keyvalue = $newrs["`jobid`"];
	$sEmail = ""; // notify email
	$sEmailSubject = ""; $sEmailFrom = ""; $sEmailTo = ""; $sEmailCc = ""; $sEmailBcc = ""; $sEmailFormat = ""; $sEmailContent = "";
	LoadEmail("notify.txt");
	$sEmailFrom = str_replace("<!--\$From-->", "support@fastfoodjobsuk.co.uk", $sEmailFrom); // Replace Sender
	$sEmailTo = str_replace("<!--\$To-->", $sEmail, $sEmailTo); // Replace Receiver
	$sEmailSubject = str_replace("<!--\$Subject-->", $table . " record inserted", $sEmailSubject ); // Replace Subject
	$sEmailContent = str_replace("<!--table-->", $table, $sEmailContent);
	$sEmailContent = str_replace("<!--key-->", $keyvalue, $sEmailContent);
	$sEmailContent = str_replace("<!--action-->", "Inserted", $sEmailContent);
	@Send_Email($sEmailFrom, $sEmailTo, $sEmailCc, $sEmailBcc, $sEmailSubject, $sEmailContent, $sEmailFormat);
	*/
}
?>
<?php

//-------------------------------------------------------------------------------
// Function EditData
// - Variables used: field variables

function EditData($conn)
{
	global $x_jobid;
	$sFilter = ewSqlKeyWhere;
	if (!is_numeric($x_jobid)) return false;
	$sTmp =  (get_magic_quotes_gpc()) ? stripslashes($x_jobid) : $x_jobid;
	$sFilter = str_replace("@jobid", AdjustSql($sTmp), $sFilter); // Replace key value
	$sSql = ewBuildSql(ewSqlSelect, ewSqlWhere, ewSqlGroupBy, ewSqlHaving, ewSqlOrderBy, $sFilter, "");
	$rs = phpmkr_query($sSql,$conn) or die("Failed to execute query at line " . __LINE__ . ": " . phpmkr_error($conn) . '<br>SQL: ' . $sSql);

	// Get old recordset
	$oldrs = phpmkr_fetch_array($rs);
	if (phpmkr_num_rows($rs) == 0) {
		return false; // Update Failed
	} else {
		$x_jobid = @$_POST["x_jobid"];
		$x_onlineuser_onlineuserid = @$_POST["x_onlineuser_onlineuserid"];
		$x_position = @$_POST["x_position"];
		$x_overview = @$_POST["x_overview"];
		$x_salary = @$_POST["x_salary"];
		$x_bonus = @$_POST["x_bonus"];
		$x_benifits = @$_POST["x_benifits"];
		$x_location = @$_POST["x_location"];
		$x_company = @$_POST["x_company"];
		$x_profile = @$_POST["x_profile"];
		$x_contact_email = @$_POST["x_contact_email"];
		$x_dt_created = @$_POST["x_dt_created"];
		$x_dt_expire = @$_POST["x_dt_expire"];
		$x_job_status = @$_POST["x_job_status"];
		$theValue = ($GLOBALS["x_jobid"] != "") ? intval($GLOBALS["x_jobid"]) : "NULL";
		$fieldList["`jobid`"] = $theValue;
		$theValue = ($GLOBALS["x_onlineuser_onlineuserid"] != "") ? intval($GLOBALS["x_onlineuser_onlineuserid"]) : "NULL";
		$fieldList["`onlineuser_onlineuserid`"] = $theValue;
		$theValue = ($GLOBALS["x_position"] != "") ? intval($GLOBALS["x_position"]) : "NULL";
		$fieldList["`position`"] = $theValue;
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_overview"]) : $GLOBALS["x_overview"]; 
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["`overview`"] = $theValue;
		$theValue = ($GLOBALS["x_salary"] != "") ? intval($GLOBALS["x_salary"]) : "NULL";
		$fieldList["`salary`"] = $theValue;
		$theValue = ($GLOBALS["x_bonus"] != "") ? intval($GLOBALS["x_bonus"]) : "NULL";
		$fieldList["`bonus`"] = $theValue;
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_benifits"]) : $GLOBALS["x_benifits"]; 
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["`benifits`"] = $theValue;
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_location"]) : $GLOBALS["x_location"]; 
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["`location`"] = $theValue;
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_company"]) : $GLOBALS["x_company"]; 
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["`company`"] = $theValue;
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_profile"]) : $GLOBALS["x_profile"]; 
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["`profile`"] = $theValue;
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_contact_email"]) : $GLOBALS["x_contact_email"]; 
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["`contact_email`"] = $theValue;
		$theValue = ($GLOBALS["x_dt_created"] != "") ? " '" . ConvertDateToMysqlFormat($GLOBALS["x_dt_created"]) . "'" :  "'" . date("D, d M Y H:i:s") . "'";
		$fieldList["`dt_created`"] = $theValue;
		$theValue = ($GLOBALS["x_dt_expire"] != "") ? " '" . ConvertDateToMysqlFormat($GLOBALS["x_dt_expire"]) . "'" : "Null";
		$fieldList["`dt_expire`"] = $theValue;
		$theValue = (!get_magic_quotes_gpc()) ? addslashes($GLOBALS["x_job_status"]) : $GLOBALS["x_job_status"]; 
		$theValue = ($theValue != "") ? " '" . $theValue . "'" : "NULL";
		$fieldList["`job_status`"] = $theValue;

		// Updating event
		if (Recordset_Updating($fieldList, $oldrs)) {

			// Update
			$sSql = "UPDATE `job` SET ";
			foreach ($fieldList as $key=>$temp) {
				$sSql .= "$key = $temp, ";
			}
			if (substr($sSql, -2) == ", ") {
				$sSql = substr($sSql, 0, strlen($sSql)-2);
			}
			$sSql .= " WHERE " . $sFilter;
			phpmkr_query($sSql,$conn) or die("Failed to execute query at line " . __LINE__ . ": " . phpmkr_error($conn) . '<br>SQL: ' . $sSql);
			$result = (phpmkr_affected_rows($conn) >= 0);

			// Updated event
			if ($result) Recordset_Updated($fieldList, $oldrs);
		} else {
			$result = false; // Update Failed
		}
	}
	return $result;
}

// Updating Event
function Recordset_Updating(&$newrs, $oldrs)
{

	// Enter your customized codes here
	return true;
}

// Updated event
function Recordset_Updated($newrs, $oldrs)
{
	$table = "job";
}
?>
<?php
	include("bottom.php");
?>
<?php
phpmkr_db_close($conn);
?>
