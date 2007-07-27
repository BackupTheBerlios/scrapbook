<?php
	require("common_all.php");

$id=(int)$_GET["id"];
$member=new Platinum_membership();
$member=$member->Get($id);
if ($member->platinum_membershipId==0) //object not exist
{
	header("Location: index.php");
	exit();
}

isUniqueVisit("platinum_membership",$id,"clicks");

?>
<?php
	require("top_wide.php");
?>
<link rel=stylesheet href="css/platinum.css" type="text/css">
  <img src="logos/<?php echo $member->logo; ?>" width="<?php echo $platinumImageWidth; ?>" height="<?php echo $platinumImageHeight; ?>" class="topimageleft">
  <br>
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
