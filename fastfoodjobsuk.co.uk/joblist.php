<?php 
require("common_all.php");
ob_start();
?>
<?php include ("jobinfo.php") ?>
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
$nDisplayRecs = "20";
$nRecRange = 10;

// Set up records per page dynamically
SetUpDisplayRecs();

// Open connection to the database
$conn = phpmkr_db_connect(HOST, USER, PASS, DB, PORT);
//handle reset (get all)
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
//defaul search conditions
if ($sDbWhere <> "")  $sDbWhere .= " AND ";
$sDbWhere .= "(job_status='active')";
$sDbWhere .= " AND ";
$toDay = date("Y-m-d");
$sDbWhere .= "(dt_expire>'$toDay')";

// Set up sorting order
$sOrderBy = "";

$sSql = ewBuildSql(ewSqlSelect, ewSqlWhere, ewSqlGroupBy, ewSqlHaving, ewSqlOrderBy, $sDbWhere, $sOrderBy);

//echo $sSql . "<br>"; // Uncomment to show SQL for debugging
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
function EW_checkMyForm2(EW_this) {
if (EW_this.x_salary && !EW_checkinteger(EW_this.x_salary.value)) {
	if (!EW_onError(EW_this, EW_this.x_salary, "TEXT", "Incorrect integer - salary"))
		return false; 
}
	for (var i=0;i<EW_this.elements.length;i++) {
		var elem = EW_this.elements[i];
		if (elem.name.substring(0,2) == "s_" || elem.name.substring(0,3) == "sv_")
			elem.value = "";
	}
	return true;
}

//-->
</script>
<script type="text/javascript">
<!--
var firstrowoffset = 1; // first data row start at
var tablename = 'ewlistmain'; // table name
var lastrowoffset = 0; // footer row
var usecss = true; // use css
var rowclass = 'ewTableRow'; // row class
var rowaltclass = 'ewTableAltRow'; // row alternate class
var rowmoverclass = 'ewTableHighlightRow'; // row mouse over class
var rowselectedclass = 'ewTableSelectRow'; // row selected class
var roweditclass = 'ewTableEditRow'; // row edit class
var rowcolor = '#FFFFFF'; // row color
var rowaltcolor = '#F5F5F5'; // row alternate color
var rowmovercolor = '#FFCCFF'; // row mouse over color
var rowselectedcolor = '#CCFFFF'; // row selected color
var roweditcolor = '#FFFF99'; // row edit color

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
<p>Job List<br />
    <br />
<a href="job_search.php">Back to Search</a></p>
<?php
if (@$_SESSION[ewSessionMessage] <> "") {
?>
<p><?php echo $_SESSION[ewSessionMessage]; ?></p>
<?php
	$_SESSION[ewSessionMessage] = ""; // Clear message
}
?>
<form action="joblist.php" name="ewpagerform" id="ewpagerform">
<table>
	<tr>
		<td nowrap>
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
		    <a href="joblist.php?start=<?php echo $PrevStart; ?>"><b>Prev</b></a>
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
		            <a href="joblist.php?start=<?php echo $x; ?>"><b><?php echo $y; ?></b></a>
					<?php }
					$x += $nDisplayRecs;
					$y += 1;
				} elseif (($x >= ($dx1-$nDisplayRecs*$nRecRange)) && ($x <= ($dx2+$nDisplayRecs*$nRecRange))) {
					if ($x+$nRecRange*$nDisplayRecs < $nTotalRecs) { ?>
		            <a href="joblist.php?start=<?php echo $x; ?>"><b><?php echo $y; ?>-<?php echo ($y+$nRecRange-1);?></b></a>
					<?php } else {
						$ny=intval(($nTotalRecs-1)/$nDisplayRecs)+1;
							if ($ny == $y) { ?>
		            <a href="joblist.php?start=<?php echo $x; ?>"><b><?php echo $y; ?></b></a>
							<?php } else { ?>
		                    <a href="joblist.php?start=<?php echo $x; ?>"><b><?php echo $y; ?>-<?php echo $ny; ?></b></a>
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
		                    <a href="joblist.php?start=<?php echo $NextStart; ?>"><b>Next</b></a>
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
	Records <?php echo  $nStartRec;  ?> to 
	<?php  echo $nStopRec; ?> 
	of <?php echo  $nTotalRecs; ?>
    <?php } else { ?>
	<?php if ($sSrchWhere == "0=101") {?>
	<?php } else { ?>
	No records found
	<?php } ?>    <?php }?>		</td>
<?php if ($nTotalRecs > 0) { ?>
		<td nowrap>&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" valign="top" nowrap>Records Per Page&nbsp;
		    <select name="<?php echo ewTblRecPerPage; ?>" onchange="this.form.submit();" >
		        <option value="20"<?php if ($nDisplayRecs == 20) { echo " selected";  }?>>20</option>
		        <option value="50"<?php if ($nDisplayRecs == 50) { echo " selected";  }?>>50</option>
		            </select>		</td>
<?php } ?>
	</tr>
</table>
</form>
<?php if ($nTotalRecs > 0)  { ?>
<form method="post">
<table id="ewlistmain">
	<!-- Table header -->
	<tr>
    <td valign="top"><span style="font-weight: bold">
        Position
                <?php if (@$_SESSION[ewSessionTblSort . "_x_position"] == "ASC") { ?>
                <img src="images/sortup.gif" width="10" height="9" border="0">
                <?php } elseif (@$_SESSION[ewSessionTblSort . "_x_position"] == "DESC") { ?>
                <img src="images/sortdown.gif" width="10" height="9" border="0">        
                <?php } ?>    
                </span></td>
    <td valign="top">
        <span style="font-weight: bold">Yearly salary</span><?php if (@$_SESSION[ewSessionTblSort . "_x_salary"] == "ASC") { ?>
                <img src="images/sortup.gif" width="10" height="9" border="0">
                <?php } elseif (@$_SESSION[ewSessionTblSort . "_x_salary"] == "DESC") { ?>
                <img src="images/sortdown.gif" width="10" height="9" border="0">        
                <?php } ?>                </td>
    <td valign="top"><span style="font-weight: bold">
        Location
                <?php if (@$_SESSION[ewSessionTblSort . "_x_location"] == "ASC") { ?>
                <img src="images/sortup.gif" width="10" height="9" border="0">
                <?php } elseif (@$_SESSION[ewSessionTblSort . "_x_location"] == "DESC") { ?>
                <img src="images/sortdown.gif" width="10" height="9" border="0">        
                <?php } ?>    
                </span></td>
                   <td valign="top"><span style="font-weight: bold">Date posted</span></td>        
	    <td valign="top">&nbsp;</td>

	</tr>
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
		$sListTrJs = " onmouseover='ew_mouseover(this);' onmouseout='ew_mouseout(this);' onclick='ew_click(this);'";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1) {
			$sItemRowClass = " class=\"row_even\"";
		}
		$x_jobid = $row["jobid"];
		$x_onlineuser_onlineuserid = $row["onlineuser_onlineuserid"];
		$x_position = $row["position"];
		$x_overview = $row["overview"];
		$x_salary = $row["salary"];
		$x_bonus = $row["bonus"];
		$x_benifits = $row["benifits"];
		$x_location = $row["location"];
		$x_company = $row["company"];
		$x_profile = $row["profile"];
		$x_contact_email = $row["contact_email"];
		$x_dt_created = $row["dt_created"];
		$x_dt_expire = $row["dt_expire"];
		$x_job_status = $row["job_status"];
		$x_link = $row["link"];
?>
	<!-- Table body -->
	<tr<?php echo $sItemRowClass; ?><?php echo $sListTrJs; ?>>
    <!-- jobid -->
	    <!-- onlineuser_onlineuserid -->
	    <!-- position -->
	    <td>

    <?php echo $x_position; ?>  </td>
		    <!-- salary -->
	    <td>
                &pound;<?php echo $x_salary; ?></td>
		    <!-- bonus -->
	    <!-- benifits -->
	    <!-- location -->
	    <td><?php echo $x_location; ?> 		  </td>
                 <td><?php echo $x_dt_created; ?> </td>  
		    <td>
            <?php if ($x_link <> "") {
					$ahref="<a href='$x_link' target='_external'>View Detail</a>";
				  } else {
					 $ahref="<a href='jobview.php?jobid=".urlencode($x_jobid)."'>View Detail</a>"; 
				  }	
			?>
            
            <?php echo $ahref; ?></td>
		    <!-- contact_email -->
	    <!-- dt_created -->
	    <!-- dt_expire -->
	    <!-- job_status -->
	    </tr>
    <?php
	}
}
?>
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

	// Field position
	$sSrchStr = "";
		$GLOBALS["x_position"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["x_position"]) : @$_GET["x_position"];
	$GLOBALS["z_position"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["z_position"]) : @$_GET["z_position"];
	$arrFldOpr = split(",", $GLOBALS["z_position"]);
	if ($GLOBALS["x_position"] <> "" And isValidOpr($arrFldOpr)) {
		$sSrchStr .= "`position` " . $arrFldOpr[0] . " " . @$arrFldOpr[1] . AdjustSql($GLOBALS["x_position"]) . @$arrFldOpr[2] . " ";
	}
	if ($sSrchStr <> "") {
		if ($sSrchAdvanced <> "") $sSrchAdvanced .= " AND ";
		$sSrchAdvanced .= "(" . $sSrchStr . ")";
	}

	// Field salary
	$sSrchStr = "";
		$GLOBALS["x_salary"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["x_salary"]) : @$_GET["x_salary"];
	$GLOBALS["z_salary"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["z_salary"]) : @$_GET["z_salary"];
		$GLOBALS["y_salary"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["y_salary"]) : @$_GET["y_salary"];
	$GLOBALS["w_salary"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["w_salary"]) : @$_GET["w_salary"];
	$arrFldOpr = split(",", $GLOBALS["z_salary"]);
	if ($GLOBALS["x_salary"] <> "" And is_numeric($GLOBALS["x_salary"]) And $GLOBALS["y_salary"] <> "" And is_numeric($GLOBALS["y_salary"]) And isValidOpr($arrFldOpr)) {
		$sSrchStr .= "`salary` BETWEEN " . @$arrFldOpr[1] . AdjustSql($GLOBALS["x_salary"]) . @$arrFldOpr[2] . " AND " . @$arrFldOpr[1] . AdjustSql($GLOBALS["y_salary"]) . @$arrFldOpr[2] ;
	}
	if ($sSrchStr <> "") {
		if ($sSrchAdvanced <> "") $sSrchAdvanced .= " AND ";
		$sSrchAdvanced .= "(" . $sSrchStr . ")";
	}

	// Field location
	$sSrchStr = "";
		$GLOBALS["x_location"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["x_location"]) : @$_GET["x_location"];
	$GLOBALS["z_location"] = (get_magic_quotes_gpc()) ? stripslashes(@$_GET["z_location"]) : @$_GET["z_location"];
	$arrFldOpr = split(",", $GLOBALS["z_location"]);
	if ($GLOBALS["x_location"] <> "" And isValidOpr($arrFldOpr)) {
		$sSrchStr .= "`location` " . $arrFldOpr[0] . " " . @$arrFldOpr[1] . AdjustSql($GLOBALS["x_location"]) . @$arrFldOpr[2] . " ";
	}
	if ($sSrchStr <> "") {
		if ($sSrchAdvanced <> "") $sSrchAdvanced .= " AND ";
		$sSrchAdvanced .= "(" . $sSrchStr . ")";
	}
	if ($sSrchAdvanced <> "") { // Save settings
		$_SESSION[ewSessionTblAdvSrch . "_x_position"] = $GLOBALS["x_position"];
		$_SESSION[ewSessionTblAdvSrch . "_x_salary"] = $GLOBALS["x_salary"];
		$_SESSION[ewSessionTblAdvSrch . "_v_salary"] = $GLOBALS["v_salary"];
		$_SESSION[ewSessionTblAdvSrch . "_y_salary"] = $GLOBALS["y_salary"];
		$_SESSION[ewSessionTblAdvSrch . "_x_location"] = $GLOBALS["x_location"];
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
	$_SESSION[ewSessionTblAdvSrch . "_x_position"] = "";
	$_SESSION[ewSessionTblAdvSrch . "_x_salary"] = "";
	$_SESSION[ewSessionTblAdvSrch . "_y_salary"] = "";
	$_SESSION[ewSessionTblAdvSrch . "_x_location"] = "";
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
	$GLOBALS["x_position"] = @$_SESSION[ewSessionTblAdvSrch . "_x_position"];
	$GLOBALS["x_salary"] = @$_SESSION[ewSessionTblAdvSrch . "_x_salary"];
	$GLOBALS["y_salary"] = @$_SESSION[ewSessionTblAdvSrch . "_y_salary"];
	$GLOBALS["x_location"] = @$_SESSION[ewSessionTblAdvSrch . "_x_location"];
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
