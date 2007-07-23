<?php 
require("common_user.php");
require("class.email.php");

function generateEmail($cv_first_name, $cv_last_name, $jobId, $job_contact_email){
  $emailMessage="Dear $cv_first_name $cv_last_name\n\n";
  $emailMessage.="A potential Employer has viewed your Job Seekers\n";
  $emailMessage.="profile and is interested in contacting you.\n";
  $emailMessage.="Please click on this link\n";
  $emailMessage.="http://www.fastfoodjobsuk.co.uk/jobview.php?jobid=$jobId\n";
  $emailMessage.="in order to view the job being advertised.\n";
  $emailMessage.="You may also contact this employer directly by e-mail\n";
  $emailMessage.="$job_contact_email\n\n";
  $emailMessage.="None of your contact details have been revealed\n";
  $emailMessage.="and it is totally up to you if you wish to make\n";
  $emailMessage.="contact with the interested employer.\n\n";
  $emailMessage.="Regards,\n\n";
  $emailMessage.="The Fast Food Jobs Team\n\n";
  $emailMessage.="Tel: 0845 644 8252\n";
  $emailMessage.="info@fastfoodjobsuk.co.uk";
  return $emailMessage;
}

$cvid = (int)$_GET["cvid"];
if ($cvid==""){
  $cvid=(int)$_POST["cvid"];
}

$db=new DatabaseConnection();
$results=$db->Query("SELECT first_name, last_name, email FROM cv WHERE cvid='$cvid'");

if ($db->Rows()<=0){
  // possibly post/get data has been tampered with
  // you should always get 1 row back with this query
  exit;
}

$data=mysql_fetch_row($results);
$cv_first_name=$data[0];
$cv_last_name=$data[1];
$cv_email=$data[2];

if ((bool)$_POST["submitting"]){
  $jobId=(int)$_POST["jobId"];
  $queryJob=$db->Query("SELECT contact_email FROM job WHERE jobid='$jobId'");
  if ($db->Rows()<=0){
    // shouldn't really ever get here
    exit;
  }
  
  $data=mysql_fetch_row($queryJob);
  $job_contact_email=$data[0];
  
  $mail=new Emailer();
  $mail->setTo($cv_email);
  $mail->setSubject("An employer wishes to contact you");
  $mail->setFrom($configuration["fromEmail"]);
  $mail->bodyAdd(generateEmail($cv_first_name,$cv_last_name,$jobId,$job_contact_email));
  $mail->send();
  
  header("Location: cv_contact_success.php");
  exit;
}

$queryJob=$db->Query("SELECT jobid, position, location, contact_email FROM job WHERE onlineuser_onlineuserid='".$user->onlineuserId."' AND dt_expire>'".date("Y-m-d")."'");
if ($db->Rows()<=0){
  // you will only reach here if the current user does not have a live job
  exit;
}

$jobCount=$db->Rows();
if ($jobCount==1){
  $jobId=mysql_fetch_row($queryJob);
  $jobId=$jobId[0];
} else {
  $jobId="";
}

$job_contact_email=mysql_fetch_row($queryJob);
$job_contact_email=$job_contact_email[3];

$emailMessage=generateEmail("*****","*****","<span id=\"jobId\">$jobId</span>","<span id=\"job_contact_email\">$job_contact_email</span>");
mysql_data_seek($queryJob,0);

$options="";
$js="";

for ($i=0;$i<$jobCount;$i++){
  $data=mysql_fetch_row($queryJob);
  $options.="<option value=\"".$data[0]."\">";
  $options.=$data[1]." - ".$data[2];
  $options.="</option>";

  $js.="jobData['".$data[0]."']=\"".$data[3]."\";\n";
}

require("top.php");
?>

<script language="JavaScript">
var jobData=new Array();
<?php echo $js; ?>
</script>

<form action="cv_contact.php" method="POST">
<input type=hidden name="cvid" value="<?php echo $cvid; ?>">
<input type=hidden name="submitting" value="true">

<table>
  <?php
    if ($jobCount>1){
      ?>
      <tr>
        <td>
          Please select which job:
        </td>
      </tr>
      <tr>
        <td>
          <select name="jobIds" id="selectJobId" onChange="changeDetails()">
          <?php
            echo $options;            
          ?>
          </select>
        </td>
      </tr>
      
      <?php
    }
  ?>
  
  <tr>
    <td>
      Email to be sent:
    </td>
  </tr>
  
  <tr>
    <td>
      <pre><?php
          echo $emailMessage;
        ?>
      </pre>
    </td>
  </tr>
  
  <tr>
    <td>

      <input type=submit value="Send Email">
	        <input type=button value="Cancel" onClick="window.location='cvlist.php'">
    </td>
  </tr>
  
</table>
</form>

<script language="JavaScript">
function changeDetails(){
  var jobid=document.getElementById("selectJobId").value;
  document.getElementById("jobId").innerHTML=jobid;
  document.getElementById("job_contact_email").innerHTML=jobData[jobid];
}
changeDetails();
</script>

<?php
require("bottom.php");
?>
