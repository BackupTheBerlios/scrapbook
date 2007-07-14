<?php
require("common_super.php");

//checkForAddress();
$errorText="";

// when modifying a profile, you set the session parameter [modify][object] with the object data to pre-populate the fields
// you also set [modify][stage]=1 which means the fields will be pre-populated with data from the session variables.
// you only want to do this once. Next time, stage is set to 2 because we want to pre-populate the fields
// with data from the POST

if($_SESSION["modify"]["stage"]==1){
  $franchise=$_SESSION["modify"]["object"];
  
  if ($user->onlineuserId!=$franchise->onlineuser_onlineuserid && !isSuperUser(false)){
    // at this point the current user ID does not match the one on the 
    // the advert AND the super user is not performing this action so
    // something is suspect!
    exit;
  }
  
  $currentFilename=$franchise->logo;
  $county=$franchise->town;
  $name=$franchise->name;
  $description=$franchise->description;
  $link=$franchise->link;
  $tel=$franchise->tel;
  $_SESSION["modify"]["stage"]=2;
} else {
  $currentFilename=$_POST["currentFilename"];
  $county=$_POST["county"];
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

  if (($result=validate($county,"",255))!==true){
    $errorText.="<li>The chosen county is $result";
  }
  if (($result=validate($name,"",255))!==true){
    $errorText.="<li>The name is $result";
  }
  if (($result=validate($description,"",5000))!==true){
    $errorText.="<li>The description is $result";
  }
  if (($result=validate($tel,"phonenumber",45))!==true){
    $errorText.="<li>The telephone number is $result";
  }
  if (($result=validate($link,"",255))!==true){
    $errorText.="<li>Website URL is $result";
  }

  if ($errorText==""){
    if (!file_exists("logos")){
      mkdir("logos");
    }
    
    $franchise=new Franchise($user->onlineuserId, $currentFilename, $county, $name, $description, $link, $tel, date("U"),"active");

    if ($_SESSION["modify"]["stage"]==2){
      $obj=$_SESSION["modify"]["object"];
      $franchise->franchiseId=$obj->franchiseId;
    }
    unset($_SESSION["modify"]);

    $franchise->Save();
    $errorText="<P><B>Franchise has successfully been saved</b></p>";
    unset($_POST);
  } else {
    $errorText="<ul>".$errorText."</ul>";
  }

}
require("top.php");
?>
<form action="admin_franchise_create.php" method="POST" enctype="multipart/form-data">
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
      Town or County:
    </td>
    <TD>
      <select name="county" id="county">
      <?php
        if (isset($county)){
          $f=fopen("county_list.htm","r");
          while (!feof($f)){
            $d=fgets($f);
            $start=strpos($d,"\"")+1;
            $end=strrpos($d,"\"");
            $val=substr($d,$start,$end-$start);
            if ($val==$county){
              $newD=substr($d,0,$end+1);
              $newD.=" SELECTED";
              $newD.=substr($d,$end+1);
              $d=$newD;
            }
            echo $d;
          }
          fclose($f);
        } else {
          require("county_list.htm");
        }
      ?>
      </select>
    </td>
  </tr>
  <TR>
    <TD>
      Name:
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
      Telephone Number:
    </td>
    <TD>
      <input type="text" id="tel" name="tel" value="<?php echo $tel; ?>">
    </td>
  </tr>
  <TR>
    <TD>
      Link:
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
