<?php
	require("common_all.php");
?>

<?php
	require("top.php");
?>
<table width="459" border="0" cellspacing="0" cellpadding="0" >
 <tr>
  <td><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /></td>
 </tr>
 <tr>
  <td><div class="roundcont">
   <div class="roundtop"> <img class="corner" src="images/bl_01.gif" alt="edge" style=" display: none;" /></div>
   <h1>Registration Complete</h1>
   <div class="roundbottom"> <img src="images/bl_06.gif" alt="edge" class="corner" style=" display: none;" /></div>
  </div></td>
 </tr>
</table>
<table class = "newstable"><tr><td>
<?php
echo "Thank you for registering. <br><br>Please check the email account that was used to register as it contains important information.<br>";
if (isset($_SESSION["redirect"])){
  echo "<a href=\"".$_SESSION["redirect"]."\" class = \"news\">Please continue &gt;</a>";
  unset($_SESSION["redirect"]);
}
?></td></tr></table>
<?php
	require("bottom.php");
?>