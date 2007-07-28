<?php
require("common_user.php");
require("top.php");

$class=stripslashes($_GET["type"]);
$id=(int)$_GET["id"];

if ($class=="Job")
{
	  $db=new DatabaseConnection();
	  $db->Query("update job set job_status = 'disabled' where onlineuser_onlineuserid=$user->onlineuserId and jobid=$id");
}
else
{
	$object=new $class;
	$object=$object->Get($id);
	
	if (isSuperUser(false) || $user->canAccess($object)){
	  
	  $status=$class."_status";
	  $object->$status="disabled";
	  $object->Save();
	  
	} else {
	  // this user is not allowed to access this resource
	  exit;
	}
}

?>
<br>
Your advert has been paused
<p>
  <a href="account.php" class = "news">Click here</a> to return to your account.
</p>
<?php
require("bottom.php");
?>

