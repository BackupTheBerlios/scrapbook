<?php
	require("common_all.php");
  require("class.email.php");

if (isset($_POST["register"])){
  
  $db=new DatabaseConnection();
  
  $errorText="";
  $first_name=$_POST["firstName"];
  $last_name=$_POST["lastName"];
  $email=$_POST["email"];
  $password=$_POST["password"];
  $showAddress=$_POST["showAddress"];
  $role=$_POST["role"];
  
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
  
    if (($result=validate($postcode,"",20))!==true)
      $errorText.="<LI>Your post code is $result";
  
    if (($result=validate($telephone,"phonenumber",45))!==true)
      $errorText.="<LI>Your telephone number is $result";
  
    if ($fax!="" && ($result=validate($fax,"phonenumber",45))!==true)
      $errorText.="<LI>Your fax number is $result";

  }

  if (($result=validate($password,"password",45, 6))!==true)
    $errorText.="<LI>Your password is $result";

  if ($_POST["readTerms"]!="on"){
    $errorText.="<LI>Please read the terms and then tick the box to proceed";
  }
  
  if ($errorText==""){
    $query=$db->Query("SELECT * FROM onlineuser WHERE email='".$db->Escape($email)."' LIMIT 1");
    if ($db->Rows()>0){
      $errorText.="<LI>The email address you have entered is taken";
    } else {
      $user=new OnlineUser($email, $first_name, $last_name, $password, '', '', '', '', '', '', 'temp');
      $userId=$user->Save();
	    $user=$user->Get($userId);
	    $created=strtotime($user->dt_created);
      
      $mail=new Emailer();
      $mail->setTo($email);
      $mail->setFrom($configuration["fromEmail"]);
      $mail->setSubject("Fastfoodjobsuk Registration");      

      $url="http://www.fastfoodjobsuk.co.uk/register_activate.php?email=$email&code=$created";
      
      $mail->bodyAdd("Dear $first_name $last_name");
      $mail->bodyAdd("");
      $mail->bodyAdd("Thank you for registering with Fast Food Jobs but as we take your privacy seriously, we just wanted to check you did register with our site. In order to gain access to all of the web site functionality please click on this link:");
	  $mail->bodyAdd($url);
      $mail->bodyAdd("");
      $mail->bodyAdd("If you should not have received this e-mail, please click on the e-mail link below and just put \"remove\" in the heading and we will remove your details from our system.");
      $mail->bodyAdd("");
      $mail->bodyAdd("Regards,");
      $mail->bodyAdd("");
      $mail->bodyAdd("The Fast Food Jobs Team");
      $mail->bodyAdd("");
      $mail->bodyAdd("Tel: 0845 644 8252");
      $mail->bodyAdd("info@fastfoodjobsuk.co.uk");
      
      $mail->send();
      
      $adminMail=new Emailer();
      $adminMail->setTo($configuration["adminEmail"]);
      $adminMail->setFrom($configuration["fromEmail"]);
      $adminMail->setSubject("New Sign up");
      
      $adminMail->bodyAdd("Dear admin,");
      $adminMail->bodyAdd("Just to let you know that new member");
      $adminMail->bodyAdd("Name: ".$first_name." ".$last_name);
      $adminMail->bodyAdd("Emai: $email");
      $adminMail->bodyAdd("Role: $role");
      $adminMail->bodyAdd("has just joined Fast Foods.");
      
      $adminMail->send();
      
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
      <td>
       <span class="redbar">| </span><span class="heading">Registration</span> <span class="redbar">|</span><br>
<br>
      </td>
    </tr>
    <tr>
      <td colspan=2>
      <?php
        echo $errorText;
      ?>
      </td>
    </tr>
    <tr>
      <td>
        First Name:
      </td>
      <td>
        <input type="text" name="firstName" value="<?php echo (isset($_POST["firstName"]) ? $_POST["firstName"] : ""); ?>">
      </td>
    </tr>
    <tr>
      <td>
        Last Name:
      </td>
      <td>
        <input type="text" name="lastName" value="<?php echo (isset($_POST["lastName"]) ? $_POST["lastName"] : ""); ?>">
      </td>
    </tr>
    <tr>
      <td>
        Email Address:
      </td>
      <td>
        <input type="text" name="email" value="<?php echo (isset($_POST["email"]) ? $_POST["email"] : ""); ?>">
      </td>
    </tr>
    <?php
      if ($showAddress==1){
      ?>
        <tr>
          <td>
            Address 1:
          </td>
          <td>
            <input type="text" name="address1" value="<?php echo (isset($_POST["address1"]) ? $_POST["address1"] : ""); ?>">
          </td>
        </tr>
        <tr>
          <td>
            Address 2:
          </td>
          <td>
            <input type="text" name="address2" value="<?php echo (isset($_POST["address2"]) ? $_POST["address2"] : ""); ?>">
          </td>
        </tr>
        <tr>
          <td>
            Address 3:
          </td>
          <td>
            <input type="text" name="address3" value="<?php echo (isset($_POST["address3"]) ? $_POST["address3"] : ""); ?>">
          </td>
        </tr>
        <tr>
          <td>
            Post Code:
          </td>
          <td>
            <input type="text" name="postcode" value="<?php echo (isset($_POST["postCode"]) ? $_POST["postCode"] : ""); ?>">
          </td>
        </tr>
        <tr>
          <td>
            Telephone:
          </td>
          <td>
            <input type="text" name="telephone" value="<?php echo (isset($_POST["telephone"]) ? $_POST["telephone"] : ""); ?>">
          </td>
        </tr>
        <tr>
          <td>
            Facsimile:
          </td>
          <td>
            <input type="text" name="fax" value="<?php echo (isset($_POST["fax"]) ? $_POST["fax"] : ""); ?>">
          </td>
        </tr>
      <?php
      }
    ?>
    <tr>
      <td>
        Password:
            <br />
            (minimum length 6)</td>
      <td>
        <input type="password" name="password" value="">
      </td>
    </tr>
    <tr>
      <td>
        What is your role?
      </td>
      <td>
        <select name="role">
          <option value="Job Seeker">Job Seeker</option>
          <option value="Supplier">Supplier</option>
          <option value="Franchisor">Franchisor</option>
          <option value="Recruiter">Recruiter</option>
          <option value="Other">Other</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        I have read the <a href="terms.html" style="color:#0000FF">terms</a>
      </td>
      <td>
        <input type="checkbox" name="readTerms">
      </td>
    </tr>
    <tr>
      <td>
      </td>
      <td>
        <input type="submit" value="Submit">
      </td>
    </tr>
  </table>
</form>
<?php
	require("bottom.php");
?>
