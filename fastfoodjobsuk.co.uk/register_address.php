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
  
  if ($address1==""){
    $errorText.="<li>Address 1 is mandatory";
  } else if (strlen($address1)>255){
    $errorText.="<li>Address line 1 is too long";
  }
  
  if(strlen($address2)>255){
    $errorText.="<li>Address line 2 is too long";
  }
  
  if(strlen($address3)>255){
    $errorText.="<li>Address line 3 is too long";
  }
  
  if ($postcode==""){
    $errorText.="<li>Post code is mandatory";
  } else if (strlen($postcode)>20){
    $errorText.="<li>Post code is too long";
  }


  if ($tel==""){
    $errorText.="<li>Telephone number is mandatory";
  } else if (strlen($tel)>45){
    $errorText.="<li>Telephone number is too long";
  } else if (!eregi("^[0-9]+$",$tel)){
    $errorText.="<li>Telephone number can only contain numbers";
  }
  if (strlen($fax)>45){
    $errorText.="<li>Fax number is too long";
  }
  
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
      <Th>
              <span class="redbar">| </span><span class="heading">Registration</span> <span class="redbar">|</span><br>
<br>
      </th>
    </tr>
    <TR>
      <TD colspan=2>
        Before you can proceed, we need a few more details...
      </td>
    </tr>
    <TR>
      <TD colspan=2>
      <?php
        echo $errorText;
      ?>
      </td>
    </tr>
    <TR>
      <TD>
        Address 1:
      </td>
      <TD>
        <input type="text" name="address1" value="<?php echo (isset($_POST["address1"]) ? $_POST["address1"] : ""); ?>">
      </td>
    </tr>
    <TR>
      <TD>
        Address 2:
      </td>
      <TD>
        <input type="text" name="address2" value="<?php echo (isset($_POST["address2"]) ? $_POST["address2"] : ""); ?>">
      </td>
    </tr>
    <TR>
      <TD>
        Address 3:
      </td>
      <TD>
        <input type="text" name="address3" value="<?php echo (isset($_POST["address3"]) ? $_POST["address3"] : ""); ?>">
      </td>
    </tr>
    <TR>
      <TD>
        Post Code:
      </td>
      <TD>
        <input type="text" name="postcode" value="<?php echo (isset($_POST["postcode"]) ? $_POST["postcode"] : ""); ?>">
      </td>
    </tr>
    <TR>
      <TD>
        Telephone:
      </td>
      <TD>
        <input type="text" name="telephone" value="<?php echo (isset($_POST["telephone"]) ? $_POST["telephone"] : ""); ?>">
      </td>
    </tr>
    <TR>
      <TD>
        Fax:
      </td>
      <TD>
        <input type="text" name="fax" value="<?php echo (isset($_POST["fax"]) ? $_POST["fax"] : ""); ?>">
      </td>
    </tr>
    <TR>
      <TD>
      </td>
      <TD>
        <input type="submit" value="Submit">
      </td>
    </tr>
  </table>
</form>
<?php
	require("bottom.php");
?>