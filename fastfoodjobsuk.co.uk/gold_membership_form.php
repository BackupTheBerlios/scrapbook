<?php
require("common_user.php");
checkForAddress();
$errorText="";

$member=new Gold_membership();
$id=intval($_GET["id"]);
if ($id==0){
	$id=intval($_POST["id"]);
}
if ($id>0){	
	$member=$member->Get($id);
	$user->canAccess($member);
} else { //new object
	$member->onlineuser_onlineuserid = $user->onlineuserId;

	//default link
	$member->link="http://";
	//free for now
	$member->gold_membership_status='active';
}

//check if form is being submitted
if ((bool)$_POST["submitting"])
{
  $member->logo=$_POST["currentFilename"];
  $member->name=$_POST["name"];
  $member->description=$_POST["description"];
  $member->link=$_POST["link"];
  $member->tel=$_POST["tel"];

  
  $tempFilename=$_FILES["logo"]["tmp_name"];
  if ($tempFilename!=""){
   $member->logo=generateFilename($user->onlineuserId,$_FILES["logo"]["name"]);
    move_uploaded_file($tempFilename,"logos/$member->logo");
  }

  if (($result=validate($member->name,"",255))!==true){
    $errorText.="<li>Franchise name is $result";
  }
  if (($result=validate($member->description,"",5000))!==true){
    $errorText.="<li>Description is $result";
  }
  if (($result=validate($member->link,"",255))!==true){
    $errorText.="<li>Website link is $result";
  }
  if (($result=validate($member->tel,"phonenumber",255))!==true){
    $errorText.="<li>Telephone number is $result";
  }

  if ($errorText==""){
    if (!file_exists("logos")){
      mkdir("logos");
    }

    $member->Save();
    header("Location: gold_membership_success.php");
  } else {
    $errorText="<ul>".$errorText."</ul>";
  }

}
require("top.php");
?>
<table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" width="463">
      <img src="images/spacer.gif" alt="" width="1" height="5" border="0">
    </td>
  </tr>

  <tr>
    <td valign="top" width="463">
<span class="redbar">| </span><span class="heading">Gold Member Advertisment </span> <span class="redbar">|</span><br>
<br>
<p style = "padding-left:5px; margin:0px;">Please begin by creating your advertisement. Your logo should be 135 wide by 115 high and be in gif or jpeg format. Logos with a canvas area different from the above will result in a squashed or distorted advertisement.<br />
 <br />
Complete the Restaurant name, a brief description, website address (if available) and your telephone number. Once completed you can amend this advertisement from your member area.</p>
    </td>
  </tr>
  
  <tr>
    <td>
      <hr noshade size="1">
    </td>
  </tr>
</table>
<form action="gold_membership_form.php" method="POST" enctype="multipart/form-data">
<input type=hidden name="id" value="<?php echo $member->gold_membershipId; ?>">
<input type=hidden name="submitting" value="true">

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
      echo "<TR>";
      echo "<TD>";
      echo "Current Logo:";
      echo "</td>";
      echo "<TD>";
      echo "<img src=\"logos/$member->logo\" width=\"$logoWidth\" height=\"$logoHeight\">";
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
      <input type="hidden" name="currentFilename" value="<?php echo $member->logo; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Restaurant Name:
    </td>
    <td>
      <input type="text" id="name" name="name" value="<?php echo $member->name; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Description:
    </td>
    <td>
      <textarea name="description" id="description"><?php
        echo $member->description;
      ?></textarea>
    </td>
  </tr>
  <tr>
    <td>
      Website link:
    </td>
    <td>
      <input type="text" id="link" name="link" value="<?php echo $member->link ; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Telephone number:
    </td>
    <td>
      <input type="text" id="tel" name="tel" value="<?php echo $member->tel; ?>">
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
