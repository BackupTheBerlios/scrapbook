<?php
require("common_all.php");

if (isset($_POST["email"])){
  
  $db=new DatabaseConnection();
  $results=$db->Query("SELECT * FROM onlineuser WHERE email='".$db->Escape($_POST["email"])."' AND pass_word=PASSWORD('".$db->Escape($_POST["password"])."')");
  
  if ($db->Rows() != null){
    
    $user=new OnlineUser();

    $user=$user->populate($db);
    
    // are they active?
    $status=$user->user_status;
    switch ($status){
      case "temp":
        header("Location: register_activate.php");
        exit;
        break;
      case "disabled":
        header("Location: logout.php");
        exit;
        break;		
    }
    
    $_SESSION["onlineuser"]=$user;

    //proceed to loged in page
    if (isset($_SESSION["redirect"]) || isset($_POST["redirect"])){
      $url=(isset($_SESSION["redirect"]) ? $_SESSION["redirect"] : $_POST["redirect"]);
      unset($_SESSION["redirect"]);
      header("Location: $url");
      exit;
    } else {
    	if (isSuperUser(false)){
        header("Location: admin_account.php");
    	} else {
        header("Location: index.php");
      }
    	exit;
	 }
    
  } else {
    $errorText="<P><B>Error logging in</b></p><P>Either the email address or password is incorrect</p>";
  }
} else if (isset($_SESSION["onlineuser"])){
  
  if (isSuperUser(false)){
    header("Location: admin_account.php");
  } else {
    header("Location: account.php");
  }
  
}

require("top.php");

?>
<table border="0" cellspacing="0" cellpadding="0" class = "loginTable">
  <tr>
    <td valign="top">
      <img src="images/spacer.gif" alt="" width="1" height="8" border="0">
    </td>
  </tr>
  <tr>
    <td style = "height:20px" valign="top">
      <a class="contact" href="javascript:history.go(-1);">&laquo; back</a>
    </td>
  </tr>
  <tr>
    <td>
      <?php
        echo "<span class = \"error\"> $errorText </span>"
      ?>
    </td>
  </tr>
  <tr>
    <td>
      
      <form action="login.php" method="POST">
        <table>
          <tr>
            <td>
              Email address:
            </td>
            <td>
              <?php
                echo "<input type=\"text\" name=\"email\" value=\"".(isset($_POST["email"]) ? $_POST["email"] : "")."\">";
              ?>
            </td>
          </tr>
          
          <tr>
            <td>
              Password:
            </td>
            <td>
              <input type="password" name="password">
            </td>
          </tr>
  
          <tr>
            <td>
            </td>
            <td>
              <input type="submit" value="Login">
            </td>
          </tr>
        </table>
      </form>

      <p>
        Not registered? <a href="register.php" class="news">Register here</a>
      </p>
      <p>
        Forgotten your password? <a href="forgotten_password.php" class="news">Click here</a>
</p>
      <p>&nbsp;      </p>
    </td>
  </tr>
  <tr>
    <td>
      <!--
      <img src="images/mid_222.gif" alt="" width="463" height="192" usemap="#mid_222c28396bb" border="0"><map name="mid_222c28396bb"><area shape="rect" coords="339,137,441,187" href="http://www.lanbury.com/" alt="" target="_blank"><area shape="rect" coords="231,132,328,184" href="http://www.thebfa.org/" alt="" target="_blank"><area shape="rect" coords="125,132,214,187" href="http://www.rbs.co.uk/Small_Business/Specialist_Sectors/Franchising" alt="" target="_blank"><area shape="rect" coords="21,130,113,182" href="http://www.thomaseggar.com/" alt="" target="_blank"></map>
      -->
    </td>
  </tr>
</table>
<?php
require("bottom.php");
?>
