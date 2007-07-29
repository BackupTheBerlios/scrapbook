<?php
	require("common_all.php");

if (isset($_POST["reset"])){
  $db=new DatabaseConnection();
  
  $email=$db->Escape($_POST["email"]);
  
  $password="";
  for($i=1;$i<=6;$i++){
    $password.=chr(mt_rand(97,122)).chr(mt_rand(65,90));
  }
  
  $db->Query("UPDATE onlineuser SET pass_word=PASSWORD('$password') WHERE email='$email'");
  $db->Query("SELECT first_name, last_name FROM onlineuser WHERE email='$email'");
  if ($db->Rows()>0){
    $fname=$db->Result(0,"first_name");
    $lname=$db->Result(0,"last_name");

    $headers="From: noreply@fastfoodjobsuk.co.uk\r\n";
    $headers.="X-Mailer: CJS_MailSystem\r\n";
    $headers.= "MIME-Version: 1.0\r\n";
    $headers.= "Content-type: text/html; charset=iso-8859-1\r\n";
    
    $message="<HTML><pre>";
    $message.="Dear $fname $lname\n\n";
    $message.="You password is: $password and if you need any further help please e-mail\n";
    $message.="support@fastfoodjobsuk.co.uk\n\n";
	$message.="Regards,\n\n";
    $message.="The Fast Food Jobs Support Team.";
    $message.="</pre></html>";
    
    mail($email, "Fastfoodjobsuk Password Reset", $message, $headers);
  }
  
  header("Location: forgotten_password_success.php");
  exit;
  
}

?>
<?php
	require("top.php");
?>
<form action="forgotten_password.php" method="POST" style = "margin:0px;">
 <table width="459" border="0" cellspacing="0" cellpadding="0" >
  <tr>
   <td><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /></td>
  </tr>
  <tr>
   <td><div class="roundcont">
     <div class="roundtop"> <img class="corner" src="images/bl_01.gif" alt="edge" style=" display: none;" /></div>
    <h1> Forgotten Password </h1>
    <div class="roundbottom"> <img src="images/bl_06.gif" alt="edge" class="corner" style=" display: none;" /></div>
   </div></td>
  </tr>
 </table>
 <table border="0" cellspacing="0" cellpadding="0">
  <tr>
   <td valign="top" width="455"><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /> </td>
  </tr>
  <tr>
   <td valign="top" width="455"><p style = "padding-left:5px; margin:0px;">Please enter your registered e-mail address and we will send you an email with a new password.<br />
   </p>
     <br /></td>
  </tr>
  <tr>
   <td></td>
  </tr>
 </table>
 <br>
<table class = "uploadform">
<tr>
 <td><br />
  Email Address:</td>
</tr><tr>
<td>  <input class = "detail" type="text" name="email">
 </td></tr><tr>
 <td> <input type="submit" value="Reset Password"></td></tr></table>


</p>

</form>
<?php
	require("bottom.php");
?>