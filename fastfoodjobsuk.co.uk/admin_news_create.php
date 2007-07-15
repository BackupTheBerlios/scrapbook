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
<link rel=stylesheet href="css/admin_create.css" type="text/css">
<link rel=stylesheet href="css/admin_news_create.css" type="text/css">
<table border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top" width="463"><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /> </td>
 </tr>
 <tr>
  <td valign="top" width="463"><span class="redbar">| </span><span class="heading">News</span> <span class="redbar">|</span><br />
    <br />
    <p style = "padding-left:5px; margin:0px;">Please enter the heading of your news item, then a descriptive passage and the link to the file that YOU will provide on the server. Please supply the abosolute path and do not use the same name for a file twice or overwrite will occur.</p></td>
 </tr>
 <tr>
  <td><hr noshade="noshade" size="1" />
  </td>
 </tr>
</table>
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