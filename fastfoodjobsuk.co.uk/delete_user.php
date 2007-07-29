<?php
require("common_super.php");
$id=(int)$_GET["id"];

$db=new DatabaseConnection();
$user=new OnlineUser();

if ((bool)$_POST["submitting"]){
  $id=(int)$_POST["id"];
  $user=$user->Get($id);
  $tables=array("cv","franchise","gold_membership","job","platinum_membership","restaurant","supplier");
  foreach ($tables as $tableName){
    $db->Query("DELETE FROM $tableName WHERE onlineuser_onlineuserid='$id'");
  }
  $user->Delete();
  $_SESSION["onlineuser"]=$_SESSION["superuser"];
  header("Location: delete_user_success.php");
  exit;
}

$db->Query("SELECT dt_created FROM cv WHERE onlineuser_onlineuserid='$id'");
$cvCount=$db->Rows();

$db->Query("SELECT dt_created FROM franchise WHERE onlineuser_onlineuserid='$id'");
$franchiseCount=$db->Rows();

$db->Query("SELECT dt_created FROM gold_membership WHERE onlineuser_onlineuserid='$id'");
$goldCount=$db->Rows();

$db->Query("SELECT dt_created FROM job WHERE onlineuser_onlineuserid='$id'");
$jobCount=$db->Rows();

$db->Query("SELECT dt_created FROM platinum_membership WHERE onlineuser_onlineuserid='$id'");
$platinumCount=$db->Rows();

$db->Query("SELECT dt_created FROM restaurant WHERE onlineuser_onlineuserid='$id'");
$restaurantCount=$db->Rows();

$db->Query("SELECT dt_created FROM supplier WHERE onlineuser_onlineuserid='$id'");
$supplierCount=$db->Rows();

require("top.php");

?>



<table width="459" border="0" cellspacing="0" cellpadding="0" >
 <tr>
  <td><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /></td>
 </tr>
 <tr>
  <td><div class="roundcont">
   <div class="roundtop"> <img class="corner" src="images/bl_01.gif" alt="edge" style=" display: none;" /></div>
   <h1>Delete User</h1>
   <div class="roundbottom"> <img src="images/bl_06.gif" alt="edge" class="corner" style=" display: none;" /></div>
  </div></td>
 </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top" width="455"><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /> </td>
 </tr>
 <tr>
  <td valign="top" width="455"><p style = "padding-left:5px; margin:0px;">Delete the user selected below.<br />
      <br />
   Thank you.<br />
   <br />
  </p>
  
  <table class = "uploadform"><tr><td>
  <form action="delete_user.php" method="POST" name="formDelete" style = "margin-left:5px;">
<input type=hidden name="id" value="<?php echo $id; ?>">
<input type=hidden name="submitting" value="true">
Please confirm you wish to delete the following user:
<br>
<?php

  $user=$user->Get($id);
  echo "Name: ".$user->first_name." ".$user->last_name."<BR>";
  echo "Email: ".$user->email."<BR>";
  echo "Address: ".$user->address_1."<BR>";
  echo "Post code: ".$user->postcode."<BR>";
  echo "<BR>";
  if ($cvCount>0) echo $cvCount."x CVs<BR>";
  if ($franchiseCount>0) echo $franchiseCount."x Franchise adverts<BR>";
  if ($goldCount>0) echo $goldCount."x Gold adverts<BR>";
  if ($jobCount>0) echo $jobCount."x Jobs<BR>";
  if ($platinumCount>0) echo $platinumCount."x Platinum adverts<BR>";
  if ($restaurantCount>0) echo $restaurantCount."x Restaurant adverts<BR>";
  if ($supplierCount>0) echo $supplierCount."x Supplier adverts<BR>";
?>

<br>

<input type=button value="Confirm" onClick="document.formDelete.submit()">
&nbsp;&nbsp;&nbsp;
<input type=button value="Cancel" onClick="location.href='account.php'">

</form></td></tr></table></td>
 </tr>
 <tr>
  <td></td>
 </tr>
</table>

<?php
require("bottom.php");
?>

