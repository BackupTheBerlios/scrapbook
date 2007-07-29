<?php
require("common_super.php");
require("top.php");

$class=stripslashes($_GET["type"]);
$id=(int)$_GET["id"];

if ($class=="Job")
{
	  $db=new DatabaseConnection();
	  $db->Query("delete from job where jobid=$id");
}
else if ($class=="CV")
{
	  $db=new DatabaseConnection();
	  $db->Query("delete from cv where cvid=$id");
}
else
{
	$object=new $class;
	$object=$object->Get($id);
	$object->Delete();  
}

?>
<table width="459" border="0" cellspacing="0" cellpadding="0" >
 <tr>
  <td><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /></td>
 </tr>
 <tr>
  <td><div class="roundcont">
   <div class="roundtop"> <img class="corner" src="images/bl_01.gif" alt="edge" style=" display: none;" /></div>
   <h1>Delete Item</h1>
   <div class="roundbottom"> <img src="images/bl_06.gif" alt="edge" class="corner" style=" display: none;" /></div>
  </div></td>
 </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top" width="455"><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /> </td>
 </tr>
 <tr>
  <td valign="top" width="455"><p style = "padding-left:5px; margin:0px;">&nbsp;</p>
    <p style = "padding-left:5px; margin:0px;"> Item has been successfully deleted </p>
    <p style = "padding-left:5px; margin:0px;"> Back to <a href="admin_account.php" class = "news">account</a><br />
      <br />
   </p></td>
 </tr>
 <tr>
  <td></td>
 </tr>
</table>
<p>&nbsp;</p>
<?php
require("bottom.php");
?>

