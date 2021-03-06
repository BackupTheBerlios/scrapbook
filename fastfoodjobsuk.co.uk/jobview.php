<?php 
require("common_user.php");
ob_start();
?>
<?php include ("jobinfo.php") ?>
<?php

// Get key
$x_jobid = @$_GET["jobid"];
if (($x_jobid == "") || (is_null($x_jobid))) {
	ob_end_clean();
	header("Location: joblist.php");
	exit();
}
if (!is_numeric($x_jobid)) {
	ob_end_clean();
	header("Location: joblist.php");
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
			header("Location: job_search.php");
			exit();
		}
		else
		{	
			$toDay = date("Y-m-d");
			if ($x_job_status!='active'||$x_dt_expire < $toDay )
			{
				ob_end_clean();
				header("Location: job_search.php");
				exit();
			}
		}
}
?>
<?php include ("top.php") ?>
<script type="text/javascript" src="ewp.js"></script>

<table width="459" border="0" cellspacing="0" cellpadding="0" >
 <tr>
  <td><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /></td>
 </tr>
 <tr>
  <td><div class="roundcont">
   <div class="roundtop"> <img class="corner" src="images/bl_01.gif" alt="edge" style=" display: none;" /></div>
   <h1>Job Detail </h1>
   <div class="roundbottom"> <img src="images/bl_06.gif" alt="edge" class="corner" style=" display: none;" /></div>
  </div></td>
 </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top" width="434"><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /> </td>
 </tr>
 <tr>
  <td valign="top" width="434"  style = "padding-left:5px;">
    <a href="joblist.php" class = "news">Back to List</a>
    <br />
    <br /></td>
 </tr>
 <tr>
  <td></td>
 </tr>
</table>

<form>
<table bgcolor="#FFFFFF" class = "job">
	<tr>
	    <td colspan="2" bgcolor="#E3E3E3"><h3><?php echo $x_position; ?></h3></td>
	</tr>
	<tr>
	    <td bgcolor="#FFFFFF"><span style="font-weight: bold">Salary</span></td>
		    <td bgcolor="#FFFFFF">
            <?php echo $x_bonus; ?>            </td>
	    </tr>
		<!--
	<tr>
	    <td bgcolor="#FFFFFF"><span style="font-weight: bold">Bonus</span></td>
		    <td bgcolor="#FFFFFF">
            <?php echo $x_bonus; ?>  </td>
	    </tr>
		-->
	<tr>
	    <td bgcolor="#FFFFFF"><span style="font-weight: bold">Benefits</span></td>
		    <td bgcolor="#FFFFFF">
            <?php echo $x_benifits; ?>            </td>
	    </tr>
	<tr>
	    <td bgcolor="#FFFFFF"><span style="font-weight: bold">Location</span></td>
		    <td bgcolor="#FFFFFF">
    <?php echo $x_location; ?>	 </td>
	    </tr>
	<tr>
        <td bgcolor="#FFFFFF"><span style="font-weight: bold">Date Posted</span></td>
	    <td bgcolor="#FFFFFF"><?php echo FormatDateTime($x_dt_created,7); ?> </td>
	    </tr>
	<tr>
	    <td bgcolor="#FFFFFF"><span style="font-weight: bold">Recruiter / Company</span></td>
		    <td bgcolor="#FFFFFF">
            <?php echo $x_company; ?>            </td>
	    </tr>
	<tr>
	    <td bgcolor="#FFFFFF"><span style="font-weight: bold">Job description</span></td>
		    <td bgcolor="#FFFFFF">
            <?php echo str_replace(chr(10), "<br>", $x_profile); ?>            </td>
	    </tr>
		<tr>
	    <td bgcolor="#FFFFFF"><span style="font-weight: bold">Contact detail</span></td>
		    <td bgcolor="#FFFFFF">
           
            <a href="mailto:<?php echo $x_contact_email; ?>" class='news'><?php echo $x_contact_email; ?></a></td>
	    </tr>
        <?php if (isSuperUser(false)){ ?> 
			<tr>
	    		<td bgcolor="#FFFFFF"><span style="font-weight: bold">Expiry Date</span></td>
                <td bgcolor="#FFFFFF">
                    <?php echo FormatDateTime($x_dt_expire,7); ?> </td>
	    	</tr>
        <?php } ?>
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
	global $x_jobid;
	$sFilter = ewSqlKeyWhere;
	if (!is_numeric($x_jobid)) return false;
	$x_jobid =  (get_magic_quotes_gpc()) ? stripslashes($x_jobid) : $x_jobid;
	$sFilter = str_replace("@jobid", AdjustSql($x_jobid), $sFilter); // Replace key value
	$sSql = ewBuildSql(ewSqlSelect, ewSqlWhere, ewSqlGroupBy, ewSqlHaving, ewSqlOrderBy, $sFilter, "");
	$rs = phpmkr_query($sSql,$conn) or die("Failed to execute query at line " . __LINE__ . ": " . phpmkr_error($conn) . '<br>SQL: ' . $sSql);
	if (phpmkr_num_rows($rs) == 0) {
		$bLoadData = false;
	} else {
		$bLoadData = true;
		$row = phpmkr_fetch_array($rs);

		// Get the field contents
		$GLOBALS["x_jobid"] = $row["jobid"];
		$GLOBALS["x_onlineuser_onlineuserid"] = $row["onlineuser_onlineuserid"];
		$GLOBALS["x_position"] = $row["position"];
		$GLOBALS["x_overview"] = $row["overview"];
		$GLOBALS["x_salary"] = $row["salary"];
		$GLOBALS["x_bonus"] = $row["bonus"];
		$GLOBALS["x_benifits"] = $row["benifits"];
		$GLOBALS["x_location"] = $row["location"];
		$GLOBALS["x_company"] = $row["company"];
		$GLOBALS["x_profile"] = $row["profile"];
		$GLOBALS["x_contact_email"] = $row["contact_email"];
		$GLOBALS["x_dt_created"] = $row["dt_created"];
		$GLOBALS["x_dt_expire"] = $row["dt_expire"];
		$GLOBALS["x_job_status"] = $row["job_status"];
	}
	phpmkr_free_result($rs);
	return $bLoadData;
}
?>
