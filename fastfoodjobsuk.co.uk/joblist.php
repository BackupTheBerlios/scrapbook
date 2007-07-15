<?php 
require("common_all.php");
ob_start();
?>
<?php include ("jobinfo.php") ?>
<?php include ("phpfn.php") ?>

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
<p>Job List</p>
<form id="fjoblistsrch" name="fjoblistsrch" action="joblist.php"  onsubmit="return EW_checkMyForm2(this);" >
<input type="hidden" name="a_search" value="E">
<table>
	<tr>
	    <td>position</td>
		    <td>&nbsp;=		        <input type="hidden" name="z_position" value="=,,"></td>
		    <td>
		        <table border="0" cellspacing="0" cellpadding="0"><tr>
		            <td> <select id='x_position' name='x_position'>
            <option value="all">All</option>
                  <?php
        if (isset($x_position)){
          $f=fopen("position_list.htm","r");
          while (!feof($f)){
            $d=fgets($f);
            $start=strpos($d,"\"")+1;
            $end=strrpos($d,"\"");
            $val=substr($d,$start,$end-$start);
            if ($val==$x_position){
              $newD=substr($d,0,$end+1);
              $newD.=" SELECTED";
              $newD.=substr($d,$end+1);
              $d=$newD;
            }
            echo $d;
          }
          fclose($f);
        } else {
          require("position_list.htm");
        }
      ?></select></td>
			    </tr></table>		    </td>
	    </tr>
	<tr>
	    <td>salary</td>
		    <td>&nbsp;between		        <input type="hidden" name="z_salary" value="BETWEEN,,"></td>
		    <td>
		        <table border="0" cellspacing="0" cellpadding="0"><tr>
		            <td>                        <input type="text" name="x_salary" id="x_salary" size="30" value="<?php echo htmlspecialchars(@$x_salary) ?>">    </td>
				    <td>and
				        <input type="hidden" name="w_salary" value="AND,,"></td>
				    <td>                        <input type="text" name="y_salary" id="y_salary" size="30" value="<?php echo htmlspecialchars(@$y_salary) ?>">    </td>
			    </tr></table>		    </td>
	    </tr>
	<tr>
	    <td>location</td>
		    <td>&nbsp;=		        <input type="hidden" name="z_location" value="=,','"></td>
		    <td>
		        <table border="0" cellspacing="0" cellpadding="0"><tr>
		            <td><select d='x_location' name='x_location'>
            <option value='all'>All</option>
      <?php
        if (isset($x_location)){
          $f=fopen("county_list.htm","r");
          while (!feof($f)){
            $d=fgets($f);
            $start=strpos($d,"\"")+1;
            $end=strrpos($d,"\"");
            $val=substr($d,$start,$end-$start);
            if ($val==$x_location){
              $newD=substr($d,0,$end+1);
              $newD.=" SELECTED";
              $newD.=substr($d,$end+1);
              $d=$newD;
            }
            echo $d;
          }
          fclose($f);
        } else {
          require("county_list.htm");
        }
      ?>
      </select></td>
			    </tr></table>		    </td>
	    </tr>
</table>
<table>
	<tr>
	    <td>
	        <input type="Submit" name="Submit" value="Search">
	        &nbsp;
	        <a href="joblist.php?cmd=reset">Show all</a></td>
	    </tr>
</table>
</form>
<p>
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
		    <select name="<?php echo ewTblRecPerPage; ?>" onchange="this.form.submit();" class="phpmaker">
		        <option value="20"<?php if ($nDisplayRecs == 20) { echo " selected";  }?>>20</option>
		        <option value="50"<?php if ($nDisplayRecs == 50) { echo " selected";  }?>>50</option>
		        <option value="ALL"<?php if (@$_SESSION[ewSessionTblRecPerPage] == -1) { echo " selected";  }?>>All Records</option>
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
        position
                <?php if (@$_SESSION[ewSessionTblSort . "_x_position"] == "ASC") { ?>
                <img src="images/sortup.gif" width="10" height="9" border="0">
                <?php } elseif (@$_SESSION[ewSessionTblSort . "_x_position"] == "DESC") { ?>
                <img src="images/sortdown.gif" width="10" height="9" border="0">        
                <?php } ?>    
                </span></td>
    <td valign="top"><span style="font-weight: bold">
        overview
                <?php if (@$_SESSION[ewSessionTblSort . "_x_overview"] == "ASC") { ?>
                <img src="images/sortup.gif" width="10" height="9" border="0">
                <?php } elseif (@$_SESSION[ewSessionTblSort . "_x_overview"] == "DESC") { ?>
                <img src="images/sortdown.gif" width="10" height="9" border="0">        
                <?php } ?>    
                </span></td>
    <td valign="top"><span style="font-weight: bold">
        salary
                <?php if (@$_SESSION[ewSessionTblSort . "_x_salary"] == "ASC") { ?>
                <img src="images/sortup.gif" width="10" height="9" border="0">
                <?php } elseif (@$_SESSION[ewSessionTblSort . "_x_salary"] == "DESC") { ?>
                <img src="images/sortdown.gif" width="10" height="9" border="0">        
                <?php } ?>    
                </span></td>
    <td valign="top"><span style="font-weight: bold">
        location
                <?php if (@$_SESSION[ewSessionTblSort . "_x_location"] == "ASC") { ?>
                <img src="images/sortup.gif" width="10" height="9" border="0">
                <?php } elseif (@$_SESSION[ewSessionTblSort . "_x_location"] == "DESC") { ?>
                <img src="images/sortdown.gif" width="10" height="9" border="0">        
                <?php } ?>    
                </span></td>
    <td valign="top"><span style="font-weight: bold">
        company
                <?php if (@$_SESSION[ewSessionTblSort . "_x_company"] == "ASC") { ?>
                <img src="images/sortup.gif" width="10" height="9" border="0">
                <?php } elseif (@$_SESSION[ewSessionTblSort . "_x_company"] == "DESC") { ?>
                <img src="images/sortdown.gif" width="10" height="9" border="0">        
                <?php } ?>    
                </span></td>
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
?>
	<!-- Table body -->
	<tr<?php echo $sItemRowClass; ?><?php echo $sListTrJs; ?>>
    <!-- jobid -->
	    <!-- onlineuser_onlineuserid -->
	    <!-- position -->
	    <td>
    <?php
switch ($x_position) {
	case "1":
		$sTmp = "Sales & Marketing";
		break;
	case "2":
		$sTmp = "Head Office";
		break;
	case "3":
		$sTmp = "Training";
		break;
	case "4":
		$sTmp = "Field Support";
		break;
	case "5":
		$sTmp = "Operational / Regional Manager";
		break;
	case "6":
		$sTmp = "Area Manager";
		break;
	case "7":
		$sTmp = "General Manager";
		break;
	case "8":
		$sTmp = "Manager";
		break;
	case "9":
		$sTmp = "Assistant Manager";
		break;
	case "10":
		$sTmp = "Supervisor";
		break;
	case "11":
		$sTmp = "Trainee Manager";
		break;
	case "12":
		$sTmp = "Driver";
		break;
	case "13":
		$sTmp = "Kitchen Manager";
		break;
	case "14":
		$sTmp = "Team Leader";
		break;
	case "15":
		$sTmp = "Chef / Cook";
		break;
	case "16":
		$sTmp = "Kitchen Staff";
		break;
	case "17":
		$sTmp = "Waiting / Counter Operative";
		break;
	default:
		$sTmp = "";
}
$ox_position = $x_position; // Backup original value
$x_position = $sTmp;
?>
    <?php echo $x_position; ?>    <?php $x_position = $ox_position; // Restore original value ?>    </td>
		    <!-- overview -->
	    <td>
                <?php echo str_replace(chr(10), "<br>", $x_overview); ?>    </td>
		    <!-- salary -->
	    <td>
                <?php echo $x_salary; ?>    </td>
		    <!-- bonus -->
	    <!-- benifits -->
	    <!-- location -->
	    <td><?php echo $x_location; ?> 		  </td>
		    <!-- company -->
	    <td>
                <?php echo $x_company; ?>    </td>
		    <td><a href="<?php if ($x_jobid <> "") {echo "jobview.php?jobid=" . urlencode($x_jobid); } else { echo "javascript:alert('Invalid Record! Key is null');";} ?>"><b>View</b></a></td>
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
	if ($GLOBALS["x_position"] <> "" And is_numeric($GLOBALS["x_position"]) And isValidOpr($arrFldOpr)) {
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
