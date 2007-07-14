<?php
	require("common_all.php");

$errorText="";

if (isset($_GET["code"])){
  
  if (strlen($code)>20){
    $errorText.="<LI>Please enter a valid code";
  }
  if (strlen($email)>45){
    $errorText.="<LI>Please enter a valid email address";
  }

  if ($errorText==""){
    $db=new DatabaseConnection();
  
    $code=$db->Escape($_GET["code"]);
    $email=$db->Escape($_GET["email"]);
    
    $db->Query("SELECT onlineuserid FROM onlineuser WHERE dt_created='$code' AND email='$email'");
    if ($db->Rows()>0){
      
      $user=new OnlineUser();
      $user=$user->Get($db->Result(0,"onlineuserid"));
      $user->user_status="active";
      $user->Save();
      $_SESSION["onlineuser"]=$user;
      header("Location: register_activated.php");
    } else {
      $errorText="<LI>Either the email address or code you entered is incorrect";
    }
    
  } else {
    $errorText="<ul>$errorText</ul>";
  }
  
}

?>
<?php
	require("top.php");
?>

<form action="register_activate.php" method="GET">

<table id="table_register_activate">
  <tr>
    <td colspan=2>
      Please enter your email address and activation code to activate your account
    </td>
  </tr>
  <tr>
    <td colspan=2>
      <?php echo $errorText; ?>
    </td>
  </tr>
  <tr>
    <td>
      Email address:
    </td>
    <td>
      <input name="email" value="<?php echo (isset($_GET["email"])? $_GET["email"]:"" ); ?>">
    </td>
  </tr>
  <tr>
    <td>
      Code:
    </td>
    <td>
      <input name="code" value="<?php echo (isset($_GET["code"])? $_GET["code"]:"" ); ?>">
    </td>
  </tr>
  <tr>
    <td>
    </td>
    <td>
      <input type=submit value="Activate">
    </td>
  </tr>
</table>

</form>
<?php
	require("bottom.php");
?>
