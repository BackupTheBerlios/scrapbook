<?php
require("common_super.php");
require("top.php");
?>
<table width="459" border="0" cellspacing="0" cellpadding="0" >
 <tr>
  <td><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /></td>
 </tr>
 <tr>
  <td><div class="roundcont">
   <div class="roundtop"> <img class="corner" src="images/bl_01.gif" alt="edge" style=" display: none;" /></div>
   <h1>Spotlight Advertisement</h1>
   <div class="roundbottom"> <img src="images/bl_06.gif" alt="edge" class="corner" style=" display: none;" /></div>
  </div></td>
 </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top" width="455"><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /> </td>
 </tr>
 <tr>
  <td valign="top" width="455"><p style = "padding-left:5px; margin:0px;">Thank you. Your Spotlight Page has been saved. </p>
   <p style = "padding-left:5px; margin:0px;"> The direct link for the page is:<br />
     <?php
          $url="http://www.fastfoodjobsuk.co.uk/spotlight.php?id=".$_GET["i"];
          echo "<a href=\"$url\">$url</a>";
        ?>
   </p>
   <p style = "padding-left:5px; margin:0px;"> <a href="account.php" class = "news">Click here</a> to return to your account. </p></td>
 </tr>
 <tr>
  <td></td>
 </tr>
</table>
<?php
require("bottom.php");
?>

