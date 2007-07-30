<?php
require("common_all.php");
$section=2;
require("top.php");
require("news_fixed.html");
$news=new News();
$newsList=$news->GetList(array(array("live")),"dt_created",false);

echo "<table class=\"newstable\">";

foreach ($newsList as $newsObject){
  echo "<TR><TD class=\"cell_heading\">";
  echo $newsObject->heading;
  echo "<br>";
  echo FormatDateTime($newsObject->dt_created,7);
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