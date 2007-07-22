<?php 
require("common_user.php");
$user->canSearchCV();
ob_start();
?>
<?php include ("cvinfo.php") ?>
<?php
$nStartRec = 0;
$nStopRec = 0;
$nTotalRecs = 0;
$nRecCount = 0;
$nRecActual = 0;
$sKeyMaster = "";
$sDbWhereMaster = "";
$sSrchAdvanced = "";
$psearch = "";
$psearchtype = "";
$sDbWhereDetail = "";
$sSrchBasic = "";
$sSrchWhere = "";
$sDbWhere = "";
$sOrderBy = "";
$sSqlMaster = "";
$sListTrJs = "";
$bEditRow = "";
$nEditRowCnt = "";
$sDeleteConfirmMsg = "";
$nDisplayRecs = "5";
$nRecRange = 10;

// Set up records per page dynamically
SetUpDisplayRecs();

// Multi column
$nRecPerRow = 1;

// Open connection to the database
$conn = phpmkr_db_connect(HOST, USER, PASS, DB, PORT);

// Handle reset command
ResetCmd();

// Get search criteria for Advanced Search
SetUpAdvancedSearch();

// Build search criteria
if ($sSrchAdvanced != "") {
	if ($sSrchWhere <> "") $sSrchWhere .= " AND ";
	$sSrchWhere .= "(" . $sSrchAdvanced . ")"; // Advanced Search
}
if ($sSrchBasic != "") {
	if ($sSrchWhere <> "") $sSrchWhere .= " AND ";
	$sSrchWhere .= "(" . $sSrchBasic . ")"; // Basic Search
}

// Save search criteria
if ($sSrchWhere != "") {
	$_SESSION[ewSessionTblSearchWhere] = $sSrchWhere;

	// Reset start record counter (new search)
	$nStartRec = 1;
	$_SESSION[ewSessionTblStartRec] = $nStartRec;
} else {
	$sSrchWhere = @$_SESSION[ewSessionTblSearchWhere];
	RestoreSearch();
}

// Build filter condition
$sDbWhere = "";
if ($sDbWhereDetail <> "") {
	if ($sDbWhere <> "") $sDbWhere .= " AND ";
	$sDbWhere .= "(" . $sDbWhereDetail . ")";
}
if ($sSrchWhere <> "") {
	if ($sDbWhere <> "") $sDbWhere .= " AND ";
	$sDbWhere .= "(" . $sSrchWhere . ")";
}

// Set up sorting order
$sOrderBy = "";
SetUpSortOrder();
$sSql = ewBuildSql(ewSqlSelect, ewSqlWhere, ewSqlGroupBy, ewSqlHaving, ewSqlOrderBy, $sDbWhere, $sOrderBy);

// echo $sSql . "<br>"; // Uncomment to show SQL for debugging
?>
<?php include ("top.php") ?>
<script type="text/javascript" src="scripts/ewp.js"></script>
<script type="text/javascript">
<!--
EW_dateSep = "/"; // set date separator
//-->
</script>
<?php

// Set up recordset
$rs = phpmkr_query($sSql, $conn) or die("Failed to execute query at line " . __LINE__ . ": " . phpmkr_error($conn) . '<br>SQL: ' . $sSql);
$nTotalRecs = phpmkr_num_rows($rs);
if ($nDisplayRecs <= 0) { // Display all records
	$nDisplayRecs = $nTotalRecs;
}
$nStartRec = 1;
SetUpStartRec(); // Set up start record position
?>
 <h2 style = "margin-left:5px;">CV Search Result</h2>
<form id="fcvlistsrch" name="fcvlistsrch" action="cvlist.php" >
<table class="ewBasicSearch">
	<tr>
		<td><span>
			<a href="cv_search.php">Back to Search</a>
		</span></td>
	</tr>
</table>
</form>
<p>
<?php
if (@$_SESSION[ewSessionMessage] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[ewSessionMessage]; ?></span></p>
<?php
	$_SESSION[ewSessionMessage] = ""; // Clear message
}
?>
<form action="cvlist.php" name="ewpagerform" id="ewpagerform">
<table>
	<tr>
		<td nowrap>
		<span>
<?php

// Display page numbers
if ($nTotalRecs > 0) {
	$rsEof = ($nTotalRecs < ($nStartRec + $nDisplayRecs));
	if ($nTotalRecs > $nDisplayRecs) {

		// Find out if there should be Prev/Next links
		if ($nStartRec == 1) {
			$isPrev = False;
		} else {
			$isPrev = True;
			$PrevStart = $nStartRec - $nDisplayRecs;
			if ($PrevStart < 1) { $PrevStart = 1; } ?>
		<a href="cvlist.php?start=<?php echo $PrevStart; ?>"><b>Prev</b></a>
		<?php
		}
		if ($isPrev || (!$rsEof)) {
			$x = 1;
			$y = 1;
			$dx1 = intval(($nStartRec-1)/($nDisplayRecs*$nRecRange))*$nDisplayRecs*$nRecRange+1;
			$dy1 = intval(($nStartRec-1)/($nDisplayRecs*$nRecRange))*$nRecRange+1;
			if (($dx1+$nDisplayRecs*$nRecRange-1) > $nTotalRecs) {
				$dx2 = intval($nTotalRecs/$nDisplayRecs)*$nDisplayRecs+1;
				$dy2 = intval($nTotalRecs/$nDisplayRecs)+1;
			} else {
				$dx2 = $dx1+$nDisplayRecs*$nRecRange-1;
				$dy2 = $dy1+$nRecRange-1;
			}
			while ($x <= $nTotalRecs) {
				if (($x >= $dx1) && ($x <= $dx2)) {
					if ($nStartRec == $x) { ?>
		<b><?php echo $y; ?></b>
					<?php } else { ?>
		<a href="cvlist.php?start=<?php echo $x; ?>"><b><?php echo $y; ?></b></a>
					<?php }
					$x += $nDisplayRecs;
					$y += 1;
				} elseif (($x >= ($dx1-$nDisplayRecs*$nRecRange)) && ($x <= ($dx2+$nDisplayRecs*$nRecRange))) {
					if ($x+$nRecRange*$nDisplayRecs < $nTotalRecs) { ?>
		<a href="cvlist.php?start=<?php echo $x; ?>"><b><?php echo $y; ?>-<?php echo ($y+$nRecRange-1);?></b></a>
					<?php } else {
						$ny=intval(($nTotalRecs-1)/$nDisplayRecs)+1;
							if ($ny == $y) { ?>
		<a href="cvlist.php?start=<?php echo $x; ?>"><b><?php echo $y; ?></b></a>
							<?php } else { ?>
		<a href="cvlist.php?start=<?php echo $x; ?>"><b><?php echo $y; ?>-<?php echo $ny; ?></b></a>
							<?php }
					}
					$x += $nRecRange*$nDisplayRecs;
					$y += $nRecRange;
				} else {
					$x += $nRecRange*$nDisplayRecs;
					$y += $nRecRange;
				}
			}
		}

		// Next link
		if (!$rsEof) {
			$NextStart = $nStartRec + $nDisplayRecs;
			$isMore = True;  ?>
		<a href="cvlist.php?start=<?php echo $NextStart; ?>"><b>Next</b></a>
		<?php } else {
			$isMore = False;
		} ?>
		<br>
<?php	}
	if ($nStartRec > $nTotalRecs) { $nStartRec = $nTotalRecs; }
	$nStopRec = $nStartRec + $nDisplayRecs - 1;
	$nRecCount = $nTotalRecs - 1;
	if ($rsEof) { $nRecCount = $nTotalRecs; }
	if ($nStopRec > $nRecCount) { $nStopRec = $nRecCount; } ?>
	Records <?php echo  $nStartRec;  ?> to <?php  echo $nStopRec; ?> of <?php echo  $nTotalRecs; ?>
<?php } else { ?>
	<?php if ($sSrchWhere == "0=101") {?>
	<?php } else { ?>
	No records found
	<?php } ?>
<?php }?>
		</span>
		</td>
<?php if ($nTotalRecs > 0) { ?>
		<td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" valign="top" nowrap><span>Records Per Page&nbsp;
		<select name="<?php echo ewTblRecPerPage; ?>" onchange="this.form.submit();" >
		        <option value="5"<?php if ($nDisplayRecs == 5) { echo " selected";  }?>>5</option>					
		        <option value="10"<?php if ($nDisplayRecs == 10) { echo " selected";  }?>>10</option>
		        <option value="20"<?php if ($nDisplayRecs == 20) { echo " selected";  }?>>20</option>
		</select>
		</span></td>
<?php } ?>
	</tr>
</table>
</form>
<?php if ($nTotalRecs > 0)  { ?>
<form method="post">
<table border="0" cellspacing="5" cellpadding="5">
<?php

// Set the last record to display
$nStopRec = $nStartRec + $nDisplayRecs - 1;

// Move to the first record
$nRecCount = $nStartRec - 1;
if (phpmkr_num_rows($rs) > 0) {
	phpmkr_data_seek($rs, $nStartRec -1);
}
$nRecActual = 0;
while (($row = @phpmkr_fetch_array($rs)) && ($nRecCount < $nStopRec)) {
	$nRecCount = $nRecCount + 1;
	if ($nRecCount >= $nStartRec) {
		$nRecActual++;

		// Set row color
		$sItemRowClass = " class=\"row_odd\"";
		$sListTrJs = "";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1) {
			$sItemRowClass = " class=\"row_even\"";
		}
		$x_cvid = $row["cvid"];
		$x_onlineuser_onlineuserid = $row["onlineuser_onlineuserid"];
		$x_picture = $row["picture"];
		$x_first_name = $row["first_name"];
		$x_mid_name = $row["mid_name"];
		$x_last_name = $row["last_name"];
		$x_age = $row["age"];
		$x_sex = $row["sex"];
		$x_nationality = $row["nationality"];
		$x_is_legal = $row["is_legal"];
		$x_years_of_residence = $row["years_of_residence"];
		$x_address_1 = $row["address_1"];
		$x_address_2 = $row["address_2"];
		$x_address_3 = $row["address_3"];
		$x_postcode = $row["postcode"];
		$x_email = $row["email"];
		$x_mobile = $row["mobile"];
		$x_tel = $row["tel"];
		$x_employer = $row["employer"];
		$x_uk_license = $row["uk_license"];
		$x_european_license = $row["european_license"];
		$x_license_points = $row["license_points"];
		$x_marital_status = $row["marital_status"];
		$x_has_dependent = $row["has_dependent"];
		$x_can_relocate = $row["can_relocate"];
		$x_can_travel = $row["can_travel"];
		$x_employement_status = $row["employement_status"];
		$x_work_location = $row["work_location"];
		$x_position_held = $row["position_held"];
		$x_salary = $row["salary"];
		$x_bonus = $row["bonus"];
		$x_ambitions = $row["ambitions"];
		$x_salary_expectation_start = $row["salary_expectation_start"];
		$x_salary_expectation_one = $row["salary_expectation_one"];
		$x_salary_expectation_two = $row["salary_expectation_two"];
		$x_achievement_sales = $row["achievement_sales"];
		$x_achievement_food = $row["achievement_food"];
		$x_achievement_labour = $row["achievement_labour"];
		$x_interests = $row["interests"];
		$x_qualifications = $row["qualifications"];
		$x_tell_us = $row["tell_us"];
		$x_notice = $row["notice"];
		$x_dt_created = $row["dt_created"];
		$x_cv_status = $row["cv_status"];
?>
<?php if ((($nRecActual % $nRecPerRow) == 1) || ($nRecPerRow < 2)) { ?>
	<tr>  
<?php } ?>  
		<td valign="top"<?php echo $sItemRowClass; ?>>
		<table>
			<tr>
				<td><span>
	Full clean UK driving license <?php if (@$_SESSION[ewSessionTblSort . "_x_uk_license"] == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION[ewSessionTblSort . "_x_uk_license"] == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?>
				</span></td>
				<td><span>
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
				<td><span>
	European license held<?php if (@$_SESSION[ewSessionTblSort . "_x_european_license"] == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION[ewSessionTblSort . "_x_european_license"] == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?>
				</span></td>
				<td><span>
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
				<td><span>
	Number of points on license<?php if (@$_SESSION[ewSessionTblSort . "_x_license_points"] == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION[ewSessionTblSort . "_x_license_points"] == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?>
				</span></td>
				<td><span>
<?php echo $x_license_points; ?>
</span></td>
			</tr>
			<tr>
				<td><span>
	Marital Status<?php if (@$_SESSION[ewSessionTblSort . "_x_marital_status"] == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION[ewSessionTblSort . "_x_marital_status"] == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?>
				</span></td>
				<td><span>
<?php echo $x_marital_status; ?>
</span></td>
			</tr>
			<tr>
				<td><span>
	Any dependents<?php if (@$_SESSION[ewSessionTblSort . "_x_has_dependent"] == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION[ewSessionTblSort . "_x_has_dependent"] == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?>
				</span></td>
				<td><span>
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
				<td><span>
	Willing to relocate<?php if (@$_SESSION[ewSessionTblSort . "_x_can_relocate"] == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION[ewSessionTblSort . "_x_can_relocate"] == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?>
				</span></td>
				<td><span>
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
				<td><span>
	Willing to travel<?php if (@$_SESSION[ewSessionTblSort . "_x_can_travel"] == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION[ewSessionTblSort . "_x_can_travel"] == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?>
				</span></td>
				<td><span>
<?php echo $x_can_travel; ?>
</span></td>
			</tr>
			<tr>
				<td><span>
	Current Employment Status<?php if (@$_SESSION[ewSessionTblSort . "_x_employement_status"] == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION[ewSessionTblSort . "_x_employement_status"] == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?>
				</span></td>
				<td><span>
<?php echo $x_employement_status; ?>
</span></td>
			</tr>
			<tr>
				<td><span>
	Current work location<?php if (@$_SESSION[ewSessionTblSort . "_x_work_location"] == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION[ewSessionTblSort . "_x_work_location"] == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?>
				</span></td>
				<td><span>
<?php echo $x_work_location; ?>
</span></td>
			</tr>
			<tr>
				<td><span>
	Current / Last position held<?php if (@$_SESSION[ewSessionTblSort . "_x_position_held"] == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION[ewSessionTblSort . "_x_position_held"] == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?>
				</span></td>
				<td><span>
<?php echo $x_position_held; ?>
</span></td>
			</tr>
			<tr>
				<td><span>
	Current / last salary<?php if (@$_SESSION[ewSessionTblSort . "_x_salary"] == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION[ewSessionTblSort . "_x_salary"] == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?>
				</span></td>
				<td><span>
<?php echo $x_salary; ?>
</span></td>
			</tr>
			<tr>
				<td><span>
	Current / last annual bonus paid <?php if (@$_SESSION[ewSessionTblSort . "_x_bonus"] == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION[ewSessionTblSort . "_x_bonus"] == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?>
				</span></td>
				<td><span>
<?php echo $x_bonus; ?>
</span></td>
			</tr>
			<tr>
				<td>Salary Expectations</td>
				<td></td>
			</tr>					
			<tr>
				<td><span>
	&#8226;Start<?php if (@$_SESSION[ewSessionTblSort . "_x_salary_expectation_start"] == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION[ewSessionTblSort . "_x_salary_expectation_start"] == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?>
				</span></td>
				<td><span>
<?php echo $x_salary_expectation_start; ?>
</span></td>
			</tr>
			<tr>
				<td><span>
	<span>&#8226;</span>Within a year<?php if (@$_SESSION[ewSessionTblSort . "_x_salary_expectation_one"] == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION[ewSessionTblSort . "_x_salary_expectation_one"] == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?>
				</span></td>
				<td><span>
<?php echo $x_salary_expectation_one; ?>
</span></td>
			</tr>
			<tr>
				<td><span>
	<span>&#8226;</span>Within 2-3 years<?php if (@$_SESSION[ewSessionTblSort . "_x_salary_expectation_two"] == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION[ewSessionTblSort . "_x_salary_expectation_two"] == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?>
				</span></td>
				<td><span>
<?php echo $x_salary_expectation_two; ?>
</span></td>
			</tr>
			<tr>
				<td>Achievement</td>
				<td></td>
			</tr>			
			<tr>
				<td><span>
					<span>&#8226;</span>Sales<?php if (@$_SESSION[ewSessionTblSort . "_x_achievement_sales"] == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION[ewSessionTblSort . "_x_achievement_sales"] == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?>
				</span></td>
				<td><span>
<?php echo $x_achievement_sales; ?>
</span></td>
			</tr>
			<tr>
				<td><span>
	<span>&#8226;</span>Food Cost<?php if (@$_SESSION[ewSessionTblSort . "_x_achievement_food"] == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION[ewSessionTblSort . "_x_achievement_food"] == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?>
				</span></td>
				<td><span>
<?php echo $x_achievement_food; ?>
</span></td>
			</tr>
			<tr>
				<td><span>
	<span>&#8226;</span>Labour Cost<?php if (@$_SESSION[ewSessionTblSort . "_x_achievement_labour"] == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION[ewSessionTblSort . "_x_achievement_labour"] == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?>
				</span></td>
				<td><span>
<?php echo $x_achievement_labour; ?>
</span></td>
			</tr>
			<tr>
				<td><span>
	Tell us about yourself: max 50 words<?php if (@$_SESSION[ewSessionTblSort . "_x_tell_us"] == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION[ewSessionTblSort . "_x_tell_us"] == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?>
				</span></td>
				<td><span>
<?php echo str_replace(chr(10), "<br>", $x_tell_us); ?>
</span></td>
			</tr>
			<tr>
				<td><span>
	Notice required in current position<?php if (@$_SESSION[ewSessionTblSort . "_x_notice"] == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif (@$_SESSION[ewSessionTblSort . "_x_notice"] == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?>
				</span></td>
				<td><span>
<?php echo $x_notice; ?>
</span></td>
			</tr>
		</table>
<span>
	<b><a href="<?php if ($x_cvid <> "") {echo "cv_contact.php?cvid=" . urlencode($x_cvid); } else { echo "javascript:alert('Invalid Record! Key is null');";} ?>">Send an email to this job seeker</a></b>
</span>
		</td>
<?php if ((($nRecActual % $nRecPerRow) == 0) || ($nRecPerRow < 2)) { ?>  
	</tr>
<?php } ?>
<?php
	}
}
?>
<?php if (($nRecActual % $nRecPerRow) <> 0) {
	for ($i = 1; $i < ($nRecPerRow - $nRecActual % $nRecPerRow) ;  $i++) {  ?>
	<td>&nbsp;</td>
	<?php } ?>
	</tr>
<?php } ?>
</table>
</form>
<?php 
}

// Close recordset and connection
phpmkr_free_result($rs);
phpmkr_db_close($conn);
?>
<?php include ("bottom.php") ?>
<?php

//-------------------------------------------------------------------------------
// Function SetUpDisplayRecs
// - Set up Number of Records displayed per page based on Form element RecPerPage
// - Variables setup: nDisplayRecs

function SetUpDisplayRecs()
{
	global $nStartRec;
	global $nDisplayRecs;
	global $nTotalRecs;
	$sWrk = @$_GET[ewTblRecPerPage];
	if ($sWrk <> "") {
		if (is_numeric($sWrk)) {
			$nDisplayRecs = $sWrk;
		} else {
			if (strtolower($sWrk) == "all") { // Display all records
				$nDisplayRecs = -1;
			} else {
				$nDisplayRecs = 20;  // Non-numeric, load default
			}
		}
		$_SESSION[ewSessionTblRecPerPage] = $nDisplayRecs; // Save to Session

		// Reset Start Position (Reset Command)
		$nStartRec = 1;
		$_SESSION[ewSessionTblStartRec] = $nStartRec;
	} else {
		if (@$_SESSION[ewSessionTblRecPerPage] <> "") {
			$nDisplayRecs = $_SESSION[ewSessionTblRecPerPage]; // Restore from Session
		} else {
			$nDisplayRecs = 20; // Load Default
		}
	}
}

//-------------------------------------------------------------------------------
// Function SetUpAdvancedSearch
// - Set up Advanced Search parameter based on querystring parameters from Advanced Search Page
// - Variables setup: sSrchAdvanced

function SetUpAdvancedSearch()
{
	global $sSrchAdvanced;

	// Field uk_license
	$sSrchStr = "";
		$GLOBALS["x_uk_license"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["x_uk_license"]) : @$_GET["x_uk_license"];
	$GLOBALS["z_uk_license"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["z_uk_license"]) : @$_GET["z_uk_license"];
	$arrFldOpr = split(",", $GLOBALS["z_uk_license"]);
	if ($GLOBALS["x_uk_license"] <> "" And is_numeric($GLOBALS["x_uk_license"]) And isValidOpr($arrFldOpr)) {
		$sSrchStr .= "`uk_license` " . $arrFldOpr[0] . " " . @$arrFldOpr[1] . AdjustSql($GLOBALS["x_uk_license"]) . @$arrFldOpr[2] . " ";
	}
	if ($sSrchStr <> "") {
		if ($sSrchAdvanced <> "") $sSrchAdvanced .= " AND ";
		$sSrchAdvanced .= "(" . $sSrchStr . ")";
	}

	// Field european_license
	$sSrchStr = "";
		$GLOBALS["x_european_license"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["x_european_license"]) : @$_GET["x_european_license"];
	$GLOBALS["z_european_license"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["z_european_license"]) : @$_GET["z_european_license"];
	$arrFldOpr = split(",", $GLOBALS["z_european_license"]);
	if ($GLOBALS["x_european_license"] <> "" And is_numeric($GLOBALS["x_european_license"]) And isValidOpr($arrFldOpr)) {
		$sSrchStr .= "`european_license` " . $arrFldOpr[0] . " " . @$arrFldOpr[1] . AdjustSql($GLOBALS["x_european_license"]) . @$arrFldOpr[2] . " ";
	}
	if ($sSrchStr <> "") {
		if ($sSrchAdvanced <> "") $sSrchAdvanced .= " AND ";
		$sSrchAdvanced .= "(" . $sSrchStr . ")";
	}

	// Field marital_status
	$sSrchStr = "";
		$GLOBALS["x_marital_status"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["x_marital_status"]) : @$_GET["x_marital_status"];
	$GLOBALS["z_marital_status"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["z_marital_status"]) : @$_GET["z_marital_status"];
	$arrFldOpr = split(",", $GLOBALS["z_marital_status"]);
	if ($GLOBALS["x_marital_status"] <> "" And isValidOpr($arrFldOpr)) {
		$sSrchStr .= "`marital_status` " . $arrFldOpr[0] . " " . @$arrFldOpr[1] . AdjustSql($GLOBALS["x_marital_status"]) . @$arrFldOpr[2] . " ";
	}
	if ($sSrchStr <> "") {
		if ($sSrchAdvanced <> "") $sSrchAdvanced .= " AND ";
		$sSrchAdvanced .= "(" . $sSrchStr . ")";
	}

	// Field has_dependent
	$sSrchStr = "";
		$GLOBALS["x_has_dependent"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["x_has_dependent"]) : @$_GET["x_has_dependent"];
	$GLOBALS["z_has_dependent"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["z_has_dependent"]) : @$_GET["z_has_dependent"];
	$arrFldOpr = split(",", $GLOBALS["z_has_dependent"]);
	if ($GLOBALS["x_has_dependent"] <> "" And is_numeric($GLOBALS["x_has_dependent"]) And isValidOpr($arrFldOpr)) {
		$sSrchStr .= "`has_dependent` " . $arrFldOpr[0] . " " . @$arrFldOpr[1] . AdjustSql($GLOBALS["x_has_dependent"]) . @$arrFldOpr[2] . " ";
	}
	if ($sSrchStr <> "") {
		if ($sSrchAdvanced <> "") $sSrchAdvanced .= " AND ";
		$sSrchAdvanced .= "(" . $sSrchStr . ")";
	}

	// Field can_relocate
	$sSrchStr = "";
		$GLOBALS["x_can_relocate"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["x_can_relocate"]) : @$_GET["x_can_relocate"];
	$GLOBALS["z_can_relocate"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["z_can_relocate"]) : @$_GET["z_can_relocate"];
	$arrFldOpr = split(",", $GLOBALS["z_can_relocate"]);
	if ($GLOBALS["x_can_relocate"] <> "" And is_numeric($GLOBALS["x_can_relocate"]) And isValidOpr($arrFldOpr)) {
		$sSrchStr .= "`can_relocate` " . $arrFldOpr[0] . " " . @$arrFldOpr[1] . AdjustSql($GLOBALS["x_can_relocate"]) . @$arrFldOpr[2] . " ";
	}
	if ($sSrchStr <> "") {
		if ($sSrchAdvanced <> "") $sSrchAdvanced .= " AND ";
		$sSrchAdvanced .= "(" . $sSrchStr . ")";
	}

	// Field can_travel
	$sSrchStr = "";
		$GLOBALS["x_can_travel"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["x_can_travel"]) : @$_GET["x_can_travel"];
	$GLOBALS["z_can_travel"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["z_can_travel"]) : @$_GET["z_can_travel"];
	$arrFldOpr = split(",", $GLOBALS["z_can_travel"]);
	if ($GLOBALS["x_can_travel"] <> "" And is_numeric($GLOBALS["x_can_travel"]) And isValidOpr($arrFldOpr)) {
		$sSrchStr .= "`can_travel` " . $arrFldOpr[0] . " " . @$arrFldOpr[1] . AdjustSql($GLOBALS["x_can_travel"]) . @$arrFldOpr[2] . " ";
	}
	if ($sSrchStr <> "") {
		if ($sSrchAdvanced <> "") $sSrchAdvanced .= " AND ";
		$sSrchAdvanced .= "(" . $sSrchStr . ")";
	}

	// Field employement_status
	$sSrchStr = "";
		$GLOBALS["x_employement_status"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["x_employement_status"]) : @$_GET["x_employement_status"];
	$GLOBALS["z_employement_status"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["z_employement_status"]) : @$_GET["z_employement_status"];
	$arrFldOpr = split(",", $GLOBALS["z_employement_status"]);
	if ($GLOBALS["x_employement_status"] <> "" And isValidOpr($arrFldOpr)) {
		$sSrchStr .= "`employement_status` " . $arrFldOpr[0] . " " . @$arrFldOpr[1] . AdjustSql($GLOBALS["x_employement_status"]) . @$arrFldOpr[2] . " ";
	}
	if ($sSrchStr <> "") {
		if ($sSrchAdvanced <> "") $sSrchAdvanced .= " AND ";
		$sSrchAdvanced .= "(" . $sSrchStr . ")";
	}

	// Field position_held
	$sSrchStr = "";
		$GLOBALS["x_position_held"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["x_position_held"]) : @$_GET["x_position_held"];
	$GLOBALS["z_position_held"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["z_position_held"]) : @$_GET["z_position_held"];
	$arrFldOpr = split(",", $GLOBALS["z_position_held"]);
	if ($GLOBALS["x_position_held"] <> "" And isValidOpr($arrFldOpr)) {
		$sSrchStr .= "`position_held` " . $arrFldOpr[0] . " " . @$arrFldOpr[1] . AdjustSql($GLOBALS["x_position_held"]) . @$arrFldOpr[2] . " ";
	}
	if ($sSrchStr <> "") {
		if ($sSrchAdvanced <> "") $sSrchAdvanced .= " AND ";
		$sSrchAdvanced .= "(" . $sSrchStr . ")";
	}

	// Field salary
	$sSrchStr = "";
		$GLOBALS["x_salary"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["x_salary"]) : @$_GET["x_salary"];
	$GLOBALS["z_salary"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["z_salary"]) : @$_GET["z_salary"];
	$arrFldOpr = split(",", $GLOBALS["z_salary"]);
	if ($GLOBALS["x_salary"] <> "" And isValidOpr($arrFldOpr)) {
		$sSrchStr .= "`salary` " . $arrFldOpr[0] . " " . @$arrFldOpr[1] . AdjustSql($GLOBALS["x_salary"]) . @$arrFldOpr[2] . " ";
	}
	if ($sSrchStr <> "") {
		if ($sSrchAdvanced <> "") $sSrchAdvanced .= " AND ";
		$sSrchAdvanced .= "(" . $sSrchStr . ")";
	}

	// Field salary_expectation_start
	$sSrchStr = "";
		$GLOBALS["x_salary_expectation_start"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["x_salary_expectation_start"]) : @$_GET["x_salary_expectation_start"];
	$GLOBALS["z_salary_expectation_start"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["z_salary_expectation_start"]) : @$_GET["z_salary_expectation_start"];
	$arrFldOpr = split(",", $GLOBALS["z_salary_expectation_start"]);
	if ($GLOBALS["x_salary_expectation_start"] <> "" And isValidOpr($arrFldOpr)) {
		$sSrchStr .= "`salary_expectation_start` " . $arrFldOpr[0] . " " . @$arrFldOpr[1] . AdjustSql($GLOBALS["x_salary_expectation_start"]) . @$arrFldOpr[2] . " ";
	}
	if ($sSrchStr <> "") {
		if ($sSrchAdvanced <> "") $sSrchAdvanced .= " AND ";
		$sSrchAdvanced .= "(" . $sSrchStr . ")";
	}

	// Field salary_expectation_one
	$sSrchStr = "";
		$GLOBALS["x_salary_expectation_one"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["x_salary_expectation_one"]) : @$_GET["x_salary_expectation_one"];
	$GLOBALS["z_salary_expectation_one"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["z_salary_expectation_one"]) : @$_GET["z_salary_expectation_one"];
	$arrFldOpr = split(",", $GLOBALS["z_salary_expectation_one"]);
	if ($GLOBALS["x_salary_expectation_one"] <> "" And isValidOpr($arrFldOpr)) {
		$sSrchStr .= "`salary_expectation_one` " . $arrFldOpr[0] . " " . @$arrFldOpr[1] . AdjustSql($GLOBALS["x_salary_expectation_one"]) . @$arrFldOpr[2] . " ";
	}
	if ($sSrchStr <> "") {
		if ($sSrchAdvanced <> "") $sSrchAdvanced .= " AND ";
		$sSrchAdvanced .= "(" . $sSrchStr . ")";
	}

	// Field salary_expectation_two
	$sSrchStr = "";
		$GLOBALS["x_salary_expectation_two"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["x_salary_expectation_two"]) : @$_GET["x_salary_expectation_two"];
	$GLOBALS["z_salary_expectation_two"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["z_salary_expectation_two"]) : @$_GET["z_salary_expectation_two"];
	$arrFldOpr = split(",", $GLOBALS["z_salary_expectation_two"]);
	if ($GLOBALS["x_salary_expectation_two"] <> "" And isValidOpr($arrFldOpr)) {
		$sSrchStr .= "`salary_expectation_two` " . $arrFldOpr[0] . " " . @$arrFldOpr[1] . AdjustSql($GLOBALS["x_salary_expectation_two"]) . @$arrFldOpr[2] . " ";
	}
	if ($sSrchStr <> "") {
		if ($sSrchAdvanced <> "") $sSrchAdvanced .= " AND ";
		$sSrchAdvanced .= "(" . $sSrchStr . ")";
	}

	// Field achievement_sales
	$sSrchStr = "";
		$GLOBALS["x_achievement_sales"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["x_achievement_sales"]) : @$_GET["x_achievement_sales"];
	$GLOBALS["z_achievement_sales"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["z_achievement_sales"]) : @$_GET["z_achievement_sales"];
	$arrFldOpr = split(",", $GLOBALS["z_achievement_sales"]);
	if ($GLOBALS["x_achievement_sales"] <> "" And isValidOpr($arrFldOpr)) {
		$sSrchStr .= "`achievement_sales` " . $arrFldOpr[0] . " " . @$arrFldOpr[1] . AdjustSql($GLOBALS["x_achievement_sales"]) . @$arrFldOpr[2] . " ";
	}
	if ($sSrchStr <> "") {
		if ($sSrchAdvanced <> "") $sSrchAdvanced .= " AND ";
		$sSrchAdvanced .= "(" . $sSrchStr . ")";
	}

	// Field achievement_food
	$sSrchStr = "";
		$GLOBALS["x_achievement_food"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["x_achievement_food"]) : @$_GET["x_achievement_food"];
	$GLOBALS["z_achievement_food"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["z_achievement_food"]) : @$_GET["z_achievement_food"];
	$arrFldOpr = split(",", $GLOBALS["z_achievement_food"]);
	if ($GLOBALS["x_achievement_food"] <> "" And isValidOpr($arrFldOpr)) {
		$sSrchStr .= "`achievement_food` " . $arrFldOpr[0] . " " . @$arrFldOpr[1] . AdjustSql($GLOBALS["x_achievement_food"]) . @$arrFldOpr[2] . " ";
	}
	if ($sSrchStr <> "") {
		if ($sSrchAdvanced <> "") $sSrchAdvanced .= " AND ";
		$sSrchAdvanced .= "(" . $sSrchStr . ")";
	}

	// Field achievement_labour
	$sSrchStr = "";
		$GLOBALS["x_achievement_labour"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["x_achievement_labour"]) : @$_GET["x_achievement_labour"];
	$GLOBALS["z_achievement_labour"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["z_achievement_labour"]) : @$_GET["z_achievement_labour"];
	$arrFldOpr = split(",", $GLOBALS["z_achievement_labour"]);
	if ($GLOBALS["x_achievement_labour"] <> "" And isValidOpr($arrFldOpr)) {
		$sSrchStr .= "`achievement_labour` " . $arrFldOpr[0] . " " . @$arrFldOpr[1] . AdjustSql($GLOBALS["x_achievement_labour"]) . @$arrFldOpr[2] . " ";
	}
	if ($sSrchStr <> "") {
		if ($sSrchAdvanced <> "") $sSrchAdvanced .= " AND ";
		$sSrchAdvanced .= "(" . $sSrchStr . ")";
	}

	// Field notice
	$sSrchStr = "";
		$GLOBALS["x_notice"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["x_notice"]) : @$_GET["x_notice"];
	$GLOBALS["z_notice"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["z_notice"]) : @$_GET["z_notice"];
	$arrFldOpr = split(",", $GLOBALS["z_notice"]);
	if ($GLOBALS["x_notice"] <> "" And isValidOpr($arrFldOpr)) {
		$sSrchStr .= "`notice` " . $arrFldOpr[0] . " " . @$arrFldOpr[1] . AdjustSql($GLOBALS["x_notice"]) . @$arrFldOpr[2] . " ";
	}
	if ($sSrchStr <> "") {
		if ($sSrchAdvanced <> "") $sSrchAdvanced .= " AND ";
		$sSrchAdvanced .= "(" . $sSrchStr . ")";
	}
	if ($sSrchAdvanced <> "") { // Save settings
		$_SESSION[ewSessionTblAdvSrch . "_x_uk_license"] = $GLOBALS["x_uk_license"];
		$_SESSION[ewSessionTblAdvSrch . "_x_european_license"] = $GLOBALS["x_european_license"];
		$_SESSION[ewSessionTblAdvSrch . "_x_marital_status"] = $GLOBALS["x_marital_status"];
		$_SESSION[ewSessionTblAdvSrch . "_x_has_dependent"] = $GLOBALS["x_has_dependent"];
		$_SESSION[ewSessionTblAdvSrch . "_x_can_relocate"] = $GLOBALS["x_can_relocate"];
		$_SESSION[ewSessionTblAdvSrch . "_x_can_travel"] = $GLOBALS["x_can_travel"];
		$_SESSION[ewSessionTblAdvSrch . "_x_employement_status"] = $GLOBALS["x_employement_status"];
		$_SESSION[ewSessionTblAdvSrch . "_x_position_held"] = $GLOBALS["x_position_held"];
		$_SESSION[ewSessionTblAdvSrch . "_x_salary"] = $GLOBALS["x_salary"];
		$_SESSION[ewSessionTblAdvSrch . "_x_salary_expectation_start"] = $GLOBALS["x_salary_expectation_start"];
		$_SESSION[ewSessionTblAdvSrch . "_x_salary_expectation_one"] = $GLOBALS["x_salary_expectation_one"];
		$_SESSION[ewSessionTblAdvSrch . "_x_salary_expectation_two"] = $GLOBALS["x_salary_expectation_two"];
		$_SESSION[ewSessionTblAdvSrch . "_x_achievement_sales"] = $GLOBALS["x_achievement_sales"];
		$_SESSION[ewSessionTblAdvSrch . "_x_achievement_food"] = $GLOBALS["x_achievement_food"];
		$_SESSION[ewSessionTblAdvSrch . "_x_achievement_labour"] = $GLOBALS["x_achievement_labour"];
		$_SESSION[ewSessionTblAdvSrch . "_x_notice"] = $GLOBALS["x_notice"];
	}
}

//-------------------------------------------------------------------------------
// Function ResetSearch
// - Clear all search parameters

function ResetSearch() 
{

	// Clear search where
	$sSrchWhere = "";
	$_SESSION[ewSessionTblSearchWhere] = $sSrchWhere;

	// Clear advanced search parameters
	$_SESSION[ewSessionTblAdvSrch . "_x_uk_license"] = "";
	$_SESSION[ewSessionTblAdvSrch . "_x_european_license"] = "";
	$_SESSION[ewSessionTblAdvSrch . "_x_marital_status"] = "";
	$_SESSION[ewSessionTblAdvSrch . "_x_has_dependent"] = "";
	$_SESSION[ewSessionTblAdvSrch . "_x_can_relocate"] = "";
	$_SESSION[ewSessionTblAdvSrch . "_x_can_travel"] = "";
	$_SESSION[ewSessionTblAdvSrch . "_x_employement_status"] = "";
	$_SESSION[ewSessionTblAdvSrch . "_x_position_held"] = "";
	$_SESSION[ewSessionTblAdvSrch . "_x_salary"] = "";
	$_SESSION[ewSessionTblAdvSrch . "_x_salary_expectation_start"] = "";
	$_SESSION[ewSessionTblAdvSrch . "_x_salary_expectation_one"] = "";
	$_SESSION[ewSessionTblAdvSrch . "_x_salary_expectation_two"] = "";
	$_SESSION[ewSessionTblAdvSrch . "_x_achievement_sales"] = "";
	$_SESSION[ewSessionTblAdvSrch . "_x_achievement_food"] = "";
	$_SESSION[ewSessionTblAdvSrch . "_x_achievement_labour"] = "";
	$_SESSION[ewSessionTblAdvSrch . "_x_notice"] = "";
	$_SESSION[ewSessionTblBasicSrch] = "";
	$_SESSION[ewSessionTblBasicSrchType] = "";
}

//-------------------------------------------------------------------------------
// Function RestoreSearch
// - Restore all search parameters
//

function RestoreSearch()
{

	// Restore advanced search settings
	$GLOBALS["x_uk_license"] = @$_SESSION[ewSessionTblAdvSrch . "_x_uk_license"];
	$GLOBALS["x_european_license"] = @$_SESSION[ewSessionTblAdvSrch . "_x_european_license"];
	$GLOBALS["x_marital_status"] = @$_SESSION[ewSessionTblAdvSrch . "_x_marital_status"];
	$GLOBALS["x_has_dependent"] = @$_SESSION[ewSessionTblAdvSrch . "_x_has_dependent"];
	$GLOBALS["x_can_relocate"] = @$_SESSION[ewSessionTblAdvSrch . "_x_can_relocate"];
	$GLOBALS["x_can_travel"] = @$_SESSION[ewSessionTblAdvSrch . "_x_can_travel"];
	$GLOBALS["x_employement_status"] = @$_SESSION[ewSessionTblAdvSrch . "_x_employement_status"];
	$GLOBALS["x_position_held"] = @$_SESSION[ewSessionTblAdvSrch . "_x_position_held"];
	$GLOBALS["x_salary"] = @$_SESSION[ewSessionTblAdvSrch . "_x_salary"];
	$GLOBALS["x_salary_expectation_start"] = @$_SESSION[ewSessionTblAdvSrch . "_x_salary_expectation_start"];
	$GLOBALS["x_salary_expectation_one"] = @$_SESSION[ewSessionTblAdvSrch . "_x_salary_expectation_one"];
	$GLOBALS["x_salary_expectation_two"] = @$_SESSION[ewSessionTblAdvSrch . "_x_salary_expectation_two"];
	$GLOBALS["x_achievement_sales"] = @$_SESSION[ewSessionTblAdvSrch . "_x_achievement_sales"];
	$GLOBALS["x_achievement_food"] = @$_SESSION[ewSessionTblAdvSrch . "_x_achievement_food"];
	$GLOBALS["x_achievement_labour"] = @$_SESSION[ewSessionTblAdvSrch . "_x_achievement_labour"];
	$GLOBALS["x_notice"] = @$_SESSION[ewSessionTblAdvSrch . "_x_notice"];
	$GLOBALS["psearch"] = @$_SESSION[ewSessionTblBasicSrch];
	$GLOBALS["psearchtype"] = @$_SESSION[ewSessionTblBasicSrchType];
}

//-------------------------------------------------------------------------------
// Function SetUpSortOrder
// - Set up Sort parameters based on Sort Links clicked
// - Variables setup: sOrderBy, Session(TblOrderBy), Session(Tbl_Field_Sort)

function SetUpSortOrder()
{
	global $sOrderBy;
	global $sDefaultOrderBy;

	// Check for an Order parameter
	if (strlen(@$_GET["order"]) > 0) {
		$sOrder = @$_GET["order"];
	}
	$sOrderBy = @$_SESSION[ewSessionTblOrderBy];
	if ($sOrderBy == "") {
		if (ewSqlOrderBy <> "" && ewSqlOrderBySessions <> "") {
			$sOrderBy = ewSqlOrderBy;
			@$_SESSION[ewSessionTblOrderBy] = $sOrderBy;
			$arOrderBy = explode(",", ewSqlOrderBySessions);
			for($i=0; $i<count($arOrderBy); $i+=2) {
				@$_SESSION[ewSessionTblSort . "_" . $arOrderBy[$i]] = $arOrderBy[$i+1];
			}
		}
	}
}

//-------------------------------------------------------------------------------
// Function SetUpStartRec
//- Set up Starting Record parameters based on Pager Navigation
// - Variables setup: nStartRec

function SetUpStartRec()
{

	// Check for a START parameter
	global $nStartRec;
	global $nDisplayRecs;
	global $nTotalRecs;
	if (strlen(@$_GET[ewTblStartRec]) > 0) {
		$nStartRec = @$_GET[ewTblStartRec];
		$_SESSION[ewSessionTblStartRec] = $nStartRec;
	} elseif (strlen(@$_GET["pageno"]) > 0) {
		$nPageNo = @$_GET["pageno"];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$_SESSION[ewSessionTblStartRec] = $nStartRec;
		} else {
			$nStartRec = @$_SESSION[ewSessionTblStartRec];
		}
	} else {
		$nStartRec = @$_SESSION[ewSessionTblStartRec];
	}

	// Check if correct start record counter
	if (!(is_numeric($nStartRec)) || ($nStartRec == "")) { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$_SESSION[ewSessionTblStartRec] = $nStartRec;
	} elseif ($nStartRec > $nTotalRecs) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$_SESSION[ewSessionTblStartRec] = $nStartRec;
	}
}

//-------------------------------------------------------------------------------
// Function ResetCmd
// - Clear list page parameters
// - RESET: reset search parameters
// - RESETALL: reset search & master/detail parameters
// - RESETSORT: reset sort parameters

function ResetCmd()
{

	// Get Reset command
	if (strlen(@$_GET["cmd"]) > 0) {
		$sCmd = @$_GET["cmd"];
		if (strtolower($sCmd) == "reset") { // Reset search criteria
			ResetSearch();
		} elseif (strtolower($sCmd) == "resetall") { // Reset search criteria and session vars
			ResetSearch();
		} elseif (strtolower($sCmd) == "resetsort") { // Reset sort criteria
			$sOrderBy = "";
			$_SESSION[ewSessionTblOrderBy] = $sOrderBy;
		}

		// Reset start position (Reset command)
		$nStartRec = 1;
		$_SESSION[ewSessionTblStartRec] = $nStartRec;
	}
}
?>
