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

  if(($result=validate($heading,"words",4))!==true){
    $errorText.="<li>The heading is $result";
  }
  if (($result=validate($text,"words",10))!==true){
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
<table border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top" width="463"><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /> </td>
 </tr>
 <tr>
  <td valign="top" width="463"><span class="redbar">| </span><span class="heading">Classified Advert</span> <span class="redbar">|</span><br />
    <br />
 </tr>
 <tr>
  <td><hr noshade="noshade" size="1" />
  </td>
 </tr>
</table>
<form action="classified_form.php" method="POST">
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
      <input type="text" id="heading" name="heading" value="<?php echo $heading; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Text:
    </td>
    <td>
      <textarea name="text" id="text"><?php
        echo $text;
      ?></textarea>
    </td>
  </tr>
  <tr>
    <td>
      Link:
    </td>
    <td>
      <input type="text" id="link" name="link" value="<?php echo $link ; ?>">
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
