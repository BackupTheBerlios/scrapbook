<?php
require("common_super.php");

$db=new DatabaseConnection();
$firstname=$_POST["firstname"];
$lastname=$_POST["lastname"];
$email=$_POST["email"];
$matches=false;
$resultArray=array();

if ($firstname!="" || $lastname!=""||$email!=""){
  $where="";
  $where=($firstname!="" ? "first_name like '%".$db->Escape($firstname)."%'" : "");
  if ($lastname!=""){
    if ($where!=""){
      $where.=" AND ";
    }
    $where.="last_name like '%".$db->Escape($lastname)."%'";
  }
  if ($email!=""){
    if ($where!=""){
      $where.=" AND ";
    }
    $where.="email like '%".$db->Escape($email)."%'";
  }  
  $result=$db->Query("SELECT onlineuserId, first_name, last_name, email FROM onlineuser WHERE $where AND onlineuserId!='1'");
  if ( ($rows=$db->Rows()) > 0){
    $matches=true;
    for ($i=0;$i<$rows;$i++){
      $resultArray[$i]=mysql_fetch_row($result);
    }
  }
}

require("top_wide.php");
?>
<br>
<script language="JavaScript">
function sure(classname,id){
  if (confirm("Are you sure you wish to delete this record?")){
    window.location='delete.php?type='+classname+'&id='+id;
  }
}
</script>
<table id="table">
<form action="admin_account.php" method="POST">
  <tr>
    <td colspan=2>
      Search for user:
    </td>
  </tr>
  <tr>
    <td>
      First name:
    </td>
    <td>
      <input name="firstname" id="firstname" value="<?php echo $firstname; ?>">
    </td>
  </tr>

  <tr>
    <td>
      Last name:
    </td>
    <td>
      <input name="lastname" id="lastname" value="<?php echo $lastname; ?>">
    </td>
  </tr>
  
  <tr>
    <td>
      Eamil:
    </td>
    <td>
      <input name="email" id="email" value="<?php echo $email; ?>">
    </td>
  </tr>  
  
  <tr>
    <td>
    </td>
    <td>
      <input type=submit value="Search">
    </td>
  </tr>
  </form>
  
  <tr>
    <td colspan=2>
      <br><br>
    </td>
  </tr>
  
  <form action="account.php" method="POST">
  <tr>
    <td>
      Log in as which user?
    </td>
    <td>
      <select name="whichUser" size=8>
      <option value="1">Super User - super@fastfoodjobsuk.co.uk</option>
      <?php
        if ($matches){
          for($i=0;$i<count($resultArray);$i++){
            echo "<option value=\"".$resultArray[$i][0]."\">".$resultArray[$i][1]." ".$resultArray[$i][2]." - ".$resultArray[$i][3];
            echo "</option>\n";
          }
        }        
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td>
    </td>
    <td>
      <input type=submit value="OK">
    </td>
  </tr>
   </form> 
  </table>

<?php
generate("News",$user,new News(),true);
generate("Venue",$user,new Restaurant());
generate("Franchise For sales",$user,new Franchise());
require("bottom_wide.php");
?>
