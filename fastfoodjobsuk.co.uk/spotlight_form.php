<?php
require("common_super.php");
$errorText="";

$member=new Spotlight();

$spotlight_type=$_GET["type"];
if ($spotlight_type==""){
  $spotlight_type=$_POST["type"];
}
if ($spotlight_type==""){
  echo( "there must always be a type");
  exit;
}
$membershipId=(int)$_GET["membershipid"];
if ($membershipId==0){
  $membershipId=(int)$_POST["membershipid"];
} 
if ($membershipId>0){
  $member = $member->GetSpotlight($spotlight_type,$membershipId);
} else {
  echo( "there must always be a membershipId");
  exit;
}

  
if (intval($member->spotlightId)==0){
  // new form
  $member->membershipId= $membershipId;
  $member->spotlight_type=$spotlight_type;
  $parent=new $spotlight_type;
  $parent=$parent->Get($membershipId);
  $member->logo=$parent->logo;
  $member->link=$parent->link;
  $member->name=$parent->name;
}



//check if form is being submitted
if ((bool)$_POST["submitting"])
{
  $member->logo=$_POST["currentFilename"];
	$member->image1=$_POST["currentFilenameImg1"];
	$member->image2=$_POST["currentFilenameImg2"];
	$member->heading=$_POST["heading"];
	$member->text=$_POST["text"];
	$member->name=$_POST["name"];
	$member->address=$_POST["address"]; 
	$member->tel=$_POST["tel"];
	$member->fax=$_POST["fax"];
	$member->email=$_POST["email"];
	$member->link=$_POST["link"];
	
	if (($tempFilename=$_FILES["logo"]["tmp_name"])!=""){
		$member->logo=generateFilename($user->onlineuserId,$_FILES["logo"]["name"]);
		move_uploaded_file($tempFilename,"logos/$member->logo");
	}
	
	if (($tempFilename1=$_FILES["image1"]["tmp_name"])!=""){
		$member->image1=generateFilename($user->onlineuserId,$_FILES["image1"]["name"]);
		move_uploaded_file($tempFilename1,"logos/$member->image1");
	}
	
	if (($tempFilename2=$_FILES["image2"]["tmp_name"])!=""){
		$member->image2=generateFilename($user->onlineuserId,$_FILES["image2"]["name"]);
		move_uploaded_file($tempFilename2,"logos/$member->image2");
	}
	
	if (($result=validate($member->heading,"",255))!==true){
		$errorText.="<li>The heading is $result";
	}
	if (($result=validate($member->text,"",5000))!==true){
		$errorText.="<li>The text is $result";
	}
	if (($result=validate($member->name,"",255))!==true){
		$errorText.="<li>The company name is $result";
	}
	if (($result=validate($member->address,"",255))!==true){
		$errorText.="<li>The address is $result";
	}
	if (($result=validate($member->tel,"phonenumber",40))!==true){
		$errorText.="<li>The telephone number is $result";
	}
	if (($result=validate($member->fax,"phonenumber",40))!==true){
		$errorText.="<li>The fax number is $result";
	}
	if (($result=validate($member->email,"email",255))!==true){
		$errorText.="<li>The email address is $result";
	}
	if (($result=validate($member->link,"",255))!==true){
		$errorText.="<li>Website link is $result";
	}
	
  	if ($errorText==""){ //passed vlidation, now insert/update db
    	if (!file_exists("logos")){
      		mkdir("logos");
    	}
    	$member->Save();
    	header("Location: spotlight_success.php?i=".$member->spotlightId);
  	} else { // in error
    	$errorText="<ul>".$errorText."</ul>";
  	}
}
	
require("top.php");
?>
<script type="text/javascript" src="fckeditor/fckeditor.js"></script>
<script type="text/javascript">
<!--
	window.onload = function()
	{
		var oFCKeditor = new FCKeditor('text', 360, 500);
		oFCKeditor.BasePath = "fckeditor/";
		oFCKeditor.ToolbarSet = "MySets" ;
		oFCKeditor.ReplaceTextarea();
	}
-->
</script>
<table width="459" border="0" cellspacing="0" cellpadding="0" >
 <tr>
  <td><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /></td>
 </tr>
 <tr>
  <td><div class="roundcont">
   <div class="roundtop"> <img class="corner" src="images/bl_01.gif" alt="edge" style=" display: none;" /></div>
   <h1>Spotlight Advertisement</h1>
   <div class="roundbottom"> <img src="images/bl_06.gif" alt="edge" class="corner" style=" display: none;" /></div>
  </div></td>
 </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top" width="455"><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /> </td>
 </tr>
 <tr>
  <td valign="top" width="455"><p style = "padding-left:5px; margin:0px;">Please begin by creating your advertisement. Your logos should be 153 wide by 104 high and be in gif or jpeg format. Logos with a canvas area different from the above will result in a squashed or distorted advertisement.<br />
    <br />
Complete the information required - information can always be modified later.</p>
  </td>
 </tr>
 <tr>
  <td></td>
 </tr>
</table>
<form action="spotlight_form.php"  method="POST" enctype="multipart/form-data">
<input type=hidden name="submitting" value="true">
<input type=hidden name="membershipid" value="<?php echo $member->membershipId; ?>">
<input type=hidden name="type" value="<?php echo $member->spotlight_type; ?>">
<table id="table_create">
  <tr>
    <td colspan=2 id="cell_error_text">
    <?php
      echo $errorText;
    ?>
    </td>
  </tr>
  <?php
    if ($member->logo!=""){
      echo "<tr>";
      echo "<td>";
      echo "Current Logo:";
      echo "</td>";
      echo "<Td>";
      echo "<img src=\"logos/$member->logo\" width=\"$platinumImageWidth\" height=\"$platinumImageHeight\">";
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
      <input type=hidden name="currentFilename" value="<?php echo $member->logo; ?>">
    </td>
  </tr>
  <?php
    if ($member->image1!=""){
      echo "<TR>";
      echo "<TD>";
      echo "Current image1:";
      echo "</td>";
      echo "<TD>";
      echo "<img src=\"logos/$member->image1\" width=\"$platinumImageWidth\" height=\"$platinumImageHeight\">";
      echo "</td>";
      echo "</tr>";
    }
  ?>
  <tr>
    <td>
      Upload Image1:    </td>
    <td>
      <input type="file" id="file1" name="image1">
      <input type=hidden name="currentFilenameImg1" value="<?php echo $member->image1; ?>">
    </td>
  </tr>
  <?php
    if ($member->image2!=""){
      echo "<TR>";
      echo "<TD>";
      echo "Current image2:";
      echo "</td>";
      echo "<TD>";
      echo "<img src=\"logos/$member->image2\" width=\"$platinumImageWidth\" height=\"$platinumImageHeight\">";
      echo "</td>";
      echo "</tr>";
    }
  ?>
  <tr>
    <td>
      Upload Image2:    </td>
    <td>
      <input type="file" id="file2" name="image2">
      <input type=hidden name="currentFilenameImg2" value="<?php echo $member->image2; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Heading:
    </td>
    <td>
      <input type="text" id="heading" name="heading" value="<?php echo $member->heading; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Text:
    </td>
    <td>
      <textarea name="text" id="text"><?php
        echo $member->text;
      ?></textarea>

    </td>
  </tr>
  <tr>
    <td>
      Company Name:
    </td>
    <td>
      <input type="text" id="name" name="name" value="<?php echo $member->name; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Address:
    </td>
    <td>
      <textarea name="address" rows="4" id="address"><?php
        echo $member->address ;
      ?></textarea>

    </td>
  </tr>
  <tr>
    <td>
      Telephone:
    </td>
    <td>
      <input type="text" id="tel" name="tel" value="<?php echo $member->tel; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Fax:
    </td>
    <td>
      <input type="text" id="fax" name="fax" value="<?php echo $member->fax; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Email:
    </td>
    <td>
      <input type="text" id="email" name="email" value="<?php echo $member->email; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Website link:
    </td>
    <td>
      <input type="text" id="link" name="link" value="<?php echo $member->link; ?>">
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
