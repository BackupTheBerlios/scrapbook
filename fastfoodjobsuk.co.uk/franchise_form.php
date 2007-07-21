<?php
require("common_super.php");

//checkForAddress();
$errorText="";

$franchise=new Franchise();
$id=intval($_GET["id"]);
if ($id==0){
	$id=intval($_POST["id"]);
}
if ($id>0){	
	$franchise=$franchise->Get($id);
	//check to see user has access to this object	
	$user->canAccess($franchise);
	
} else { //new object
	$franchise->onlineuser_onlineuserid = $user->onlineuserId;
	
	//default link
	$franchise->link="http://";	

	$franchise->franchise_status='active';
}


//check if form is being submitted
if ((bool)$_POST["submitting"])
{
  $franchise->logo=$_POST["currentFilename"];
  $franchise->county=$_POST["county"];
  $franchise->name=$_POST["name"];
  $franchise->description=$_POST["description"];
  $franchise->link=$_POST["link"];
  $franchise->tel=$_POST["tel"];
  
  $tempFilename=$_FILES["logo"]["tmp_name"];
  if ($tempFilename!=""){
    $franchise->logo=generateFilename($user->onlineuserId,$_FILES["logo"]["name"]);
    move_uploaded_file($tempFilename,"logos/$franchise->logo");
  }

  if (($result=validate($franchise->county,"",255))!==true){
    $errorText.="<li>The chosen county is $result";
  }
  if (($result=validate($franchise->name,"",255))!==true){
    $errorText.="<li>The name is $result";
  }
  if (($result=validate($franchise->description,"",5000))!==true){
    $errorText.="<li>The description is $result";
  }
  if (($result=validate($franchise->tel,"phonenumber",45))!==true){
    $errorText.="<li>The telephone number is $result";
  }
  if (($result=validate($franchise->link,"",255))!==true){
    $errorText.="<li>Website URL is $result";
  }

  if ($errorText==""){
    if (!file_exists("logos")){
      mkdir("logos");
    }
    
    $franchise->Save();
    //$errorText="<P><B>Franchise has successfully been saved</b></p>";
    unset($_POST);
	header("Location: franchise_success.php");
  } else {
    $errorText="<ul>".$errorText."</ul>";
  }

}
require("top.php");
?>
<table border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top" width="463"><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /> </td>
 </tr>
 <tr>
  <td valign="top" width="463"><span class="redbar">| </span><span class="heading">Franchise for Sale Advertisment </span> <span class="redbar">|</span><br />
    <br />
    <p style = "padding-left:5px; margin:0px;">Please begin by creating your advertisement. Your logo should be 135 wide by 115 high and be in gif or jpeg format. Logos with a canvas area different from the above will result in a squashed or distorted advertisement.<br />
      <br />
  Complete the town or county, the name of the franchise, a brief description, website address (if available) and your telephone number. Once completed you can amend this advertisement from the super user area.</p></td>
 </tr>
 <tr>
  <td><hr noshade="noshade" size="1" />
  </td>
 </tr>
</table>
<form action="franchise_form.php" method="POST" enctype="multipart/form-data" >
<input type=hidden name="id" value="<?php echo $franchise->franchiseId; ?>">
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
    if ($franchise->logo!=""){
      echo "<TR>";
      echo "<TD>";
      echo "Current Logo:";
      echo "</td>";
      echo "<TD>";
      echo "<img src=\"logos/$franchise->logo\" width=\"$logoWidth\" height=\"$logoHeight\">";
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
      <input type="hidden" name="currentFilename" value="<?php echo $franchise->logo; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Town or County:
    </td>
    <td>
      <select name="county" id="county">
      <?php
       loadOptions("county_list.htm",$franchise->county);
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td>
      Name:
    </td>
    <td>
      <input type="text" id="name" name="name" value="<?php echo $franchise->name; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Description:
    </td>
    <td>
      <textarea name="description" id="description"><?php
        echo $franchise->description;
      ?></textarea>
    </td>
  </tr>
  <tr>
    <td>
      Telephone Number:
    </td>
    <td>
      <input type="text" id="tel" name="tel" value="<?php echo $franchise->tel; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Link:
    </td>
    <td>
      <input type="text" id="link" name="link" value="<?php echo $franchise->link ; ?>">
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
