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
<input type=hidden name="reset" value="1">
      <span class="redbar">| </span><span class="heading">Password Retrieval</span> <span class="redbar">|</span><br>
<br>
<table class = "registerTable">
<tr>
 <td>
Please enter your registered e-mail address and we will send you an email with a new password.<br /><br /></td>
</tr><tr>
<td>  <input type="text" name="email">
 </td></tr><tr>
 <td> <input type="submit" value="Reset Password"></td></tr></table>


</p>

</form>
<?php
	require("bottom.php");
?>