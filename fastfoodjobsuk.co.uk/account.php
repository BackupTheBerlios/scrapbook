<?php
require("common_user.php");
// if this is set, then the admin_xxxx_create pages display a cancel button. When clicked
// the user is taken back to the page specified below
$_SESSION["cancel"]="account.php";


if(isset($_POST["whichUser"]) && isSuperUser(false)){
  $user=$user->Get((int)$_POST["whichUser"]);
  $_SESSION["onlineuser"]=$user;
}
if($user->isSuperAdmin())
{  
  header("Location: admin_account.php");
  exit;
}
require("top_wide.php");
?>
<script language="JavaScript">
function sure(classname,id){
  if (confirm("Are you sure you wish to delete this record?")){
    window.location='delete.php?type='+classname+'&id='+id;
  }
}
</script>

<table class="paddingforinfocell"><tr><td>
<p>
  <a href="user_profile.php" style="color:#0000FF;text-decoration:underline">My Profile</a>
</p>
<p>
  <a href="change_password.php" style="color:#0000FF;text-decoration:underline">Update Password</a>
</p>

<?php
 $cvid=$user->getCVId();

 ?>
 <p>
 <a href="cvedit.php" style="color:#0000FF;text-decoration:underline">My CV</a>
 </p>
 <?php	
if ($user->canSearchCV(false))
{
?>

<p>
  <a href="cv_search.php" style="color:#0000FF;text-decoration:underline">Search CV</a>
</p>
<?php
}
?>
</td></tr></table>
<?php
generateJobLink($user);
generate("Gold Advert",$user,new Gold_membership());
generate("Platinum Advert",$user,new Platinum_membership());
generate("Supplier",$user,new Supplier());
?>

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
	if (isSuperUser(false))
	{
    	echo "  - <a href='job_post.php'>create new</a>";
	}	
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
				echo "<td class=\"$rowclass\">".$row["overview"]."</td>";
				echo "<td class=\"$rowclass\">".$row["salary"]."</td>";
				echo "<td class=\"$rowclass\">".$row["location"]."</td>";
				echo "<td class=\"$rowclass\">".$row["company"]."</td>";
			  echo "<td class=\"$rowclass\">".FormatDateTime($row["dt_created"],5)."</td>";
			  echo "<td class=\"$rowclass\">".FormatDateTime($row["dt_expire"],5)."</td>";
			  
			  
			  
				$jobid=$row["jobid"];
				if ($row["dt_expire"]!="0000-00-00" && $row["dt_expire"]<=date("Y-m-d")){
				      echo "<td class=\"$rowclass\">Expired</td><td class=\"$rowclass\"><ul>";                              
        			echo "<li><a href=\"renew.php?type=Job&id=".$jobid."\">Renew</a></li>";
  	    } else {
				      switch ($row["job_status"]){
      					case "temp":
      						  echo "<td class=\"$rowclass\">Temporary</td><td class=\"$rowclass\"><ul>";	
      						  echo "<li><a href=\"activate.php?type=$class&id=".$obj->$classId."\">Activate</a></li>";
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
			  echo "<li><a href='job_post.php?jobid=$jobid'>Modify</a></li>";
			  echo "<li><a href='jobview.php?jobid=$jobid'  target='_view'>View</a></li>";		
			 //if ( isSuperUser(false) ){
				//this is not implemented
				//echo "<li><a href='#' onClick=\"sure('Job','$jobid')\">Delete</a></li>";
			  //}				  
  
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
