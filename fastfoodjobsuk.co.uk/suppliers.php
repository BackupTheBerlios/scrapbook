<?php
	require("common_all.php");
	require("top.php");
?>
<table width="459" border="0" cellspacing="0" cellpadding="0">
<tr>
 <td class="contact"></td>
 <td><img src="images/spacer.gif" alt="spacer" width="1" height="1" border="0" /> </td>
</tr>
<tr>
<td class="contact" width="3"></td>
<td class="contact" width="456"><span class="redbar">| </span><span class="heading">Suppliers</span> <span class="redbar">|</span><br>
<br></td>
</tr>
<tr>
<td class="contact" width="3"></td>
<td width="456">The Fast Food Industry in the UK is served &amp; serviced by a unique sort after group of specialised dedicated companies.<br>
<div align="center">
<br>
<b><font color="#ff0000">But where and how do your customers find you!</font></b></div>


FAST FOOD JOBS UK For the first time brings the needs of our industry together in one place in the following  categories:<br>
<div align="center">
<h2><b>Suppliers Categories</b></h2>

      <?php
      
        $supCategory=new Supplier_category();
        $results=$supCategory->GetList(array(array(1)),"name");
        $max=count($results);
        for($i=0;$i<$max;$i++){
          $obj=$results[$i];
          echo "<a class=\"contact\" href=\"suppliers_show.php?type=".$obj->supplier_categoryId."\">".ucwords($obj->name)."</a>";
          if ($i<($max-1)){
            echo " <span class=\"redbar\">-</span> \n";
          }
        }
      ?><br>
<br>
Example of Suppliers adverts -<br>
<br>
</div></td>
</tr>
<tr>
<td valign="top" width="3"></td>
<td valign="top" width="456">
<table width="453" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="162"><a href="http://www.acornfinance.com" target="_blank"><img src="images/yourlogo1.jpg" alt="" width="140" height="74" border="0"></a></td>
<td width="144"><a href="http://www.0845team.co.uk" target="_blank"><img src="images/yourlogo3.jpg" alt="" width="140" height="74" border="0"></a></td>
<td width="140"><a href="http://www.bluelizardsigns.co.uk" target="_blank"><img src="images/yourlogo2.jpg" alt="" width="140" height="74" border="0"></a></td>
</tr>
<tr>
<td style = "padding-right:10px;" valign="top"><a class="news" href="http://www.acornfinance.com" target="_blank"><b>Acorn Contract Hire and Leasing<br>
</b></a>Specialists in all Car and Commercial Vehicle Finance,&nbsp; including Business and Personal Contracts <br>
<br></td>
<td style = "padding-right:10px;" valign="top"><a class="news" href="http://www.0845team.com/" target="_blank"><b>0845team<br>
</b></a>No Call Charges! No Hassle! No Gimmicks.<br>All you will be charged is &pound;50 per year for connection to a UK landline<br></td>
<td style = "padding-right:10px;" valign="top"><a class="news" href="http://www.bluelizardsigns.co.uk" target="_blank"><b>Blue Lizard designs<br>
</b></a>Specialists in vehicle graphics and wrapping.</td>
</tr>
</table>
<br>
<div align="center">
<b><font color="#ff0000">Send in your information NOW to get a top listing in your category <br>
(FREE OF CHARGE and without obligation for 2007) <br>
for when the site goes fully live in July.</font></b><br>
<a class="news" href="mailto:info@fastfoodjobsuk.co.uk">
info@fastfoodjobsuk.co.uk</a><br>
If your companies' category is not listed above, let us know.<br></div></td>
</tr>
</table>
<table id="table">
  <tr>
    <td>
<!--original position -->

    </td>
  </tr>
</table>
<?php
	require("bottom.php");
?>
