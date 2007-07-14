<?php
	require("common_all.php");
?>

<?php
	require("top.php");
?>
       <span class="redbar">| </span><span class="heading">Registration</span> <span class="redbar">|</span><br>
<br>
<?php
echo "Thank you for registering. <br>Please check the email account that was used to register as it contains important information.<br>";
if (isset($_SESSION["redirect"])){
  echo "<a href=\"".$_SESSION["redirect"]."\" class = \"news\">Please continue &gt;</a>";
  unset($_SESSION["redirect"]);
}
?>
<?php
	require("bottom.php");
?>