<?php
	require("common_user.php");

checkForAddress();

$errorText="";

if($_SESSION["modify"]["stage"]==1){
  $member=$_SESSION["modify"]["object"];
  
  if ($user->onlineuserId!=$member->onlineuser_onlineuserid && !isSuperUser(false)){
    // at this point the current user ID does not match the one on the 
    // the advert AND the super user is not performing this action so
    // something is suspect!
    exit;
  }
  
  $currentFilename=$member->logo;
  $name=$member->name;
  $description=$member->description;
  $link=$member->link;
  $tel=$member->tel;
  $_SESSION["modify"]["stage"]=2;
} else {
  $currentFilename=$_POST["currentFilename"];
  $name=$_POST["name"];
  $description=$_POST["description"];
  $link=$_POST["link"];
  $tel=$_POST["tel"];
}

if (isset($_POST["create"])){
  
  $tempFilename=$_FILES["logo"]["tmp_name"];
  if ($tempFilename!=""){
    $currentFilename=generateFilename($user->onlineuserId,$_FILES["logo"]["name"]);
    move_uploaded_file($tempFilename,"logos/$currentFilename");
  }

  if (($result=validate($name,"",255))!==true){
    $errorText.="<li>Franchise name is $result";
  }
  if (($result=validate($description,"",5000))!==true){
    $errorText.="<li>Description is $result";
  }
  if (($result=validate($link,"",255))!==true){
    $errorText.="<li>Website link is $result";
  }
  if (($result=validate($tel,"phonenumber",255))!==true){
    $errorText.="<li>Telephone number is $result";
  }

  if ($errorText==""){
    if (!file_exists("logos")){
      mkdir("logos");
    }
    
    $member=new Gold_membership($user->onlineuserId,$currentFilename, $name, $description, $link, $tel, date("U"), 'active');

    if ($_SESSION["modify"]["stage"]==2){
      $obj=$_SESSION["modify"]["object"];
      $member->gold_membershipId=$obj->gold_membershipId;
    }
    unset($_SESSION["modify"]);

    $member->Save();
    header("Location: admin_gold_success.php");
  } else {
    $errorText="<ul>".$errorText."</ul>";
  }

}
require("top.php");
?>
<link rel=stylesheet href="css/admin_create.css" type="text/css">
<link rel=stylesheet href="css/admin_gold_create.css" type="text/css">
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
<p style = "padding-left:5px; margin:0px;">Please begin by creating your advertisement. Your logo should be 167 wide by 116 high and be in gif or jpeg format. Logos with a canvas area different from the above will result in a squashed or distorted advertisement.<br />
 <br />
Complete the Restaurant name, a brief description, website address (if available) and your telephone number. Once completed you can amend this advertisement from your member area.</p>
    </td>
  </tr>
  
  <TR>
    <TD>
      <hr noshade size="1">
    </td>
  </tr>
</table>
<form action="admin_gold_create.php" method="POST" enctype="multipart/form-data">
<input type=hidden name="create" value="1">

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
      echo "<img src=\"logos/$currentFilename\" width=\"$logoWidth\" height=\"$logoHeight\">";
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
      <input type="hidden" name="currentFilename" value="<?php echo $currentFilename; ?>">
    </td>
  </tr>
  <TR>
    <TD>
      Restaurant Name:
    </td>
    <TD>
      <input type="text" id="name" name="name" value="<?php echo $name; ?>">
    </td>
  </tr>
  <TR>
    <TD>
      Description:
    </td>
    <TD>
      <textarea name="description" id="description"><?php
        echo $description;
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
      Telephone number:
    </td>
    <TD>
      <input type="text" id="tel" name="tel" value="<?php echo $tel; ?>">
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
