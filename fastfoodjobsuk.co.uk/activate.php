<?php
require("common_user.php");
require("top.php");

$class=stripslashes($_GET["type"]);
$id=(int)$_GET["id"];
$newExpiryDate=expiryDate(); 
if ($class=="gold_membership"||$class=="platinum_membership")
{
	$newExpiryDate=expiryYear();
}
if ($class=="Job")
{
	  $db=new DatabaseConnection();
	  //in case the status s temp we need to set a Expirydate
	  $db->Query("update job set dt_expire = '$newExpiryDate' where job_status='temp' and onlineuser_onlineuserid=$user->onlineuserId and jobid=$id");	  
	  $db->Query("update job set job_status = 'active' where onlineuser_onlineuserid=$user->onlineuserId and jobid=$id");

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
	  //in case the status s temp we need to set a Expirydate
	  if ($object->$status=="temp"){
      	$object->dt_expire=$newExpiryDate; 
	  }	  
	  $object->$status="active";
	  $object->Save();

	  
	} else {
	  // this user is not allowed to access this resource
	  exit;
	}
}

?>
<br>
Your advert has been activated
<p>
  <a href="account.php" class = "news">Click here</a> to return to your account.
</p>
<?php
require("bottom.php");
?>

