<?php
	require("common_all.php");

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
  $type=(int)$_GET["type"];

  $supplier=new Supplier();
  $results=$supplier->GetList(array(array("supplier_category_id","=",$type)),"dt_created");
  shuffle($results);
  
  $rowCount=0;
  echo "<TR>";
  if (count($results)==0){
    echo "<TD>";
    echo "<a href = \"javascript:void(window.history.go(-1));\" class = \"contact\">< back</a><br><br><strong>There are currently no suppliers in this category</strong>";
    echo "</td>";
  } else {
    foreach ($results as $obj){
      echo "<TD>";
      echo "<table id=\"table_inner\">";
      echo "<TR><TD class=\"cell_logo\"><img src=\"logos/".$obj->logo."\" width=\"$logoWidth\" height=\"$logoHeight\">";
      echo "</td></tr>";
      echo "<TR><TD class=\"cell_heading\"><a href=\"".$obj->link."\" class=\"news\">".$obj->name."</a></td></tr>";
      echo "<TR><TD class=\"cell_description\">".$obj->description."</td></tr>";
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
