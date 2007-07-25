<?php

require("common_all.php");

$class=$_GET["type"];
$id=(int)$_GET["id"];

$object=@new $class;
$object=@$object->Get($id);

isUniqueVisit($class, $id, "clicks");

header("Location: ".$object->link);

?>
