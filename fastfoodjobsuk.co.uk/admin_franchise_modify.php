<?php
require("common_super.php");

$obj=new Franchise();
$obj=$obj->Get((int)$_GET["id"]);

$_SESSION["modify"]["object"]=$obj;
$_SESSION["modify"]["stage"]=1;

header("Location: admin_franchise_create.php");

?>
