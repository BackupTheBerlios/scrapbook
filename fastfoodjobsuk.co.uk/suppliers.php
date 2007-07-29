<?php
	require("common_all.php");
	$section=7;
	require("top.php");
?><table width="459" border="0" cellspacing="0" cellpadding="0" ><tr><td><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /></td></tr>
<tr><td><div class="roundcont">
  <div class="roundtop"> <img class="corner" src="images/bl_01.gif" alt="edge" style=" display: none;" /></div>
  <h1>Suppliers</h1>
  <div class="roundbottom"> <img src="images/bl_06.gif" alt="edge" class="corner" style=" display: none;" /></div>
 </div></td></tr></table>
<table width="459" border="0" cellspacing="0" cellpadding="0" class = "newstable">
<tr>
 <td class="contact"></td>
 <td><img src="images/spacer.gif" alt="spacer" width="1" height="1" border="0" /> </td>
</tr>
<tr>
<td class="contact" width="3"></td>
<td class="contact" width="456"><p>The Fast Food Industry in the UK is served &amp; serviced by a unique sort after group of specialised dedicated companies. <br />
   <br />
 </p>
 <div align="center">  <b><font color="#ff0000">But where and how do your customers find you!</font></b></div>
  
  <br />
  <p>FAST FOOD JOBS UK For the first time brings the needs of our industry together in one place in the following categories:<br />
   <br />
  </p> </td>
</tr>
<tr>
<td class="contact" width="3"></td>
<td width="456"><div align="center">
<h2 style = "margin-top:10px;"><b>Suppliers Categories</b></h2>
<span class = "supplierlinespace">
    <?php
      
        $supCategory=new Supplier_category();
        $results=$supCategory->GetList(array(array(1)),"name");
        $max=count($results);
        for($i=0;$i<$max;$i++){
          $obj=$results[$i];
          echo "<a class=\"contact\" href=\"suppliers_show.php?type=".$obj->supplier_categoryId."&name=".ucwords($obj->name)."\">".ucwords($obj->name)."</a>";
          if ($i<($max-1)){
            echo " <span class=\"redbar\">-</span> \n";
          }
        }
      ?></span><br>
<br>
<br>
</div></td>
</tr>
<tr>
<td valign="top" width="3"></td>
<td valign="top" width="456"><br>
<div align="center">
<b><a href="supplier_form.php" class = "newslarge">Sign up for your listing NOW!</a></b><br>
<br />
<a class="news" href="mailto:info@fastfoodjobsuk.co.uk">
info@fastfoodjobsuk.co.uk</a><br>
<br />
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
