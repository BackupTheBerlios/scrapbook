<?php
	require("common_user.php");

if (!isset($_SESSION["redirect"])) die("sess redir not set");

if (isset($_POST["register"])){
  $db=new DatabaseConnection();
  
  $errorText="";
  $address1=$_POST["address1"];
  $address2=$_POST["address2"];
  $address3=$_POST["address3"];
  $postcode=$_POST["postcode"];
  $tel=$_POST["telephone"];
  $fax=$_POST["fax"];
  

    if (($result=validate($address1,"",255))!==true)
      $errorText.="<LI>The first line of your address is $result";
  
    if (($result=validate($address2,"",255))!==true)
      $errorText.="<LI>The second line of your address is $result";
  
    if (($result=validate($postcode,"",20))!==true)
      $errorText.="<LI>Your post code is $result";
  
    if (($result=validate($telephone,"phonenumber",45))!==true)
      $errorText.="<LI>Your telephone number is $result";
  
    if ($fax!="" && ($result=validate($fax,"phonenumber",45))!==true)
      $errorText.="<LI>Your fax number is $result";
	  
  if ($errorText==""){
    $user=$_SESSION["onlineuser"];
    $user->address_1=$address1;
    $user->address_2=$address2;
    $user->address_3=$address3;
    $user->postcode=$postcode;
    $user->tel=$tel;
    $user->fax=$fax;
    $user->status='active';
    $user->Save();
    $url=$_SESSION["redirect"];
    $_SESSION["onlineuser"]=$user;
    unset($_SESSION["redirect"]);
    header("Location: $url");
    exit;
  }
  
  $errorText="<ul>".$errorText."</ul>";
  
}
?>
<?php
	require("top.php");
?>

<form action="register_address.php" method="POST">
  <input type=hidden name="register" value="1">
  <table class = "registerTable">
    <tr>
      <th>
              <span class="redbar">| </span><span class="heading">Registration</span> <span class="redbar">|</span><br>
<br>
      </th>
    </tr>
    <tr>
      <td colspan=2>
        Before you can proceed, we need a few more details...
      </td>
    </tr>
    <tr>
      <td colspan=2>
      <?php
        echo $errorText;
      ?>
      </td>
    </tr>
    <tr>
      <td>
        Address 1:
      </td>
      <td>
        <input type="text" name="address1" value="<?php echo (isset($_POST["address1"]) ? $_POST["address1"] : ""); ?>">
      </td>
    </tr>
    <tr>
      <td>
        Address 2:
      </td>
      <td>
        <input type="text" name="address2" value="<?php echo (isset($_POST["address2"]) ? $_POST["address2"] : ""); ?>">
      </td>
    </tr>
    <tr>
      <td>
        Address 3:
      </td>
      <td>
        <input type="text" name="address3" value="<?php echo (isset($_POST["address3"]) ? $_POST["address3"] : ""); ?>">
      </td>
    </tr>
    <tr>
      <td>
        Post Code:
      </td>
      <td>
        <input type="text" name="postcode" value="<?php echo (isset($_POST["postcode"]) ? $_POST["postcode"] : ""); ?>">
      </td>
    </tr>
    <tr>
      <td>
        Telephone:
      </td>
      <td>
        <input type="text" name="telephone" value="<?php echo (isset($_POST["telephone"]) ? $_POST["telephone"] : ""); ?>">
      </td>
    </tr>
    <tr>
      <td>
        Fax:
      </td>
      <td>
        <input type="text" name="fax" value="<?php echo (isset($_POST["fax"]) ? $_POST["fax"] : ""); ?>">
      </td>
    </tr>
    <tr>
      <td>
      </td>
      <td>
        <input type="submit" value="Submit">
      </td>
    </tr>
  </table>
</form>
<?php
	require("bottom.php");
?>