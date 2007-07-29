<?php
	require("common_all.php");

?>

<?php
$section=6;
	require("top.php");
?>
<link rel=stylesheet href="css/restaurants.css" type="text/css">
<link rel=stylesheet href="css/gold.css" type="text/css">
							<table width="459" border="0" cellspacing="0" cellpadding="0" >
        <tr>
         <td><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /></td>
        </tr>
        <tr>
         <td><div class="roundcont">
           <div class="roundtop"> <img class="corner" src="images/bl_01.gif" alt="edge" style=" display: none;" /></div>
          <h1>Venues</h1>
          <div class="roundbottom"> <img src="images/bl_06.gif" alt="edge" class="corner" style=" display: none;" /></div>
         </div></td>
        </tr>
       </table>
							<table border="0" cellspacing="0" cellpadding="0">
        <tr>
         <td valign="top" width="463"><img src="images/spacer.gif" alt="" width="1" height="5" border="0" /> </td>
        </tr>
        <tr>
         <td valign="top" width="463"><p style = "padding-left:5px; margin:0px;">The purpose of this page COMING SOON is to allow people and Companies from different ends of the country a convenient place to meet, socialise and team build ETC. <br />
          <br />
          This may be anything from two to two hundred people and will be a free service.</p>
         <br /></td>
        </tr>
        <tr>
         <td></td>
        </tr>
       </table>
							<table id="table">

<?php

  $restaurant=new Restaurant();
  $results=$restaurant->GetList(array(array("restaurant_status","=","active")));
  
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
    echo "<TR><TD class=\"cell_heading\"><a href=\"".$obj->link."\" class = \"news\">".$obj->name."</a></td></tr>";
    echo "<TR><TD class=\"cell_description\">".$obj->description."</td></tr>";
    echo "<TR><TD class=\"cell_tel\">".$obj->tel."</td></tr>";
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
