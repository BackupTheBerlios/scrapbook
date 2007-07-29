<?php
require("common_user.php");
require("class.email.php");

$errorText="";

//check if form is being submitted
if ((bool)$_POST["submitting"])
{
  $heading=$_POST["heading"];
  $text=$_POST["text"];
  $link=$_POST["link"];

  if(($result=validate($heading,"",20))!==true){
    $errorText.="<li>The heading is $result";
  }
  if (($result=validate($text,"",50))!==true){
    $errorText.="<li>The main text is $result";
  }
  if (($result=validate($link,"",255))!==true){
    $errorText.="<li>The URL link is $result";
  }

  if ($errorText==""){
    
    $mail=new Emailer();
    $mail->setTo($configuration["adminEmail"]);
    $mail->setFrom("classified@fastfoodjobsuk.co.uk");
    $mail->setSubject("Classified Advert");
    $mail->bodyAdd("NEW CLASSIFIED ADVERT");
    $mail->bodyAdd("");
    $mail->bodyAdd("User: ".$user->email);
    $mail->bodyAdd("Heading: $heading");
    $mail->bodyAdd("Text: $text");
    $mail->bodyAdd("URL: $link");
    $mail->bodyAdd("");
    $mail->bodyAdd("END");
    $mail->send();
    
  	header("Location: classified_success.php");
  } else {
    $errorText="<ul>".$errorText."</ul>";
  }

}
require("top.php");
?>
<table width="459" border="0" cellspacing="0" cellpadding="0" >
 <tr>
  <td><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /></td>
 </tr>
 <tr>
  <td><div class="roundcont">
   <div class="roundtop"> <img class="corner" src="images/bl_01.gif" alt="edge" style=" display: none;" /></div>
   <h1>Classified Advertisement</h1>
   <div class="roundbottom"> <img src="images/bl_06.gif" alt="edge" class="corner" style=" display: none;" /></div>
  </div></td>
 </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top" width="463"><img src="images/spacer.gif" alt="" width="1" height="5" border="0" /> </td>
 </tr>
 <tr>
  <td valign="top" width="463"><p style = "padding-left:5px; margin:0px;">Please send in your classified advertisement. Once received we will contact you with more information.</p>
    <br /></td>
 </tr>
 <tr>
  <td></td>
 </tr>
</table>
<form action="classified_form.php" method="POST">
<input type=hidden name="submitting" value="true">

<table id="table_create"  class = "uploadform" width = "95%">

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
      <input  class = "detail" type="text" id="heading" name="heading" value="<?php echo $heading; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Text:
    </td>
    <td>
      <textarea  class = "detail" name="text" id="text"><?php
        echo $text;
      ?></textarea>
    </td>
  </tr>
  <tr>
    <td>
      Link:
    </td>
    <td>
      <input  class = "detail" type="text" id="link" name="link" value="<?php echo $link ; ?>">
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
