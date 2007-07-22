<?php
	require("common_all.php");
?>

<?php
	require("top.php");
?>
<link rel=stylesheet href="css/franchises.css" type="text/css">
<link rel=stylesheet href="css/gold.css" type="text/css">
							<div class="roundcont">
									<div class="roundtop">
										<img class="corner" src="images/bl_01.gif" alt="" style=" display: none;" /></div>
									<h1>Franchises for Sale</h1>
									<div class="roundbottom">
										<img src="images/bl_06.gif" alt="" class="corner" style=" display: none;" /></div>
								</div><p style = "margin-left:10px;">Selling a trading franchise is a discreet business both for the franchisee and franchisor.
Advertising in this section requires no pre-set information, it is designed to protect your business and privacy.<br /><br />

An advert could be as simple as; 'Pizza franchise for sale, Essex. Trading 3 years. Contact Fred on 123456789'<br /><br />

Or, you can add your logo and 25 words of text.<br /></p>
<table id="table">
<?php

  $franchise=new Franchise();
  $results=$franchise->GetList(array(array("franchise_status","=","active"),array("dt_expire",">",date("Y-m-d"))));
  shuffle($results);
  
  $rowCount=0;  
  echo "<TR>";
  foreach ($results as $obj){
    echo "<TD valign=\"top\" width = \"135\">";
    echo "<table id=\"table_inner\">";
    echo "<TR><TD class=\"cell_logo\">";
    echo "<a href=\"".$obj->link."\">";
    echo "<img src=\"logos/".$obj->logo."\" width=\"$logoWidth\" height=\"$logoHeight\" border=0>";
    echo "</a>";
    echo "</td></tr>";
    echo "<TR><TD class=\"cell_heading\"><a href=\"".$obj->link."\">".$obj->name."</a></td></tr>";
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
