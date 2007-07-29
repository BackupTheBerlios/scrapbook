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
	  $db->Query("update job set job_status = 'active', dt_expire='$newExpiryDate' where onlineuser_onlineuserid=$user->onlineuserId and jobid=$id");
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
	  $object->dt_expire=$newExpiryDate;
	  $object->Save();	  
	} else {
	  // this user is not allowed to access this resource
	  exit;
	}
}

?>
<table width="459" border="0" cellspacing="0" cellpadding="0" >
 <tr>
  <td><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /></td>
 </tr>
 <tr>
  <td><div class="roundcont">
   <div class="roundtop"> <img class="corner" src="images/bl_01.gif" alt="edge" style=" display: none;" /></div>
   <h1>Advertisement Renewal</h1>
   <div class="roundbottom"> <img src="images/bl_06.gif" alt="edge" class="corner" style=" display: none;" /></div>
  </div></td>
 </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top" width="455"><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /> </td>
 </tr>
 <tr>
  <td valign="top" width="455"><p style = "padding-left:5px; margin:0px;">Your advert has been renewed.
</p>
    <p style = "padding-left:5px; margin:0px;" > <a href="account.php" class = "news">Click here</a> to return to your account. </p>
    <br /></td>
 </tr>
 <tr>
  <td></td>
 </tr>
</table>
<br>
<?php
require("bottom.php");
?>

