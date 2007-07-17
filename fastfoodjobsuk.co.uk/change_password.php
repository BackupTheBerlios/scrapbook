<?php
require("common_user.php");

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
      header("Location: account.php");
      exit;
  }
  else
  	$errorText="<ul>".$errorText."</ul>";
}

require("top.php");

?>

<form action="change_password.php" method="POST">
<input type=hidden name="submitting" value="true">
<table>
  <tr>
    <td colspan=2>
    <?php
      echo $errorText;
    ?>    </td>
  </tr>
  <tr>
    <td>New Password:</td>
    <td>
      <input name="new_password" type="password" />    </td>
  </tr>
  <tr>
    <td>Confirm New Password:</td>
    <td>
      <input name="confirm_password" type="password" />    </td>
  </tr>
  <tr>
    <td>    </td>
    <td>
    <input type="submit" value="Change Password">
     
      &nbsp;&nbsp;&nbsp;
       <input type="button" value="Cancel" onclick="window.location='account.php'">          </td>
  </tr>
</table>

</form>
<?php
require("bottom.php");
?>
