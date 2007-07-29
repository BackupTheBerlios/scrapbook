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
<table width="459" border="0" cellspacing="0" cellpadding="0" >
 <tr>
  <td><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /></td>
 </tr>
 <tr>
  <td><div class="roundcont">
   <div class="roundtop"> <img class="corner" src="images/bl_01.gif" alt="edge" style=" display: none;" /></div>
   <h1>Deactivate Advert</h1>
   <div class="roundbottom"> <img src="images/bl_06.gif" alt="edge" class="corner" style=" display: none;" /></div>
  </div></td>
 </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top" width="455"><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /> </td>
 </tr>
 <tr>
  <td valign="top" width="455"><p style = "padding-left:5px; margin:0px;">Your advert has been paused			<br />
  </p>
   <p style = "padding-left:5px; margin:0px;"> <a href="account.php" class = "news">Click here</a> to return to your account. </p>
    <br />
     
  </td>
 </tr>
 <tr>
  <td></td>
 </tr>
</table>
<?php
require("bottom.php");
?>

