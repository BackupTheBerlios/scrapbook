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
<br>
Item has been deleted 
<p>
  <a href="admin_account.php" class = "news">Click here</a> to return to account admin.
</p>
<?php
require("bottom.php");
?>

