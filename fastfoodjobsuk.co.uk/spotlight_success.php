<?php
require("common_super.php");
require("top.php");
?>
<span class="redbar">| </span><span class="heading">Spotlight</span> <span class="redbar">|</span><br>
<br>
<table class = "registerTable">
  <tr>
    <td>
      Thank you. Your Spotlight Page has been saved.
      <P>
        The direct link for the page is:<BR>
        <?php
          $url="http://www.fastfoodjobsuk.co.uk/spotlight.php?id=".$_GET["i"];
          echo "<a href=\"$url\">$url</a>";
        ?>
      </p>
      <P>
        <a href="account.php" class = "news">Click here</a> to return to your account.
      </p>
    </td>
  </tr>
</table>
<?php
require("bottom.php");
?>

