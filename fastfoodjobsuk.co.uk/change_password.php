<?php
require("common_user.php");
$adminUrl = $user->isSuperAdmin()?"admin_account.php":"account.php";
if ((bool)$_POST["submitting"]){
  $errorText="";
  $new_password=$_POST["new_password"];
  $confirm_password=$_POST["confirm_password"];
  
   if (($result=validate($new_password,"password",45, 6))!==true)
    $errorText.="<LI>Your new password is $result";
	
   else if ($new_password!=$confirm_password)
    $errorText.="<LI>Mismatch password";

  if ($errorText==""){
	  //$user=new OnlineUser();
	  //$user=$user->Get($_SESSION["onlineuser"]->onlineuserId);
	  $user->pass_word=$new_password;
	  $updatePassword=true;  	
      $user->Save($updatePassword);
      $_SESSION["onlineuser"]=$user;	  
      header("Location: $adminUrl");
      exit;
  }
  else
  	$errorText="<ul>".$errorText."</ul>";
}

require("top.php");

?>

<form action="change_password.php" method="POST">
 <table width="459" border="0" cellspacing="0" cellpadding="0" >
  <tr>
   <td><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /></td>
  </tr>
  <tr>
   <td><div class="roundcont">
     <div class="roundtop"> <img class="corner" src="images/bl_01.gif" alt="edge" style=" display: none;" /></div>
    <h1>New Password</h1>
    <div class="roundbottom"> <img src="images/bl_06.gif" alt="edge" class="corner" style=" display: none;" /></div>
   </div></td>
  </tr>
 </table>
 <table border="0" cellspacing="0" cellpadding="0">
  <tr>
   <td valign="top" width="455"><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /> </td>
  </tr>
  <tr>
   <td valign="top" width="455"><p style = "padding-left:5px; margin:0px;">Please use the form below to update your password.<br />
       <br />
    Thank you.<br />
    <br />
   </p></td>
  </tr>
  <tr>
   <td></td>
  </tr>
 </table>
 <input type=hidden name="submitting" value="true">
<table class = "uploadform">
  <tr>
    <td colspan=2>
    <?php
      echo $errorText;
    ?>    </td>
  </tr>
  <tr>
    <td>New Password:</td>
    <td>
      <input class = "detail" name="new_password" type="password" />    </td>
  </tr>
  <tr>
    <td>Confirm New Password:</td>
    <td>
      <input class = "detail" name="confirm_password" type="password" />    </td>
  </tr>
  <tr>
    <td>    </td>
    <td>
    <input type="submit" value="Change Password">
     
      &nbsp;&nbsp;&nbsp;
       <input type="button" value="Cancel" onClick="window.location='<?php echo $adminUrl; ?>'" />          </td>
  </tr>
</table>

</form>
<?php
require("bottom.php");
?>
