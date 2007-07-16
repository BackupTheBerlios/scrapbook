<?php
	require("common_all.php");


if (isset($_POST["register"])){
  
  $db=new DatabaseConnection();
  
  $errorText="";
  $first_name=$_POST["firstName"];
  $last_name=$_POST["lastName"];
  $email=$_POST["email"];
  $password=$_POST["password"];
  $showAddress=$_POST["showAddress"];
  
  if (($result=validate($first_name,"name",45))!==true)
    $errorText.="<LI>Your first name is $result";

  if (($result=validate($last_name,"name",45))!==true)
    $errorText.="<LI>Your last name is $result";
    
  if (($result=validate($email,"email",45))!==true)
    $errorText.="<LI>Your email address is $result";

  if ($showAddress==1){
    $address1=$_POST["address1"];
    $address2=$_POST["address2"];
    $address3=$_POST["address3"];
    $postcode=$_POST["postcode"];
    $telephone=$_POST["telephone"];
    $fax=$_POST["fax"];
    
    if (($result=validate($address1,"",255))!==true)
      $errorText.="<LI>The first line of your address is $result";
  
    if (($result=validate($address2,"",255))!==true)
      $errorText.="<LI>The second line of your address is $result";
  
    if (($result=validate($address3,"",255))!==true)
      $errorText.="<LI>The third line of your address is $result";
  
    if (($result=validate($postcode,"",20))!==true)
      $errorText.="<LI>Your post code is $result";
  
    if (($result=validate($telephone,"phonenumber",45))!==true)
      $errorText.="<LI>Your telephone number is $result";
  
    if ($fax!="" && ($result=validate($fax,"phonenumber",45))!==true)
      $errorText.="<LI>Your fax number is $result";

  }

  if (($result=validate($password,"password",45))!==true)
    $errorText.="<LI>Your password is $result";

  if ($_POST["readTerms"]!="on"){
    $errorText.="<LI>Please read the terms and then tick the box to proceed";
  }
  
  if ($errorText==""){
    $query=$db->Query("SELECT * FROM onlineuser WHERE email='".$db->Escape($email)."' LIMIT 1");
    if ($db->Rows()>0){
      $errorText.="<LI>The email address you have entered is taken";
    } else {
      $created=date("U");
      $user=new OnlineUser($email, $first_name, $last_name, $password, '', '', '', '', '', '', $created, 'temp');
      $user->Save();
      
      $headers="From: noreply@fastfoodjobsuk.co.uk\r\n";
      $headers.="X-Mailer: CJS_MailSystem\r\n";
      $headers.= "MIME-Version: 1.0\r\n";
      $headers.= "Content-type: text/html; charset=iso-8859-1\r\n";
      $url="http://www.fastfoodjobsuk.co.uk/register_activate.php?email=$email&code=$created";
      
      $message="<HTML><pre>";
      $message.="Dear $first_name $last_name\n\n";

      $message.="Thank you for registering with Fast Food Jobs but as we take your privacy seriously, ";
      $message.="we just wanted to check you did register with our site. ";
      $message.="In order to gain access to all of the web site functionality please click on ";
      $message.="<a href=\"$url\">this link</a>\n\n";

      $message.="If you should not have received this e-mail, please click on the e-mail link below ";
      $message.="and just put \"remove\" in the heading and we will remove your details from our system.\n\n";

      $message.="Regards,\n\n";

      $message.="The Fast Food Jobs Team\n\n";

      $message.="Tel: 0845 644 8252\n";
      $message.="info@fastfoodjobsuk.co.uk\n";

      /*
      $message.="If the link above does not work, please visit:\n";
      $message.="http://www.fastfoodjobsuk.co.uk/register_activate.php\n\n";
      $message.="And when prompted, please enter your email address and the code: $created";
      */
      
      $message.="</pre></html>";
      
      mail($email, "Fastfoodjobsuk Registration", $message, $headers);
      header("Location: register_thankyou.php");
      exit;
    }
  }
  
  $errorText="<ul>".$errorText."</ul>";
  
}
?>
<?php
	require("top.php");
?>

<form action="register.php" method="POST">
  <input type=hidden name="register" value="1">
  <input type=hidden name="showAddress" value="<?php
    if (isset($_GET["type"]) || $_POST["showAddress"]==1){
      $showAddress=1;
    } else {
      $showAddress=0;
    }
    echo $showAddress;
  ?>">
  <table class = "registerTable">
    <tr>
      <Td>
       <span class="redbar">| </span><span class="heading">Registration</span> <span class="redbar">|</span><br>
<br>
      </td>
    </tr>
    <TR>
      <TD colspan=2>
      <?php
        echo $errorText;
      ?>
      </td>
    </tr>
    <TR>
      <TD>
        First Name:
      </td>
      <TD>
        <input type="text" name="firstName" value="<?php echo (isset($_POST["firstName"]) ? $_POST["firstName"] : ""); ?>">
      </td>
    </tr>
    <TR>
      <TD>
        Last Name:
      </td>
      <TD>
        <input type="text" name="lastName" value="<?php echo (isset($_POST["lastName"]) ? $_POST["lastName"] : ""); ?>">
      </td>
    </tr>
    <TR>
      <TD>
        Email Address:
      </td>
      <TD>
        <input type="text" name="email" value="<?php echo (isset($_POST["email"]) ? $_POST["email"] : ""); ?>">
      </td>
    </tr>
    <?php
      if ($showAddress==1){
      ?>
        <TR>
          <TD>
            Address 1:
          </td>
          <TD>
            <input type="text" name="address1" value="<?php echo (isset($_POST["address1"]) ? $_POST["address1"] : ""); ?>">
          </td>
        </tr>
        <TR>
          <TD>
            Address 2:
          </td>
          <TD>
            <input type="text" name="address2" value="<?php echo (isset($_POST["address2"]) ? $_POST["address2"] : ""); ?>">
          </td>
        </tr>
        <TR>
          <TD>
            Address 3:
          </td>
          <TD>
            <input type="text" name="address3" value="<?php echo (isset($_POST["address3"]) ? $_POST["address3"] : ""); ?>">
          </td>
        </tr>
        <TR>
          <TD>
            Post Code:
          </td>
          <TD>
            <input type="text" name="postcode" value="<?php echo (isset($_POST["postCode"]) ? $_POST["postCode"] : ""); ?>">
          </td>
        </tr>
        <TR>
          <TD>
            Telephone:
          </td>
          <TD>
            <input type="text" name="telephone" value="<?php echo (isset($_POST["telephone"]) ? $_POST["telephone"] : ""); ?>">
          </td>
        </tr>
        <TR>
          <TD>
            Facsimile:
          </td>
          <TD>
            <input type="text" name="fax" value="<?php echo (isset($_POST["fax"]) ? $_POST["fax"] : ""); ?>">
          </td>
        </tr>
      <?php
      }
    ?>
    <TR>
      <TD>
        Password:
      </td>
      <TD>
        <input type="password" name="password" value="">
      </td>
    </tr>
    <!--
    <TR>
      <TD>
        I am a...
      </td>
      <TD>
        <input type="checkbox" name="password" value="">
      </td>
    </tr>
    -->
    <TR>
      <TD>
        I have read the <a href="terms.html" style="color:#0000FF">terms</a>
      </td>
      <TD>
        <input type="checkbox" name="readTerms">
      </td>
    </tr>
    <TR>
      <TD>
      </td>
      <TD>
        <input type="submit" value="Submit">
      </td>
    </tr>
  </table>
</form>
<?php
	require("bottom.php");
?>
