<?php
require("common_user.php");
//$adminUrl = $user->isSuperAdmin()?"admin_account.php":"account.php";
$adminUr = "account.php";
if ((bool)$_POST["submitting"]){
  
  $db=new DatabaseConnection();
  
  $errorText="";
  $user->first_name=$_POST["firstName"];
  $user->last_name=$_POST["lastName"];
  $user->email=$_POST["email"];
  $user->address_1=$_POST["address1"];
  $user->address_2=$_POST["address2"];
  $user->address_3=$_POST["address3"];
  $user->postcode=$_POST["postcode"];
  $user->tel=$_POST["tel"];
  $user->fax=$_POST["fax"];
  
  if (($result=validate($user->first_name,"name",45))!==true)
    $errorText.="<LI>Your first name is $result";

  if (($result=validate($user->last_name,"name",45))!==true)
    $errorText.="<LI>Your last name is $result";
    
  if (($result=validate($user->email,"email",45))!==true)
    $errorText.="<LI>Your email address is $result";

	if (!isSuperUser(false))
	{
	  if (($result=validate($user->address_1,"",255))!==true)
		$errorText.="<LI>The first line of your address is $result";
	
	  if (($result=validate($user->address_2,"",255))!==true)
		$errorText.="<LI>The second line of your address is $result";
	
	  if (($result=validate($user->postcode,"",20))!==true)
		$errorText.="<LI>Your post code is $result";
	
	  if (($result=validate($user->tel,"phonenumber",45))!==true)
		$errorText.="<LI>Your telephone number is $result";
	
	  if ($user->fax!="" && (($result=validate($user->fax,"phonenumber",45))!==true))
		$errorText.="<LI>Your fax number is $result";
	}

  if ($errorText==""){
    $query=$db->Query("SELECT * FROM onlineuser WHERE email='".$db->Escape($user->email)."' AND onlineuserid!='".$user->onlineuserId."' LIMIT 1");
    if ($db->Rows()>0){
      $errorText.="<LI>The email address you have entered is taken";
    } else {
      $_SESSION["onlineuser"]=$user;
      $user->Save();
      header("Location: $adminUrl");
      exit;
    }
  }
  
  $errorText="<ul>".$errorText."</ul>";
  
}

require("top.php");

?>

<form action="user_profile.php" method="POST">
<input type=hidden name="submitting" value="true">

<table width="459" border="0" cellspacing="0" cellpadding="0" >
 <tr>
  <td><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /></td>
 </tr>
 <tr>
  <td><div class="roundcont">
   <div class="roundtop"> <img class="corner" src="images/bl_01.gif" alt="edge" style=" display: none;" /></div>
   <h1>User Profile</h1>
   <div class="roundbottom"> <img src="images/bl_06.gif" alt="edge" class="corner" style=" display: none;" /></div>
  </div></td>
 </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top" width="455"><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /> </td>
 </tr>
 <tr>
  <td valign="top" width="455"><p style = "padding-left:5px; margin:0px;">Please use the form below to update any profile details.<br />
    <br />
     Thank you.<br />
       <br />
  </p>
   </td>
 </tr>
 <tr>
  <td></td>
 </tr>
</table>
<table class = "uploadform">
  <tr>
    <td colspan=2>
    <?php
      echo $errorText;
    ?>
    </td>
  </tr>
  <tr>
    <td>
      First Name:
    </td>
    <td>
      <input class = "detail" type="text" name="firstName" value="<?php echo $user->first_name; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Last Name:
    </td>
    <td>
      <input class = "detail" type="text" name="lastName" value="<?php echo $user->last_name; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Email Address:
    </td>
    <td>
      <input class = "detail" type="text" name="email" value="<?php echo $user->email; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Address 1:
    </td>
    <td>
      <input class = "detail" type="text" name="address1" value="<?php echo $user->address_1; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Address 2:
    </td>
    <td>
      <input class = "detail" type="text" name="address2" value="<?php echo $user->address_2; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Address 3:
    </td>
    <td>
      <input class = "detail" type="text" name="address3" value="<?php echo $user->address_3; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Post Code:
    </td>
    <td>
      <input class = "detail" type="text" name="postcode" value="<?php echo $user->postcode; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Telephone:
    </td>
    <td>
      <input class = "detail" type="text" name="tel" value="<?php echo $user->tel; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Facsimile:
    </td>
    <td>
      <input class = "detail" type="text" name="fax" value="<?php echo $user->fax; ?>">
    </td>
  </tr>
  <tr>
    <td>
    </td>
    <td>
      <input type="submit" value="Update" />
      &nbsp;&nbsp;&nbsp;
      <input type="button" value="Cancel" onClick="window.location='<?php echo $adminUrl; ?>'" /></td>
  </tr>
  
</table>

</form>

<?php
require("bottom.php");
?>
