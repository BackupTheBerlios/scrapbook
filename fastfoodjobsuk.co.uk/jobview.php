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
			header("Location: joblist.php");
			exit();
		}
}
?>
<?php include ("top.php") ?>
<script type="text/javascript" src="ewp.js"></script>
<p>View Job<br><br>
<a href="joblist.php">Back to List</a>
<?php if (isSuperUser(false)){ ?>   
    &nbsp;
    <a href="<?php if ($x_jobid <> "") {echo "jobedit.php?jobid=" . urlencode($x_jobid); } else { echo "javascript:alert('Invalid Record! Key is null');";} ?>">Edit</a>  
	&nbsp;  
    <a href="<?php if ($x_jobid <> "") {echo "jobdelete.php?jobid=" . urlencode($x_jobid); } else { echo "javascript:alert('Invalid Record! Key is null');";} ?>">Delete</a>&nbsp;</p>
<?php } ?>
<p>
<form>
<table>
	
    <?php if (isSuperUser(false)){ ?> 
  	<tr>
	    <td><span style="font-weight: bold">Job Id</span></td>
		 <td><?php echo $x_jobid; ?></td>
	 </tr>
    <?php } ?>
	<tr>
	    <td><span style="font-weight: bold">Position</span></td>
		    <td>
    <?php echo $x_position; ?>
     </td>
	    </tr>
	<tr>
	    <td><span style="font-weight: bold">Job description</span></td>
		    <td>
            <?php echo str_replace(chr(10), "<br>", $x_overview); ?>            </td>
	    </tr>
	<tr>
	    <td><span style="font-weight: bold">Yearly Salary</span></td>
		    <td>
            &pound;<?php echo $x_salary; ?>            </td>
	    </tr>
	<tr>
	    <td><span style="font-weight: bold">Bonus</span></td>
		    <td>
            <?php echo $x_bonus; ?>  </td>
	    </tr>
	<tr>
	    <td><span style="font-weight: bold">Benifits</span></td>
		    <td>
            <?php echo $x_benifits; ?>            </td>
	    </tr>
	<tr>
	    <td><span style="font-weight: bold">Location</span></td>
		    <td>
    <?php echo $x_location; ?>
	 </td>
	    </tr>
	<tr>
        <td><span style="font-weight: bold">Date Posted</span></td>
	    <td><?php echo FormatDateTime($x_dt_created,5); ?> </td>
	    </tr>
	<tr>
	    <td><span style="font-weight: bold">Recruiter / Company</span></td>
		    <td>
            <?php echo $x_company; ?>            </td>
	    </tr>
	<tr>
	    <td><span style="font-weight: bold">Job Profile</span></td>
		    <td>
            <?php echo str_replace(chr(10), "<br>", $x_profile); ?>            </td>
	    </tr>
		<tr>
	    <td><span style="font-weight: bold">Contact detail</span></td>
		    <td>
            <?php echo $x_contact_email; ?>            </td>
	    </tr>
        <?php if (isSuperUser(false)){ ?> 
			<tr>
	    		<td><span style="font-weight: bold">Expiry Date</span></td>
                <td>
                    <?php echo FormatDateTime($x_dt_expire,5); ?>            
                </td>
	    	</tr>
			<tr>
	    		<td><span style="font-weight: bold">Job Status</span></td>
		    	<td>
            		<?php echo $x_job_status; ?>
                </td>
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
