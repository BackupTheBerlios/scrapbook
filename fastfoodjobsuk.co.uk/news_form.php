<?php
require("common_super.php");
$errorText="";
$news=new News();
$id=intval($_GET["id"]);
if ($id==0){
	$id=intval($_POST["id"]);
}
if ($id>0){	
	$news=$news->Get($id);
	//check to see user has access to modify this object	
	//$user->canAccess($news);
} else { //new object
	//$news->onlineuser_onlineuserid = $user->onlineuserId;

	//default link
	$news->link="http://";

	$news->live=1;
}

//check if form is being submitted
if ((bool)$_POST["submitting"])
{
  $news->heading=$_POST["heading"];
  $news->description=$_POST["description"];
  $news->link=$_POST["link"];

  if(($result=validate($news->heading,"",255))!==true){
    $errorText.="<li>The news heading is $result";
  }
  if (($result=validate($news->description,"",5000))!==true){
    $errorText.="<li>The description is $result";
  }
  if (($result=validate($news->link,"",255))!==true){
    $errorText.="<li>The URL link is $result";
  }

  if ($errorText==""){
  
    $news->Save();
    //$errorText="<P><B>News has successfully been saved</b></p>";
    unset($_POST);
	header("Location: news_success.php");
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
  <td valign="top" width="463"><span class="redbar">| </span><span class="heading">News</span> <span class="redbar">|</span><br />
    <br />
    <p style = "padding-left:5px; margin:0px;">Please enter the heading of your news item, then a descriptive passage and the link to the file that YOU will provide on the server. Please supply the abosolute path and do not use the same name for a file twice or overwrite will occur.</p></td>
 </tr>
 <tr>
  <td><hr noshade="noshade" size="1" />
  </td>
 </tr>
</table>
<form action="news_form.php" method="POST">
<input type=hidden name="id" value="<?php echo $news->newsId; ?>">
<input type=hidden name="submitting" value="true">

<table id="table_create">

  <tr>
    <td colspan=2 id="cell_error_text">
    <?php
      echo $errorText;
    ?>
    </td>
  </tr>
  <tr>
    <td>
      Heading:
    </td>
    <td>
      <input type="text" id="heading" name="heading" value="<?php echo $news->heading; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Description:
    </td>
    <td>
      <textarea name="description" id="description" ><?php
        echo $news->description;
      ?></textarea>
    </td>
  </tr>
  <tr>
    <td>
      Link:
    </td>
    <td>
      <input type="text" id="link" name="link" value="<?php echo $news->link ; ?>">
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