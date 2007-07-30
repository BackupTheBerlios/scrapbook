<?php
require("common_user.php");
checkForAddress();
$errorText="";

$supplier=new Supplier();
$id=intval($_GET["id"]);
if ($id==0){
	$id=intval($_POST["id"]);
}
if ($id>0){	
	$isNew=0;
	$supplier=$supplier->Get($id);
	//check to see user has access to modify this object	
	$user->canAccess($supplier);
} else { //new object
	$isNew=1;
	$supplier->onlineuser_onlineuserid = $user->onlineuserId;
	
	//default link
	$supplier->link="http://";	
	//free for now
	$supplier->supplier_status='active';
	$supplier->dt_expire=expiryDate();
}

//check if form is being submitted
if ((bool)$_POST["submitting"])
{
  $isNew=$_POST["isNew"];
  $supplier->logo=$_POST["currentFilename"];
  $supplier->name=$_POST["name"];
  $supplier->description=$_POST["description"];
  $supplier->link=$_POST["link"];
  $supplier->tel=$_POST["tel"];
  $supplier->supplier_category_id=(int)$_POST["category"];
  
  
  $tempFilename=$_FILES["logo"]["tmp_name"];
  if ($tempFilename!=""){
    $supplier->logo=generateFilename($user->onlineuserId,$_FILES["logo"]["name"]);
    move_uploaded_file($tempFilename,"logos/$supplier->logo");
  }

  if (($result=validate($supplier->name,"",255))!==true){
    $errorText.="<li>Supplier name is $result";
  }
  if (($result=validate($supplier->description,"",5000))!==true){
    $errorText.="<li>Description is $result";
  }
  if (($result=validate($supplier->link,"",255))!==true){
    $errorText.="<li>Website link is $result";
  }
  if ($supplier->tel!="" && ($result=validate($supplier->tel,"phonenumber",255))!==true){
    $errorText.="<li>Telephone number is $result";
  }

  if ($errorText==""){
    if (!file_exists("logos")){
      mkdir("logos");
    }
    $supplier->Save();

    if ($isNew==1){
      require("class.email.php");
      $mail=new Emailer();
      $mail->setFrom($configuration["fromEmail"]);
      $mail->setTo($configuration["adminEmail"]);
      $mail->setSubject("New Services Taken");
      $mail->bodyAdd("Dear admin,");
      $mail->bodyAdd("");
      $mail->bodyAdd("Just to let you know the following services have been taken by ".$user->first_name." ".$user->last_name);
      $mail->bodyAdd("Service: supplier");
      $mail->send();
    }

    header("Location: supplier_success.php");
  } else {
    $errorText="<ul>".$errorText."</ul>";
  }
}
?>

<?php
	require("top.php");
?>
<table width="459" border="0" cellspacing="0" cellpadding="0" >
 <tr>
  <td><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /></td>
 </tr>
 <tr>
  <td><div class="roundcont">
   <div class="roundtop"> <img class="corner" src="images/bl_01.gif" alt="edge" style=" display: none;" /></div>
   <h1>Supplier Advertisement</h1>
   <div class="roundbottom"> <img src="images/bl_06.gif" alt="edge" class="corner" style=" display: none;" /></div>
  </div></td>
 </tr>
</table>
<table border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top" width="454"><img src="images/spacer.gif" alt="spacer" width="1" height="5" border="0" /> </td>
 </tr>
 <tr>
  <td valign="top" width="454"><p style = "padding-left:5px; margin:0px;">Please begin by creating your advertisement. Your logo should be 135 wide by 115 high and be in gif or jpeg format. Logos with a canvas area different from the above will result in a squashed or distorted advertisement.<br />
    <br />
Choose the category that best fits your advertisment then complete the Company name, a brief description, website address (if available) and your telephone number. Once completed you can amend this advertisement from your member area.<br />
  <br />
  </p>
    </td>
 </tr>
 <tr>
  <td></td>
 </tr>
</table>
<form action="supplier_form.php" method="POST" enctype="multipart/form-data">
<input type=hidden name="id" value="<?php echo $supplier->supplierId; ?>">
<input type=hidden name="isNew" value="<?php echo $isNew; ?>">
<input type=hidden name="submitting" value="true">

<table id="table_create" class = "uploadform">
  <tr>
    <td colspan=2 id="cell_error_text">
    <?php
      echo $errorText;
    ?>
    </td>
  </tr>
  <?php
    if ($supplier->logo!=""){
      echo "<TR>";
      echo "<TD>";
      echo "Current Logo:";
      echo "</td>";
      echo "<TD>";
      echo "<img src=\"logos/$supplier->logo\" width=\"$logoWidth\" height=\"$logoHeight\">";
      echo "</td>";
      echo "</tr>";
    }
  ?>
  <tr>
    <td>
      Category:
    </td>
    <td>
      <select name="category" id="category">
      <?php
        $supCategory=new Supplier_category();
        $result=$supCategory->GetList(array(array(1)),"name");
        foreach ($result as $obj){
          if ($supplier->supplier_category_id==$obj->supplier_categoryId){
            $chk=" SELECTED";
          } else {
            $chk="";
          }
          echo "<option value=\"".$obj->supplier_categoryId."\"$chk>".ucwords($obj->name)."</option>\n";
        }
      ?>
      </select>
    </td>
  </tr>
  <tr>
    <td>
      Upload Logo:
    </td>
    <td>
      <input type="file" id="file" name="logo">
      <input type="hidden" name="currentFilename" value="<?php echo $supplier->logo; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Company Name:
    </td>
    <td>
      <input class = "detail" type="text" id="name" name="name" value="<?php echo $supplier->name; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Description:
    </td>
    <td>
      <textarea class = "detail" name="description" id="description"><?php
        echo $supplier->description;
      ?></textarea>
    </td>
  </tr>
  <tr>
    <td>
      Website link:
    </td>
    <td>
      <input class = "detail" type="text" id="link" name="link" value="<?php echo $supplier->link; ?>">
    </td>
  </tr>
  <tr>
    <td>
      Telephone number:
    </td>
    <td>
      <input class = "detail" type="text" id="tel" name="tel" value="<?php echo $supplier->tel; ?>">
    </td>
  </tr>
  <tr>
    <td>
    </td>
    <td>
      <input type="submit" id="submit" value="Submit">
      <?php
        if (isset($_SESSION["cancel"])){
          echo "<input type=\"button\" onClick=\"location.href='".$_SESSION["cancel"]."'\" value=\"Cancel\">";
        }
      ?>
    </td>
  </tr>
</table>

</form>
<?php
	require("bottom.php");
?>
