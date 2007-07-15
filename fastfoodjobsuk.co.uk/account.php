<?php
require("common_user.php");
function generate($title,$user,$object,$modifyLink){
  global $truncateText;
  
  echo $title."<BR>";
  echo "<div class=\"spacer\"></div>";
  $results=$object->GetList(array(array("onlineuser_onlineuserid","=",$user->onlineuserId)),"dt_created");
  echo "<table class=\"table\">";
  $alt=false;
  $rowclass="";
  
  if (count($results)==0){
    echo "<TR><td>";
    echo "You currently have no entries";
    echo "</Td></tr>";
  } else {
    foreach ($results as $obj){
      
      if ($alt){
        $rowclass="row_odd";
      } else {
        $rowclass="row_even";
      }
      $alt=!$alt;
      
      echo "<TR>";
      if (isset($obj->name)){
        echo "<TD class=\"$rowclass\">".$obj->name."</td>";
      } else if(isset($obj->heading)) {
        echo "<TD class=\"$rowclass\">".$obj->heading."</td>";
      }
      if (isset($obj->description)){
        echo "<TD class=\"$rowclass\">".strip_tags(substr($obj->description,0,$truncateText))."...</td>";
      } else if(isset($obj->text)){
        echo "<TD class=\"$rowclass\">".strip_tags(substr($obj->text,0,$truncateText))."...</td>";
      }
      if (isset($obj->link)){
        echo "<TD class=\"$rowclass\">".substr($obj->link,7)."</td>";
      }
      echo "<TD class=\"$rowclass\">".date("d/m/y",(int)$obj->dt_created)."</td>";
      $class=get_class($obj);
      $class.="Id";
      echo "<TD class=\"$rowclass\"><a href=\"admin_".$modifyLink."_modify.php?id=".$obj->$class."\">Modify</a></td>";
      echo "</tr>";
    }
  }
  echo "</table>";
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
<?php
if (isSuperUser(false)){
  showAdmin();
}
generate("Restaurants",$user,new Restaurant(),"restaurant");
generate("Franchises",$user,new Franchise(),"franchise");
generate("Gold Adverts",$user,new Gold_membership(),"gold");
generate("Platinum Adverts",$user,new Platinum_membership(),"platinum");
generate("Suppliers",$user,new Supplier(),"supplier");
?>
</td></tr></table>
<?php
require("bottom.php");
?>
