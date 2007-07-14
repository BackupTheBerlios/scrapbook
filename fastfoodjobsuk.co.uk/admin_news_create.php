<?php
require("common_super.php");
$errorText="";

if($_SESSION["modify"]["stage"]==1){
  $news=$_SESSION["modify"]["object"];
  
  if ($user->onlineuserId!=$news->onlineuser_onlineuserid && !isSuperUser(false)){
    // at this point the current user ID does not match the one on the 
    // the advert AND the super user is not performing this action so
    // something is suspect!
    exit;
  }
  
  $heading=$news->heading;
  $description=$news->description;
  $link=$news->link;
  $live=$news->live;
  
  $_SESSION["modify"]["stage"]=2;
} else {
  $heading=$_POST["heading"];
  $description=$_POST["description"];
  $link=$_POST["link"];
  $live="1";
}

if (isset($_POST["create"])){

  if(($result=validate($heading,"",255))!==true){
    $errorText.="<li>The news heading is $result";
  }
  if (($result=validate($description,"",5000))!==true){
    $errorText.="<li>The description is $result";
  }
  if (($result=validate($link,"",255))!==true){
    $errorText.="<li>The URL link is $result";
  }

  if ($errorText==""){
    $news=new News($heading, $description, $link, $live, date("U"));
    
    if ($_SESSION["modify"]["stage"]==2){
      $obj=$_SESSION["modify"]["object"];
      $news->newsId=$obj->newsId;
    }
    unset($_SESSION["modify"]);
    
    $news->Save();
    $errorText="<P><B>News has successfully been saved</b></p>";
    unset($_POST);
  } else {
    $errorText="<ul>".$errorText."</ul>";
  }

}
require("top.php");
?>
<form action="admin_news_create.php" method="POST">
<input type=hidden name="create" value="1">

<table id="table_create">

  <TR>
    <TD colspan=2 id="cell_error_text">
    <?php
      echo $errorText;
    ?>
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
      Description:
    </td>
    <TD>
      <textarea name="description" id="description" ><?php
        echo $description;
      ?></textarea>
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