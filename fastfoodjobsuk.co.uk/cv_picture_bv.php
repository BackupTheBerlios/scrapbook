<?php 
session_start();
ob_start();
?>
<?php include ("ewconfig.php") ?>
<?php include ("db.php") ?>
<?php include ("cvinfo.php") ?>
<?php include ("advsecu.php") ?>
<?php include ("phpmkrfn.php") ?>
<?php

// Get key
$x_cvid = @$_GET["cvid"];
if (!is_numeric($x_cvid)) {
	ob_end_clean();
	header("Location: cvlist.php");
	exit();
}
if (($x_cvid == "") || (is_null($x_cvid))) {
	ob_end_clean();
	header("Location: cvlist.php");
	exit();
}
$x_cvid = (get_magic_quotes_gpc()) ? stripslashes($x_cvid) : $x_cvid;
$conn = phpmkr_db_connect(HOST, USER, PASS, DB, PORT);
$sFilter = ewSqlKeyWhere;
$sFilter = str_replace("@cvid", AdjustSql($x_cvid), $sFilter);
$sSql = ewBuildSql(ewSqlSelect, ewSqlWhere, ewSqlGroupBy, ewSqlHaving, ewSqlOrderBy, $sFilter, "");
$rs = phpmkr_query($sSql,$conn) or die("Failed to execute query at line " . __LINE__ . ": " . phpmkr_error($conn) . '<br>SQL: ' . $sSql);
if (phpmkr_num_rows($rs) > 0) {
	$row = phpmkr_fetch_array($rs);
	if ($row["picture"]<> "") {
		header("Content-Disposition: attachment; filename=" . $row["picture"]);
	}
	ob_clean();
	echo $row["picture"];
}
phpmkr_free_result($rs);
phpmkr_db_close($conn);
?>
