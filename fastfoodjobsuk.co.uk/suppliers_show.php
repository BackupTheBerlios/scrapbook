<?php
	require("common_all.php");
  $type=(int)$_GET["type"];

  $supplier=new Supplier();
  $results=$supplier->GetList(array(array("supplier_category_id","=",$type),array("supplier_status","=","active")),"dt_created");
  shuffle($results);
  
  foreach ($results as $obj){
    isUniqueVisit("supplier",$obj->supplierId,"impressions");
  }
  
?>
<?php
	require("top.php");
?>
						<div class="roundcont">
									<div class="roundtop">
										<img class="corner" src="images/bl_01.gif" alt="" style=" display: none;" /></div>
									<h1>Suppliers</h1>
									<div class="roundbottom">
										<img src="images/bl_06.gif" alt="" class="corner" style=" display: none;" /></div>
								</div>
<table id="table" cellspacing = "0" cellpadding = "0">
<?php
  
  $rowCount=0;
  echo "<TR>";
  if (count($results)==0){
    echo "<TD>";
    echo "<a href = \"javascript:void(window.history.go(-1));\" class = \"contact\">< back</a><br><br><strong>There are currently no suppliers in this category</strong>";
    echo "</td>";
  } else {
    foreach ($results as $obj){
      $url="goto.php?type=supplier&id=".$obj->supplierId;
      echo "<TD width = \"135\" valign=\"top\" >";
      echo "<table id=\"table_inner\">";
      echo "<TR><TD class=\"cell_logo\">";
      //echo "<a href=\"".$obj->link."\">";
      echo "<a href=\"$url\">";
      echo "<img src=\"logos/".$obj->logo."\" width=\"$logoWidth\" height=\"$logoHeight\" border=0>";
      echo "</a>";
      echo "</td></tr>";
      //echo "<TR><TD class=\"cell_heading\"><a href=\"".$obj->link."\" class=\"news\" target = \"_blank\">".$obj->name."</a></td></tr>";
      echo "<TR><TD class=\"cell_heading\"><a href=\"$url\" class=\"news\" target = \"_blank\">".$obj->name."</a></td></tr>";
      echo "<TR><TD class=\"cell_description\">".$obj->description."</td></tr>";
      echo "<TR><TD class=\"cell_tel\">".$obj->tel."</td></tr>";
      echo "<TR><TD>";
      if (($spotlightId=$obj->hasSpotlight()) !== false){
        echo "<a href=\"spotlight.php?id=$spotlightId\">Under Spotlight!</a>";
      }
      echo "</td></tr>";
      echo "<TR><TD><BR></td></tr></table>";
      echo "</td>";
      $rowCount++;
      if ($rowCount>=$goldTableCols){
        $rowCount=0;
        echo "</tr><TR>";
      }
    }
  }
  echo "</tr>";
?>
</table>
<?php
	require("bottom.php");
?>
