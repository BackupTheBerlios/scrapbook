<?php
require("common_user.php");
function generate($title,$user,$object){
  global $truncateText;
  

  $results=$object->GetList(array(array("onlineuser_onlineuserid","=",$user->onlineuserId)),"dt_created");

  $alt=false;
  $rowclass="";
  
  if (count($results)==0){
    //echo "<tr><td>";
    //echo "You currently have no entries";
    //echo "</td></tr>";
  } else {
    echo $title."<br/>";
  echo "<div class=\"spacer\"></div>";
    echo "<table class=\"table\">";
    foreach ($results as $obj){
      
      if ($alt){
        $rowclass="row_odd";
      } else {
        $rowclass="row_even";
      }
      $alt=!$alt;
      
      echo "<tr>";
      if (isset($obj->name)){
        echo "<td class=\"$rowclass\">".$obj->name."</td>";
      } else if(isset($obj->heading)) {
        echo "<td class=\"$rowclass\">".$obj->heading."</td>";
      }
      if (isset($obj->description)){
        echo "<td class=\"$rowclass\">".strip_tags(substr($obj->description,0,$truncateText))."...</td>";
      } else if(isset($obj->text)){
        echo "<td class=\"$rowclass\">".strip_tags(substr($obj->text,0,$truncateText))."...</td>";
      }
      if (isset($obj->link)){
        echo "<td class=\"$rowclass\">".substr($obj->link,7)."</td>";
      }
      echo "<td class=\"$rowclass\">".FormatDateTime($obj->dt_created,5)."</td>";
      $class=strtolower(get_class($obj));
		$classId=$class."Id"; 
      echo "<td class=\"$rowclass\"><a href=\"".$class."_form.php?id=".$obj->$classId."\">Modify</a></td>";
      echo "</tr>";
    }
	echo "</table>";
  }
  
}

function showAdmin(){
  echo "<table id=\"table_admin\">";
  echo "<form action=\"account.php\" method=\"POST\">";
  echo "<TR><TD>Log in as which user?</TD>";
  echo "<TD><select name=\"whichUser\">";
  $users=new OnlineUser();
  $results=$users->GetList(array(array("onlineuserid",">=","0")),"onlineuserid");
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
require("top.php");
?>

<link rel="stylesheet" href="css/account.css" type="text/css">
<table class="paddingforinfocell"><tr><td>
<p>
  <a href="user_profile.php" style="color:#0000FF;text-decoration:underline">Update Profile</a>
</p>
<p>
  <a href="change_password.php" style="color:#0000FF;text-decoration:underline">Update Password</a>
</p>

<?php
//generateCVLink($user);
//generateJobLink($user);
generate("Venue(s)",$user,new Restaurant());
generate("Franchise For sales",$user,new Franchise());
generate("Gold Advert(s)",$user,new Gold_membership());
generate("Platinum Advert(s)",$user,new Platinum_membership());
generate("Supplier(s)",$user,new Supplier());
?>
</td></tr></table>
<?php
/*
function generateJobLink($title,$user,$object){
  global $truncateText;
  
  $results=$object->GetList(array(array("onlineuser_onlineuserid","=",$user->onlineuserId)),"dt_created");

  $alt=false;
  $rowclass="";
  
  if (count($results)==0){
    //echo "<tr><td>";
    //echo "You currently have no entries";
    //echo "</td></tr>";
  } else {
    echo $title."<br/>";
  echo "<div class=\"spacer\"></div>";
    echo "<table class=\"table\">";
    foreach ($results as $obj){
      
      if ($alt){
        $rowclass="row_odd";
      } else {
        $rowclass="row_even";
      }
      $alt=!$alt;
      
      echo "<tr>";
      if (isset($obj->name)){
        echo "<td class=\"$rowclass\">".$obj->name."</td>";
      } else if(isset($obj->heading)) {
        echo "<td class=\"$rowclass\">".$obj->heading."</td>";
      }
      if (isset($obj->description)){
        echo "<td class=\"$rowclass\">".strip_tags(substr($obj->description,0,$truncateText))."...</td>";
      } else if(isset($obj->text)){
        echo "<td class=\"$rowclass\">".strip_tags(substr($obj->text,0,$truncateText))."...</td>";
      }
      if (isset($obj->link)){
        echo "<td class=\"$rowclass\">".substr($obj->link,7)."</td>";
      }
      echo "<td class=\"$rowclass\">".FormatDateTime($obj->dt_created,5)."</td>";
      $class=strtolower(get_class($obj));
		$classId=$class."Id"; 
      echo "<td class=\"$rowclass\"><a href=\"".$class."_form.php?id=".$obj->$classId."\">Modify</a></td>";
      echo "</tr>";
    }
  }
  echo "</table>";
}
*/
require("bottom.php");
?>
