<?php
require("common_user.php");

$user=new OnlineUser();
$user=$user->Get($_SESSION["onlineuser"]->onlineuserId);

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
      header("Location: account.php");
      exit;
    }
  }
  
  $errorText="<ul>".$errorText."</ul>";
  
}

require("top.php");

?>

<form action="user_profile.php" method="POST">
<input type=hidden name="submitting" value="true">

<table>
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
      <input type="text" name="firstName" value="<?php echo $user->first_name; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Last Name:
    </td>
    <td>
      <input type="text" name="lastName" value="<?php echo $user->last_name; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Email Address:
    </td>
    <td>
      <input type="text" name="email" value="<?php echo $user->email; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Address 1:
    </td>
    <td>
      <input type="text" name="address1" value="<?php echo $user->address_1; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Address 2:
    </td>
    <td>
      <input type="text" name="address2" value="<?php echo $user->address_2; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Address 3:
    </td>
    <td>
      <input type="text" name="address3" value="<?php echo $user->address_3; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Post Code:
    </td>
    <td>
      <input type="text" name="postcode" value="<?php echo $user->postcode; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Telephone:
    </td>
    <td>
      <input type="text" name="tel" value="<?php echo $user->tel; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Facsimile:
    </td>
    <td>
      <input type="text" name="fax" value="<?php echo $user->fax; ?>">
    </td>
  </tr>
  <tr>
    <td>
    </td>
    <td>
      <input type="button" value="Cancel" onclick="window.location='account.php'">
      &nbsp;&nbsp;&nbsp;
      <input type="submit" value="Update">
    </td>
  </tr>
  
</table>

</form>

<?php
require("bottom.php");
?>
