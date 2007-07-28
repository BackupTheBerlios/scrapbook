<?php

require("common_all.php");

$class=$_GET["type"];
$id=(int)$_GET["id"];
$link=$_GET["link"];

updateUniqueClicks($class, $id);

header("Location: ".$link);

?>
