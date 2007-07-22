<?php
require("common_user.php");

function showAdmin(){
  echo "<table id=\"table_admin\">";
  echo "<form action=\"account.php\" method=\"POST\">";
  echo "<TR><TD>Log in as which user?</TD>";
  echo "<TD><select name=\"whichUser\">";
  $theuser=new OnlineUser();
  $results=getAllObjects($theuser);
  foreach ($results as $obj){
    echo "<option value=\"".$obj->onlineuserId."\">".$obj->email."</option>\n";
  }
  echo "</select>";
  echo "</td></tr>";
  echo "<TR><TD><input type=submit value=\"OK\"></td></tr>";
  echo "</form>";
  echo "</table>";
}

// if this is set, then the admin_xxxx_create pages display a cancel button. When clicked
// the user is taken back to the page specified below
$_SESSION["cancel"]="account.php";


if(isset($_POST["whichUser"]) && isSuperUser(false)){
  $user=$user->Get((int)$_POST["whichUser"]);
  $_SESSION["onlineuser"]=$user;
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
  <a href="user_profile.php" style="color:#0000FF;text-decoration:underline">Update Profile</a>
</p>
<p>
  <a href="change_password.php" style="color:#0000FF;text-decoration:underline">Update Password</a>
</p>
</td></tr></table>
<?php
//generateCVLink($user);
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
  if ($rows > 0||isSuperUser(false))
  {
     $alt=false;
	 $rowclass="";
	 echo "<br/>";
     echo "Job Admin";
	if (isSuperUser(false))
	{
    	echo "  - <a href='job_post.php'>create new</a>";
	}	 
	  echo "<div class=\"spacer\"></div>";
		echo "<table class=\"table\">";
	 	for ($i=0;$i<$rows;$i++){
			$row=mysql_fetch_assoc($result);
			  if ($alt){
				$rowclass="row_odd";
			  } else {
				$rowclass="row_even";
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
			  echo "<td class=\"$rowclass\">";
			  $jobid=$row["jobid"];
			  echo "<ul><li><a href='job_post.php?jobid=$jobid'>Modify</a></li>";
			  //echo "</td>";
			  switch ($row["job_status"]){
				case "active":
				  //echo "<td class=\"$rowclass\">";
				  echo "<li><a href='deactivate.php?type=Job&id=$jobid'>Deactivate</a>";
				  //echo "</td>";
				  break;
				case "disabled":
				  //echo "<td class=\"$rowclass\">";
				  echo "<li><a href='activate.php?type=Job&id=$jobid'>Activate</a>";
				  //echo "</td>";
				  break;
			  }			
			 //if ( isSuperUser(false) ){
				//this is not enabled
				//echo "<li><a href='#' onClick=\"sure('Job','$jobid')\">Delete</a></li>";
			  //}				  
  
			   echo "</ul>";
     		 echo "</td>";
			  echo "</tr>";
		}
  	echo "</table>";
  	echo "<br/>";
  	echo "<br/>";
  }
}

require("bottom_wide.php");
?>
