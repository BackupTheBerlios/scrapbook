<?php
require("common_super.php");

$obj=new News();
$obj=$obj->Get((int)$_GET["id"]);

$_SESSION["modify"]["object"]=$obj;
$_SESSION["modify"]["stage"]=1;

header("Location: admin_news_create.php");

?>
