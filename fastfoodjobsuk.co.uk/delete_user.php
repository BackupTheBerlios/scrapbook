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

<P>
  Delete User
</p>

<form action="delete_user.php" method="POST" name="formDelete">
<input type=hidden name="id" value="<?php echo $id; ?>">
<input type=hidden name="submitting" value="true">
Please confirm you wish to delete the following user:
<BR>
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

<BR>

<input type=button value="Confirm" onClick="document.formDelete.submit()">
&nbsp;&nbsp;&nbsp;
<input type=button value="Cancel" onClick="location.href='account.php'">

</form>

<?php
require("bottom.php");
?>

