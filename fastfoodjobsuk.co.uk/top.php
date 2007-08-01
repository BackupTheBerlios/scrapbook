<?php
  function loadImage(){
    global $imagePos, $platinumImages, $logoWidth, $logoHeight;
  	if ($platinumImages[$imagePos][0]>0)
  	{
      	echo "<a href=\"platinum.php?id=".$platinumImages[$imagePos][0]."\">";
      	echo "<img src=\"logos/".$platinumImages[$imagePos][1]."\" width='153' height='104' border='0' class='platinumImages'></a>";
  		$imagePos++;
  	}
  	else
  	{
  		echo "<a href=\"advertise.php\">";
      	echo "<img src='logos/your_company_here.gif' width='153' height='104' border='0' class='platinumImages'></a>";
  	}
    
  }

  if (isset($_GET["redir"])){
    $_SESSION["redir"]=$_GET["redir"];
    header("Location: index.php");
    exit;
  }
  
  $platinumImages=array(6);
  $db=new DatabaseConnection();
  $result=$db->Query("SELECT platinum_membershipId,logo
                      FROM platinum_membership
                      WHERE platinum_membership_status='active'
                            AND dt_expire>'".date("Y-m-d")."'
                      ORDER BY RAND() LIMIT 6");
  $rows=$db->Rows();
  for ($i=0;$i<$rows;$i++){
    $qr=mysql_fetch_row($result);
    $platinumImages[$i]=$qr;
  }
  $imagePos=0;
  
  for ($i=0;$i<count($platinumImages);$i++){
	updateImpressions("platinum_membership",$platinumImages[$i][0]);
  }

  $loginEmail=showLoggedInAs();  
  
  //default
  $button1="homebuttonIff_04";
  $button2="homebuttonIff_05";
  $button3="homebuttonIff_06";
  $button4="homebuttonIff_07";
  $button5="homebuttonIff_08";
  $button6="homebuttonIff_09";
  $button7="homebuttonIff_10";
  $button8="homebuttonIff_11";

  switch ($section) {
    case "1":
      $button1="homebuttOn_04";
      break;
    case "2":
      $button2="homebuttOn_05";
      break;
    case "3":
      $button3="homebuttOn_06";
      break;
    case "4":
      $button4="homebuttOn_07";
      break;
    case "5":
      $button5="homebuttOn_08";
      break;
    case "6":
      $button6="homebuttOn_09";
      break;
    case "7":
      $button7="homebuttOn_10";
      break;
    case "8":
      $button8="homebuttOn_11";
      break;	  	  	  
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1" />
		<title>Fastfoodjobsuk.co.uk</title>
		<link rel="stylesheet" href="css/basic.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="css/default.css" type="text/css" media="all"/>
	<csscriptdict import>
		<script type="text/javascript" src="scripts/CSScriptLib.js"></script>
	</csscriptdict>
	<csactiondict>
		<script type="text/javascript">
		<!--
			var preloadFlag = false;
			function preloadImages() {
				if (document.images) {
					over_homebuttonIff_04 = newImage(/*URL*/'images/homebuttOn_04.gif');
					over_homebuttonIff_05 = newImage(/*URL*/'images/homebuttOn_05.gif');
					over_homebuttonIff_06 = newImage(/*URL*/'images/homebuttOn_06.gif');
					over_homebuttonIff_07 = newImage(/*URL*/'images/homebuttOn_07.gif');
					over_homebuttonIff_08 = newImage(/*URL*/'images/homebuttOn_08.gif');
					over_homebuttonIff_09 = newImage(/*URL*/'images/homebuttOn_09.gif');
					over_homebuttonIff_10 = newImage(/*URL*/'images/homebuttOn_10.gif');
					over_homebuttonIff_11 = newImage(/*URL*/'images/homebuttOn_11.gif');
					preloadFlag = true;
				}
			}
		// -->
		</script>
	</csactiondict>
	<style type="text/css">
		.scroll {
		margin-top:0px;
		HEIGHT: 540px;
		WIDTH: 100%;
		overflow: auto;
		POSITION: relative;
		}
	
	</style>

	</head>
	<body onload="preloadImages();">
		<div align="center">
			<table width="816" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                <td background="images/page_07.gif"><img src="images/page_07.gif" alt="" width="11" height="685" border="0" /></td>
                <td valign="top" bgcolor="#ffffff" width="797"><table width="797" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td background = "images/home_02.gif" width="797" height="98" style="padding-right:20px;"><div class="login">
 <div id = "alignright">

  <div id="adminLogoutContainer">

  <?php

    if ($loginEmail!==false){
		 if (isSuperUser(false)){
		  echo "<a href=\"admin_account.php\" class=\"adminlogout\">Super Admin &gt;</a>&nbsp;&nbsp;";
		  echo "<a href=\"account.php\" class=\"adminlogout\">Customer Admin &gt;</a>&nbsp;&nbsp;";
		} else {
		  echo "<a href=\"account.php\" class=\"adminlogout\">Advertiser Admin &gt;</a>&nbsp;&nbsp;";
		  echo "<a href=\"account.php\" class=\"adminlogout\">Jobseeker Admin &gt;</a>&nbsp;&nbsp;";
		}	

      echo "<a href=\"logout.php\" class=\"adminlogout\">Logout &gt;</a><br/><br/><br/><br/>";
	  
    } else {
      ?>
        <a href="login.php" class="adminlogout">Advertiser Login</a>&nbsp;&nbsp;
		<a href="login.php" class="adminlogout">Jobseeker Login</a>&nbsp;&nbsp;
        </div>
        <!--
        <form name="form1" method="post" action="login.php" style = "margin-top:3px;margin-bottom:3px;">
          <input type=hidden name="redirect" value="<?php echo $_SERVER["PHP_SELF"]; ?>">
          <table border="0" align="right" cellpadding="0" cellspacing="0">
            <tr>
              <td><input type="text" name="email" id="inputlogin" value = "your email address" onfocus="if(this.value=='your email address')this.value='';" /></td>
            </tr>  
    
            <tr>
              <td>
                <table border="0" cellspacing="0" cellpadding="0" width="120">
                  <tr>
                    <td width = "92" height = "14px"><input type="password" name="password" id="inputloginpassword" value = "password" onfocus="this.value='';" /></td>
                    <td><input src = "images/go.jpg" name="gobutton"  type ="image" value="GO" style = "margin-top:1px; margin-left:2px;" /></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </form>
		-->
      <?php
          }
      ?>
      <div id="loginLine"><?php
          if ($loginEmail !== false){
            echo "You are logged in as <strong>&lt;".$loginEmail."&gt;</strong>";
          } else {
            echo "You are not logged in";
          }
        ?></div>
      </div>
</div></td>
                    </tr>
                  </table>
                    <table width="686" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td><a onmouseover="changeImages( /*CMP*/'homebuttonIff_04',/*URL*/'images/homebuttOn_04.gif');return true" onmouseout="changeImages( /*CMP*/'homebuttonIff_04',/*URL*/'images/homebuttonIff_04.gif');return true" href="index.php"><img src="images/<?php echo $button1; ?>.gif" alt="" name="<?php echo $button1; ?>" width="68" height="33" border="0" id="<?php echo $button1; ?>" /></a></td>
                        <td><a onmouseover="changeImages( /*CMP*/'homebuttonIff_05',/*URL*/'images/homebuttOn_05.gif');return true" onmouseout="changeImages( /*CMP*/'homebuttonIff_05',/*URL*/'images/homebuttonIff_05.gif');return true" href="news.php"><img src="images/<?php echo $button2; ?>.gif" alt="" name="<?php echo $button2; ?>" width="45" height="33" border="0" id="<?php echo $button2; ?>" /></a></td>
                        <td><a onmouseover="changeImages( /*CMP*/'homebuttonIff_06',/*URL*/'images/homebuttOn_06.gif');return true" onmouseout="changeImages( /*CMP*/'homebuttonIff_06',/*URL*/'images/homebuttonIff_06.gif');return true" href="aboutus.php"><img src="images/<?php echo $button3; ?>.gif" alt="" name="<?php echo $button3; ?>" width="59" height="33" border="0" id="<?php echo $button3; ?>" /></a></td>
                        <td><a onmouseover="changeImages( /*CMP*/'homebuttonIff_07',/*URL*/'images/homebuttOn_07.gif');return true" onmouseout="changeImages( /*CMP*/'homebuttonIff_07',/*URL*/'images/homebuttonIff_07.gif');return true" href="gold.php"><img src="images/<?php echo $button4; ?>.gif" alt="" name="<?php echo $button4; ?>" width="85" height="33" border="0" id="<?php echo $button4; ?>" /></a></td>
                        <td><a onmouseover="changeImages( /*CMP*/'homebuttonIff_08',/*URL*/'images/homebuttOn_08.gif');return true" onmouseout="changeImages( /*CMP*/'homebuttonIff_08',/*URL*/'images/homebuttonIff_08.gif');return true" href="franchises.php"><img src="images/<?php echo $button5; ?>.gif" alt="" name="<?php echo $button5; ?>" width="115" height="33" border="0" id="<?php echo $button5; ?>" /></a></td>
                        <td><a onmouseover="changeImages( /*CMP*/'homebuttonIff_09',/*URL*/'images/homebuttOn_09.gif');return true" onmouseout="changeImages( /*CMP*/'homebuttonIff_09',/*URL*/'images/homebuttonIff_09.gif');return true" href="restaurants.php"><img src="images/<?php echo $button6; ?>.gif" alt="" name="<?php echo $button6; ?>" width="75" height="33" border="0" id="<?php echo $button6; ?>" /></a></td>
                        <td><a onmouseover="changeImages( /*CMP*/'homebuttonIff_10',/*URL*/'images/homebuttOn_10.gif');return true" onmouseout="changeImages( /*CMP*/'homebuttonIff_10',/*URL*/'images/homebuttonIff_10.gif');return true" href="suppliers.php"><img src="images/<?php echo $button7; ?>.gif" alt="" name="<?php echo $button7; ?>" width="64" height="33" border="0" id="<?php echo $button7; ?>" /></a></td>
                        <td><a onmouseover="changeImages( /*CMP*/'homebuttonIff_11',/*URL*/'images/homebuttOn_11.gif');return true" onmouseout="changeImages( /*CMP*/'homebuttonIff_11',/*URL*/'images/homebuttonIff_11.gif');return true" href="contact.php"><img src="images/<?php echo $button8; ?>.gif" alt="" name="<?php echo $button8; ?>" width="59" height="33" border="0" id="<?php echo $button8; ?>" /></a></td>
                        <td><img src="images/homebuttonIff_12.gif" alt="" width="66" height="33" border="0" /></td>
                        <td><a href="advertise.php"><img src="images/homebuttonIff_13.gif" alt="" width="161" height="33" border="0" /></a></td>
                      </tr>
                      <tr>
                        <td colspan="10"><img src="images/spacer.gif" alt="" width="1" height="11" border="0" /></td>
                      </tr>
                    </table>
                    <table width="796" border="0" cellspacing="0" cellpadding="0">
					<?php if (!$wide){ ?>
                      <tr>
                        <td valign="top" width="167"><table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td height="116"><?php loadImage();?></td>
                            </tr>
                            <tr>
                              <td height="116"><?php loadImage();?></td>
                            </tr>
                            <tr>
                              <td height="116"><?php loadImage();?></td>
                            </tr>
							
                            <tr>
                              <td width="167"><a href="FranchiseeoftheYear.pdf" target="_blank"><img src="images/wingleft_19.gif" alt="" width="167" height="192" border="0" /></a></td>
                            </tr>							
                        </table></td>
                        <td valign="top" width="463">
						<!--content starts-->
							<?php
							  if (!isset($noScroll)){
								echo "<div id=\"content\" class=\"scroll\">";
							  }
							?>
						<?php } else { // non-wide mode?>
						<tr>
                        <td valign="top" width="650" class = "paddingforinfocell">
						<!--content starts-->
						<?php } ?>
						<!--<p style="margin-top: 0; margin-bottom: 0">&nbsp;<strong><?php echo $_GET['msg']; ?></strong></p>-->
