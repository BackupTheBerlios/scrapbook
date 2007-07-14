<?php
	require("common_all.php");
require("top.php");
require("news_fixed.html");
$news=new News();
$newsList=$news->GetList(array(array("live","=","1")),"dt_created",false);

echo "<table id=\"table\">";

foreach ($newsList as $newsObject){
  echo "<TR><TD class=\"cell_heading\">";
  echo $newsObject->heading;
  echo "</td></tr>";
  echo "<TR><TD class=\"cell_description\">";
  echo $newsObject->description;
  echo "</td></tr>";
  echo "<tr><TD class=\"cell_link\">";
  echo "<a href=\"".$newsObject->link."\" class=\"news\">Click here for the full story</a>";
  echo "</td>";
  echo "</tr>";
  
  echo "<TR><TD><BR></td></tr>";
  
}

echo "</table>";

?>
<?php
	require("bottom.php");
?>