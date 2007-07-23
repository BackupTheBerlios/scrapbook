<?php
require("common_user.php");
require("top.php");

$class=stripslashes($_GET["type"]);
$id=(int)$_GET["id"];
$newExpiryDate=expiryDate();
if ($class=="Job")
{
	  $db=new DatabaseConnection();
	  $db->Query("update job set job_status = 'active', dt_expire='$newExpiryDate' where onlineuser_onlineuserid=$user->onlineuserId and jobid=$id");
}
else if ($class=="CV")
{
	  $db=new DatabaseConnection();
	  $db->Query("update cv set cv_status = 'active' dt_expire='$newExpiryDate' where onlineuser_onlineuserid=$user->onlineuserId and cvid=$id");
}
else
{
	
	$object=new $class;
	$object=$object->Get($id);
	
	if (isSuperUser(false) || $user->canAccess($object)){
	  /* no point check this, where if an object is live or not  are determined by status and expiry date
	  $expires=strtotime($object->dt_expire);
	  if (date("U") > $expires){
		// at this point the advert has already expired
		// maybe redirect to a pay now link ?
		exit;
	  }
	  */
	  $status=$class."_status";
	  $object->$status="active";
	  //defaults to 30 days
	  $object->dt_expire=$newExpiryDate;
	  $object->Save();	  
	} else {
	  // this user is not allowed to access this resource
	  exit;
	}
}

?>
<br>
Your advert has been renewed for 30 days
<p>
  <a href="account.php" class = "news">Click here</a> to return to your account.
</p>
<?php
require("bottom.php");
?>

