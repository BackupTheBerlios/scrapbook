<?php
require("common_super.php");

checkForAddress();

$errorText="";

// when modifying a profile, you set the session parameter [modify][object] with the object data to pre-populate the fields
// you also set [modify][stage]=1 which means the fields will be pre-populated with data from the session variables.
// you only want to do this once. Next time, stage is set to 2 because we want to pre-populate the fields
// with data from the POST

if($_SESSION["modify"]["stage"]==1){
  $restaurant=$_SESSION["modify"]["object"];
  
  if ($user->onlineuserId!=$restaurant->onlineuser_onlineuserid && !isSuperUser(false)){
    // at this point the current user ID does not match the one on the 
    // the advert AND the super user is not performing this action so
    // something is suspect!
    exit;
  }
  
  $name=$restaurant->name;
  $description=$restaurant->description;
  $link=$restaurant->link;
  $tel=$restaurant->tel;
  $currentFilename=$restaurant->logo;
  $_SESSION["modify"]["stage"]=2;
} else {
  $name=$_POST["name"];
  $description=$_POST["description"];
  $link=$_POST["link"];
  $tel=$_POST["tel"];
  $currentFilename=$_POST["currentFilename"];
}

if (isset($_POST["create"])){
  
  $tempFilename=$_FILES["logo"]["tmp_name"];
  if ($tempFilename!=""){
    $currentFilename=generateFilename($user->onlineuserId,$_FILES["logo"]["name"]);
    move_uploaded_file($tempFilename,"logos/$currentFilename");
  }

  if (($result=validate($name,"",255))!==true){
    $errorText.="<li>Restaurant name is $result";
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
    
    $restaurant=new Restaurant($user->onlineuserId,$currentFilename, $name, $description, $link, $tel, date("U"), 'active');

    if ($_SESSION["modify"]["stage"]==2){
      $obj=$_SESSION["modify"]["object"];
      $restaurant->restaurantId=$obj->restaurantId;
    }
    unset($_SESSION["modify"]);
    
    $restaurant->Save();
    header("Location: admin_restaurant_success.php");
  } else {
    $errorText="<ul>".$errorText."</ul>";
  }

}
require("top.php");
?>
<form action="admin_restaurant_create.php" method="POST" enctype="multipart/form-data">
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