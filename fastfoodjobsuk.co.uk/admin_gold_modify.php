<?php
require("common_user.php");

$obj=new Gold_membership();
$obj=$obj->Get((int)$_GET["id"]);

$_SESSION["modify"]["object"]=$obj;
$_SESSION["modify"]["stage"]=1;

header("Location: admin_gold_create.php");

?>