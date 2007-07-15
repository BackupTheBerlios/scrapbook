<?php
require("common_user.php");

checkForAddress();

$errorText="";

// when modifying a profile, you set the session parameter [modify][object] with the object data to pre-populate the fields
// you also set [modify][stage]=1 which means the fields will be pre-populated with data from the session variables.
// you only want to do this once. Next time, stage is set to 2 because we want to pre-populate the fields
// with data from the POST

if($_SESSION["modify"]["stage"]==1){
  $member=$_SESSION["modify"]["object"];
  
  if ($user->onlineuserId!=$member->onlineuser_onlineuserid && !isSuperUser(false)){
    // at this point the current user ID does not match the one on the 
    // the advert AND the super user is not performing this action so
    // something is suspect!
    exit;
  }
  
  $currentFilename=$member->logo;
  $currentFilenameImg1=$member->image1;
  $currentFilenameImg2=$member->image2;
  $heading=$member->name;
  $text=$member->description;
  $link=$member->link;
  $_SESSION["modify"]["stage"]=2;
} else {
  $currentFilename=$_POST["currentFilename"];
  $currentFilenameImg1=$_POST["currentFilenameImg1"];
  $currentFilenameImg2=$_POST["currentFilenameImg2"];
  $heading=$_POST["heading"];
  $text=$_POST["text"];
  $link=$_POST["link"];
}

if (isset($_POST["create"])){
  
  if (($tempFilename=$_FILES["logo"]["tmp_name"])!=""){
    $currentFilename=generateFilename($user->onlineuserId,$_FILES["logo"]["name"]);
    move_uploaded_file($tempFilename,"logos/$currentFilename");
  }
  
  if (($tempFilename=$_FILES["image1"]["tmp_name"])!=""){
    $currentFilenameImg1=generateFilename($user->onlineuserId,$_FILES["image1"]["name"]);
    move_uploaded_file($tempFilename,"logos/$currentFilenameImg1");
  }
  
  if (($tempFilename=$_FILES["image2"]["tmp_name"])!=""){
    $currentFilenameImg2=generateFilename($user->onlineuserId,$_FILES["image2"]["name"]);
    move_uploaded_file($tempFilename,"logos/$currentFilenameImg2");
  }
  
  if (($result=validate($heading,"",255))!==true){
    $errorText.="<li>The heading is $result";
  }
  if (($result=validate($text,"",5000))!==true){
    $errorText.="<li>The text is $result";
  }
  if (($result=validate($link,"",255))!==true){
    $errorText.="<li>Website link is $result";
  }

  if ($errorText==""){
    if (!file_exists("logos")){
      mkdir("logos");
    }
    
    $member=new Platinum_membership($user->onlineuserId,$currentFilename, $currentFilenameImg1, $currentFilenameImg2, $heading, $text, $link, date("U"), 'active');
    
    if ($_SESSION["modify"]["stage"]==2){
      $obj=$_SESSION["modify"]["object"];
      $member->platinum_membershipId=$obj->platinum_membershipId;
    }
    unset($_SESSION["modify"]);
    
    $member->Save();
    header("Location: admin_platinum_success.php");
  } else {
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
		var oFCKeditor = new FCKeditor('text', 520, 250);
		oFCKeditor.BasePath = "fckeditor/";
		oFCKeditor.ToolbarSet = "MySets" ;
		oFCKeditor.ReplaceTextarea();
	}
-->
</script>
<link rel=stylesheet href="css/admin_create.css" type="text/css">
<link rel=stylesheet href="css/admin_platinum_create.css" type="text/css">

<form action="admin_platinum_create.php" method="POST" enctype="multipart/form-data">
<input type=hidden name="create" value="1">
<table border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top" width="463"><img src="images/spacer.gif" alt="" width="1" height="5" border="0" /> </td>
 </tr>
 <tr>
  <td valign="top" width="463"><span class="redbar">| </span><span class="heading">Platinum Member Advertisment </span> <span class="redbar">|</span><br />
    <br />
    <p style = "padding-left:5px; margin:0px;">Please begin by creating your advertisement. Your logos should be 153 wide by 104 high and be in gif or jpeg format. Logos with a canvas area different from the above will result in a squashed or distorted advertisement.<br />
      <br />
     Complete the information required - information can always be modified later.</p></td>
 </tr>
 <tr>
  <td><hr noshade="noshade" size="1" />
  </td>
 </tr>
</table>
<table id="table_create">
  <TR>
    <TD colspan=2 id="cell_error_text">
    <?php
      echo $errorText;
    ?>
    </td>
  </tr>
  <?php
    if ($currentFilename!=""){
      echo "<TR>";
      echo "<TD>";
      echo "Current Logo:";
      echo "</td>";
      echo "<TD>";
      echo "<img src=\"logos/$currentFilename\" width=\"$platinumImageWidth\" height=\"$platinumImageHeight\">";
      echo "</td>";
      echo "</tr>";
    }
  ?>
  <TR>
    <TD>
      Upload Logo:
    </td>
    <TD>
      <input type="file" id="file" name="logo">
      <input type=hidden name="currentFilename" value="<?php echo $currentFilename; ?>">
    </td>
  </tr>
  <?php
    if ($currentFilenameImg1!=""){
      echo "<TR>";
      echo "<TD>";
      echo "Current image 1:";
      echo "</td>";
      echo "<TD>";
      echo "<img src=\"logos/$currentFilenameImg1\" width=\"$platinumImageWidth\" height=\"$platinumImageHeight\">";
      echo "</td>";
      echo "</tr>";
    }
  ?>
  <TR>
    <TD>
      Upload Image 1:
    </td>
    <TD>
      <input type="file" id="file1" name="image1">
      <input type=hidden name="currentFilenameImg1" value="<?php echo $currentFilenameImg1; ?>">
    </td>
  </tr>
  <?php
    if ($currentFilenameImg2!=""){
      echo "<TR>";
      echo "<TD>";
      echo "Current image 2:";
      echo "</td>";
      echo "<TD>";
      echo "<img src=\"logos/$currentFilenameImg2\" width=\"$platinumImageWidth\" height=\"$platinumImageHeight\">";
      echo "</td>";
      echo "</tr>";
    }
  ?>
  <TR>
    <TD>
      Upload Image 2:
    </td>
    <TD>
      <input type="file" id="file2" name="image2">
      <input type=hidden name="currentFilenameImg2" value="<?php echo $currentFilenameImg2; ?>">
    </td>
  </tr>
  <TR>
    <TD>
      Heading:
    </td>
    <TD>
      <input type="text" id="heading" name="heading" value="<?php echo $heading; ?>">
    </td>
  </tr>
  <TR>
    <TD>
      Text:
    </td>
    <TD>
      <textarea name="text" id="text"><?php
        echo $text;
      ?></textarea>

    </td>
  </tr>
  <TR>
    <TD>
      Website link:
    </td>
    <TD>
      <input type="text" id="link" name="link" value="<?php echo (isset($link) ? $link : "http://"); ?>">
    </td>
  </tr>
  <TR>
    <TD>
    </td>
    <TD>
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