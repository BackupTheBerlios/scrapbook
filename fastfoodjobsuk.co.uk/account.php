<?php
require("common_user.php");
// if this is set, then the admin_xxxx_create pages display a cancel button. When clicked
// the user is taken back to the page specified below
$_SESSION["cancel"]="account.php";


if(isset($_POST["whichUser"]) && isSuperUser(false)){
  $user=$user->Get((int)$_POST["whichUser"]);
  $_SESSION["onlineuser"]=$user;
}
//if($user->isSuperAdmin())
//{  
  //header("Location: admin_account.php");
  //exit;
//}
require("top_wide.php");
?>
<script language="JavaScript">
function sure(classname,id){
  if (confirm("Are you sure you wish to delete this record?")){
    window.location='delete.php?type='+classname+'&id='+id;
  }
}
</script>
<style type="text/css" media="screen">
<!--
a { color: #0083cc; font-size: 10px; font-family: Verdana, Arial, Helvetica, SunSans-Regular; text-decoration: none }
a:hover { color: #0083cc; font-size: 10px; font-family: Verdana, Arial, Helvetica, SunSans-Regular; text-decoration: underline }
#wrapper table { width:740px;}
#wrapper td {padding:5px;}
-->
</style>
<div id = "wrapper">
 <table id="table" class = "uploadformadmin">
  <tr>
   <td colspan="2"><h3 style = "margin-top:5px; margin-bottom:0px;">User Administration </h3></td>
  </tr>
  <tr>
   <td colspan="2"  class = "line" >&nbsp;</td>
  </tr><tr>
   <td colspan="2"><p>
  <a href="user_profile.php" class = "newslarge">My Profile</a>
</p><p>
  <a class = "newslarge" href="change_password.php" >Update Password</a></p>
		
		<?php
  if (isSuperUser(false)){
    echo "<p>";
    echo "<a class = \"newslarge\" href=\"delete_user.php?id=".$user->onlineuserId."\" >Delete User</a>";
    echo "</p>";
  }
  ?>
<p>
 <?php	
 $cvid=$user->getCVId();
 if ( $cvid > 0 ) {
 ?>
 <a href="cvedit.php" class = "newslarge">Update Job Seeker Profile</a>
 <?php } else { ?>
 <a href="cv_form.php" class = "newslarge">Create Job Seeker Profile</a>
 <?php } ?>
  </p>
 <?php
if ($user->canSearchCV(false))
{
?>

<p>
  <a href="cv_search.php" class = "newslarge">Search Job Seekers Profile</a></p>
<?php
}
?></td>
  </tr>
  <tr>
   <td class = "line" colspan="2">&nbsp;</td>
  </tr>
  
  
  <tr>
   <td colspan="2"></td>
  </tr>
  <tr>
   <td colspan="2">
   <?php
   generateJobLink($user);
			?>			</td>
  </tr>
  <tr>
   <td></td>
   <td></td>
  </tr>
  <tr>
   <td colspan="2" valign="top" class = "line">&nbsp;</td>
  </tr>
  <tr>
   <td colspan="2" valign="top"><?php
generate("Gold Advert",$user,new Gold_membership());		
?></td>
  </tr>
  <tr>
   <td></td>
   <td></td>
  </tr>
  <tr>
   <td class = "line" colspan="2">&nbsp;</td>
  </tr>
  <tr>
   <td colspan="2"></td>
  </tr>
  <tr>
  <td colspan="2"><?php
generate("Platinum Advert",$user,new Platinum_membership());
?>  </tr>
  <tr>
   <td colspan="2"></td>
  </tr>
  <tr>
   <td colspan="2" class = "line">&nbsp;</td>
  </tr>
  <tr>
   <td colspan="2"></td>
  </tr>
  <tr>
   <td colspan="2" class = "line"><?php
generate("Supplier",$user,new Supplier());
?></td>
  </tr>
  <tr>
   <td colspan="2"></td>
  </tr>
  <tr>
   <td colspan="2">&nbsp;</td>
  </tr>
 </table>
</div>
<table class="paddingforinfocell"><tr><td>




</td></tr></table>


<?php
function generateJobLink($user){
  global $truncateText;
  

  $db=new DatabaseConnection();
  $result=$db->Query("SELECT * FROM job where onlineuser_onlineuserid=$user->onlineuserId ORDER BY dt_created DESC");

  $rows=$db->Rows();  
       $alt=false;
	 $rowclass="";
  if ($rows > 0||isSuperUser(false))
  {

	 echo "<br/>";
     echo "Job Admin";

    echo "  - <a href='job_post.php'>create new</a>";

	echo "<div class=\"spacer\"></div>";
	 echo "<table class=\"table\">";  	 
	if ($rows == 0)
	{
			 if (isSuperUser(false))
			{
				echo "<tr><td>";
				echo "currently have no entries";
				echo "</td></tr>";
			}
	
	}else{
	 echo "<TR><TD>Position</td><TD>Description</td><TD>Salary</td><TD>Location</td><TD>Company</td><TD>Created</td><TD>Expires</td><TD>Status</td><TD><!-- Functions --></td></tr>";
	 
	 	for ($i=0;$i<$rows;$i++){
			$row=mysql_fetch_assoc($result);
			  if ($alt){
				$rowclass="row_even";
			  } else {
				$rowclass="row_odd";
			  }
			  $alt=!$alt;
		  
			  echo "<tr>";
			  echo "<td class=\"$rowclass\">".$row["position"]."</td>";
				echo "<td class=\"$rowclass\">".substr($row["profile"],0,$truncateText)."...</td>";
				echo "<td class=\"$rowclass\">£".$row["salary"]."</td>";
				echo "<td class=\"$rowclass\">".$row["location"]."</td>";
				echo "<td class=\"$rowclass\">".$row["company"]."</td>";
			  echo "<td class=\"$rowclass\">".FormatDateTime($row["dt_created"],7)."</td>";
			  echo "<td class=\"$rowclass\">".FormatDateTime($row["dt_expire"],7)."</td>";
			  
			  
			  
				$jobid=$row["jobid"];
				if ($row["job_status"]!="temp" && $row["dt_expire"]<=date("Y-m-d")){
				      echo "<td class=\"$rowclass\">Expired</td><td class=\"$rowclass\"><ul>";                              
        			echo "<li><a href=\"renew.php?type=Job&id=".$jobid."\">Renew</a></li>";
  	    } else {
				      switch ($row["job_status"]){
      					case "temp":
      						  echo "<td class=\"$rowclass\">Temporary</td><td class=\"$rowclass\"><ul>";	
      						  echo "<li><a href='activate.php?type=Job&id=$jobid'>Activate</a></li>";
      					break;				  
      					case "active":
      						echo "<td class=\"$rowclass\">Active</td><td class=\"$rowclass\"><ul>";
      						if (isSuperUser(false))
      					  		echo "<li><a href='deactivate.php?type=Job&id=$jobid'>Pause</a></li>";
      					  	break;
      					case "disabled":
      						echo "<td class=\"$rowclass\">Paused</td><td class=\"$rowclass\"><ul>";
      					  	if (isSuperUser(false))	
      					  		echo "<li><a href='activate.php?type=Job&id=$jobid'>Continue</a></li>";			
				      }	
		
			  }			  
			  echo "<li><a href='jobedit.php?jobid=$jobid'>Modify</a></li>";
			  //echo "<li><a href='jobview.php?jobid=$jobid'  target='_blank'>View</a></li>";		
			 if ( isSuperUser(false) ){
				echo "<li><a href='#' onClick=\"sure('Job','$jobid')\">Delete</a></li>";
			  }				  
  
			   echo "</ul>";
     		 echo "</td>";
			  echo "</tr>";
		}
	}	
  	echo "</table>";
  	echo "<br/>";
  	echo "<br/>";

  }
}

require("bottom_wide.php");
?>
