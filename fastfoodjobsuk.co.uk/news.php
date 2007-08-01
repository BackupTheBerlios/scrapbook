<?php
require("common_all.php");
$section=2;
require("top.php");
require("news_fixed.html");
$news=new News();
$newsList=$news->GetList(array(array("live")),"dt_created",false);

echo "<table>";

foreach ($newsList as $newsObject){
  echo "<TR><TD>";
  echo "<table width = '100' align = 'right' cellpadding = '0' cellspacing = '0'><tr><td align = 'right'>".FormatDateTime($newsObject->dt_created,7)."</td></tr></table>";
  echo "<b>".$newsObject->heading."</b>";
  echo "</td></tr>";
  echo "<TR><TD class=\"cell_description\">";
  echo $newsObject->description;
  echo "</td></tr>";
  echo "<tr><TD class=\"cell_link\">";
  echo "<a href=\"".$newsObject->link."\" class=\"news\" target='_link'>Click here for the full story</a>";
  echo "</td>";
  echo "</tr>";
  
  echo "<TR><TD><hr class = \"newsbreaker\" ><BR></td></tr>";
  
}

echo "</table>";

?>
<?php
	require("bottom.php");
?>