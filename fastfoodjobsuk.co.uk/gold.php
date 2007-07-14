<?php
	require("common_all.php");

?>

<?php
	require("top.php");
?>
<link rel=stylesheet href="css/gold.css" type="text/css">
							<div class="roundcont">
									<div class="roundtop">
										<img class="corner" src="images/bl_01.gif" alt="" style=" display: none;" /></div>
									<h1>UK Franchises</h1>
									<div class="roundbottom">
										<img src="images/bl_06.gif" alt="" class="corner" style=" display: none;" /></div>
								</div>
<table id="table">
<?php

  $member=new Gold_membership();
  $results=$member->GetList(array(array("gold_membershipid",">=","0")),"dt_created");
  shuffle($results);
  $rowCount=0;  
  echo "<TR>";
  foreach ($results as $obj){
    echo "<TD>";
    echo "<table id=\"table_inner\">";
    echo "<TR><TD class=\"cell_logo\"><img src=\"logos/".$obj->logo."\" width=\"$logoWidth\" height=\"$logoHeight\">";
    echo "</td></tr>";
    echo "<TR><TD class=\"cell_heading\"><a href=\"".$obj->link."\">".$obj->heading."</a></td></tr>";
    echo "<TR><TD class=\"cell_description\">".$obj->description."</td></tr>";
    echo "<TR><TD><BR></td></tr></table>";
    echo "</td>";
    $rowCount++;
    if ($rowCount>=$goldTableCols){
      $rowCount=0;
      echo "</tr><TR>";
    }
  }
  echo "</tr>";
?>
</table>
<?php
	require("bottom.php");
?>