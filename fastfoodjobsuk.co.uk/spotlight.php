<?php
	require("common_all.php");

$id=(int)$_GET["id"];
$member=new Spotlight();
$member=$member->Get($id);
if ($member->spotlightId==0){
  // pull latest out of db
  $db=new DatabaseConnection();
  $result=$db->Query("SELECT spotlightid FROM spotlight ORDER BY dt_created DESC LIMIT 1");
  if ($db->Rows()==1){
    $qr=mysql_fetch_row($result);
    $member=$member->Get($qr[0]);
  }
  else
  {
  	header("Location: index.php");
	  exit();
	}
}

?>
<?php
	require("top_wide.php");
?>
<link rel=stylesheet href="css/platinum.css" type="text/css">
  <img src="logos/<?php echo $member->logo; ?>" width="<?php echo $platinumImageWidth; ?>" height="<?php echo $platinumImageHeight; ?>" class="topimageleft">
  <br>
<div id="address">
  <?php echo $member->address; ?>
</div>

<div id="heading">
  <?php echo $member->heading; ?>
</div>

<div id="text">
  <?php echo $member->text; ?>
</div>

<div id="link">
  <a href="<?php echo $member->link; ?>" class = "news">Visit website</a>  
</div>
<?php
	require("bottom_wpv.php");
?>
