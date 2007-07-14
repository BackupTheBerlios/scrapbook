<?php
require("common_all.php");

unset($_SESSION);
session_destroy();

header("Location: index.php?msg=You have successfully logged out");
?>
