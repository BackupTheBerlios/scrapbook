<?php
require("common_super.php");

$restaurant=new Restaurant();
$restaurant=$restaurant->Get((int)$_GET["id"]);

$_SESSION["modify"]["object"]=$restaurant;
$_SESSION["modify"]["stage"]=1;

header("Location: admin_restaurant_create.php");

?>
