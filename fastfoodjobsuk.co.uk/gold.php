<?php
require("common_all.php");

  $member=new Gold_membership();
  $results=$member->GetList(array(array("gold_membership_status","=","active"),array("dt_expire",">",date("Y-m-d"))));
  shuffle($results);

  foreach ($results as $obj){
	updateImpressions("gold_membership",$obj->gold_membershipId);
  }
$section=4;
require("top.php");
?>
<link rel=stylesheet href="css/gold.css" type="text/css">
							<table width="459" border="0" cellspacing="0" cellpadding="0" >
        <tr>
         <td><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /></td>
        </tr>
        <tr>
         <td><div class="roundcont">
           <div class="roundtop"> <img class="corner" src="images/bl_01.gif" alt="edge" style=" display: none;" /></div>
          <h1>Gold Members - UK Franchises</h1>
          <div class="roundbottom"> <img src="images/bl_06.gif" alt="edge" class="corner" style=" display: none;" /></div>
         </div></td>
        </tr>
       </table>
							<p style ="margin-left:10px;">Click on the logo to visit the companies web site or on the archived link for more details.</p>
<table id="table" cellspacing = "0" cellpadding = "0">
<?php

  $rowCount=0;  
  echo "<TR>";
  foreach ($results as $obj){
    echo "<TD valign=\"top\" width = \"135\">";
    echo "<table id=\"table_inner\">";
    echo "<TR><TD class=\"cell_logo\">";
    $url="goto.php?type=gold_membership&id=".$obj->gold_membershipId."&link=$obj->link";
    echo "<a href=\"".$url."\" target='_gold' >";
    echo "<img src=\"logos/".$obj->logo."\" width=\"$logoWidth\" height=\"$logoHeight\" align = \"top\" border=0>";
    echo "</a>";
    echo "</td></tr>";
    //echo "<TR><TD class=\"cell_heading\"><a href=\"".$obj->link."\">".$obj->name."</a></td></tr>";
    echo "<TR><TD class=\"cell_heading\"><a href=\"$url\" target='_gold' class = 'news'>".$obj->name."</a></td></tr>";
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
  echo "</tr>";
?>
</table>
<?php
	require("bottom.php");
?>
