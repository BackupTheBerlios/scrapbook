<?php
require("common_super.php");
$errorText="";
$restaurant=new Restaurant();

$id=intval($_GET["id"]);
if ($id==0){
	$id=intval($_POST["id"]);
}
if ($id>0){	
	$restaurant=$restaurant->Get($id);
	$user->canAccess($restaurant);
} else { //new object
	$restaurant->onlineuser_onlineuserid = $user->onlineuserId;

	//default link
	$restaurant->link="http://";
	//super admin access only, so always active
	$restaurant->restaurant_status='active';
}

//check if form is being submitted
if ((bool)$_POST["submitting"])
{
  $restaurant->name=$_POST["name"];
  $restaurant->description=$_POST["description"];
  $restaurant->link=$_POST["link"];
  $restaurant->tel=$_POST["tel"];
  $restaurant->logo=$_POST["currentFilename"];

  
  $tempFilename=$_FILES["logo"]["tmp_name"];
  if ($tempFilename!=""){
    $restaurant->logo=generateFilename($user->onlineuserId,$_FILES["logo"]["name"]);
    move_uploaded_file($tempFilename,"logos/$restaurant->logo");
  }

  if (($result=validate($restaurant->name,"",255))!==true){
    $errorText.="<li>Restaurant name is $result";
  }
  if (($result=validate($restaurant->description,"",5000))!==true){
    $errorText.="<li>Description is $result";
  }
  if (($result=validate($restaurant->link,"",255))!==true){
    $errorText.="<li>Website link is $result";
  }
  if ($restaurant->tel!="" &&($result=validate($restaurant->tel,"phonenumber",255))!==true){
    $errorText.="<li>Telephone number is $result";
  }

  if ($errorText==""){
    if (!file_exists("logos")){
      mkdir("logos");
    }
  
    $restaurant->Save();
    header("Location: restaurant_success.php");
  } else {
    $errorText="<ul>".$errorText."</ul>";
  }

}
require("top.php");
?>
<table width="459" border="0" cellspacing="0" cellpadding="0" >
 <tr>
  <td><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /></td>
 </tr>
 <tr>
  <td><div class="roundcont">
   <div class="roundtop"> <img class="corner" src="images/bl_01.gif" alt="edge" style=" display: none;" /></div>
   <h1>Venue Advertisement</h1>
   <div class="roundbottom"> <img src="images/bl_06.gif" alt="edge" class="corner" style=" display: none;" /></div>
  </div></td>
 </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top" width="455"><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /> </td>
 </tr>
 <tr>
  <td valign="top" width="455"><p style = "padding-left:5px; margin:0px;">Please begin by creating your advertisement. Your logo should be 135 wide by 115 high and be in gif or jpeg format. Logos with a canvas area different from the above will result in a squashed or distorted advertisement.<br />
    <br />
Complete the Venue name, a brief description, website address (if available) and your telephone number. Once completed you can amend this advertisement from your member area.</p>
    <br /></td>
 </tr>
 <tr>
  <td></td>
 </tr>
</table>
<form action="restaurant_form.php" method="POST" enctype="multipart/form-data">
<input type=hidden name="id" value="<?php echo $restaurant->restaurantId; ?>">
<input type=hidden name="submitting" value="true">

<table id="table_create" class = "uploadform">
  <tr>
    <td colspan=2 id="cell_error_text">
    <?php
      echo $errorText;
    ?>
    </td>
  </tr>
  <?php
    if ($restaurant->logo!=""){
      echo "<TR>";
      echo "<TD>";
      echo "Current Logo:";
      echo "</td>";
      echo "<TD>";
      echo "<img src=\"logos/$restaurant->logo\" width=\"$logoWidth\" height=\"$logoHeight\">";
      echo "</td>";
      echo "</tr>";
    }
  ?>
  <tr>
    <td>
      Upload Logo:
    </td>
    <td>
      <input type="file" id="file" name="logo">
      <input type="hidden" name="currentFilename" value="<?php echo $restaurant->logo; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Venue Name:
    </td>
    <td>
      <input class = "detail" type="text" id="name" name="name" value="<?php echo $restaurant->name; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Description:
    </td>
    <td>
      <textarea class = "detail" name="description" id="description"><?php
        echo $restaurant->description;
      ?></textarea>
    </td>
  </tr>
  <tr>
    <td>
      Website link:
    </td>
    <td>
      <input class = "detail" type="text" id="link" name="link" value="<?php echo $restaurant->link; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Telephone number:
    </td>
    <td>
      <input class = "detail" type="text" id="tel" name="tel" value="<?php echo $restaurant->tel; ?>">
    </td>
  </tr>
  <tr>
    <td>
    </td>
    <td>
      <input type="submit" id="submit" value="Submit">
      <?php
        if (isset($_SESSION["cancel"])){
          echo "<input type=\"button\" onClick=\"location.href='".$_SESSION["cancel"]."'\" value=\"Cancel\">";
        }
      ?>
    </td>
  </tr>
</table>

</form>
<?php
	require("bottom.php");
?>
