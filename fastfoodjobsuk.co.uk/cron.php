<?php
require("common_all.php");
require("class.email.php");

function msg($msg){
  echo "$msg\n";
}

msg("BEGIN: ".date("r"));

// init
//--------

$config=$GLOBALS['configuration'];

// connect to database or retry 5 times then fail
//-----------------------------------------------

$retry=0;
do {
  if ($retry>0){
    sleep($retry*20);
  }
  $db=mysql_connect($config["host"],$config["user"],$config["pass"]);
  $retry++;
} while (!$db && $retry<=5);


// still no connection to database so alert user
//-----------------------------------------------

if (!$db){
  msg("$retry attempts have been made to contact the database but no connection could be made");
  msg("Last error: ".mysql_error());
  msg("Please fix this error and re-run the cron script");
  exit;
}


// problem selecting database, alert user
//----------------------------------------

if (!mysql_select_db($config["db"])){
  msg("An error has occured while selecting the database. Error follows:");
  msg(mysql_error());
  msg("Please fix this error and re-run the cron script");
  exit;
}


// pull out all job adverts that are due to expire in 7 days
// exactly and email users
//----------------------------------------------------------

$inSevenDays=date("Y-m-d",strtotime("+7 days"));

$mail=new Emailer();
$mail->setSubject("Job Expiry Notice");
$mail->setFrom($configuration["fromEmail"]);

$className="job";
$query="SELECT $className.".$className."id, onlineuser.email, onlineuser.first_name, onlineuser.last_name
        FROM $className, onlineuser
        WHERE $className.onlineuser_onlineuserid=onlineuser.onlineuserid
              AND $className.dt_expire='$inSevenDays'
              AND ".$className."_status='active'";

$result=mysql_query($query);
if (!$result){
  msg("Bad query ($query)");
  msg("Error: ".mysql_error());
} else {
  
  $rowCount=mysql_num_rows($result);
  for ($i=0;$i<$rowCount;$i++){
    $data=mysql_fetch_row($result);
    $mail->setTo($data[1]);
    $mail->bodyClear();
    $mail->bodyAdd("Dear ".$data[2]." ".$data[3]);
    $mail->bodyAdd("");
    $mail->bodyAdd("Thank you for advertising your job vacancy with Fast Food Jobs. We just wanted to");
    $mail->bodyAdd("let you know your job advert will expire shortly. If your vacancy is not yet filled");
    $mail->bodyAdd("please click here http://www.fastfoodjobsuk.co.uk/account.php to renew your advert");
    $mail->bodyAdd("for another month.");
    $mail->bodyAdd("");
    $mail->bodyAdd("Please do not forget to take advantage of our applicant search feature which is");
    $mail->bodyAdd("free to use all the time you have a live job advert. Just logon and enter you");
    $mail->bodyAdd("personal administration area.");
    $mail->bodyAdd("");
    $mail->bodyAdd("If you have any queries please do not hesitate to contact us.");
    $mail->bodyAdd("");
    $mail->bodyAdd("Regards,");
    $mail->bodyAdd("");
    $mail->bodyAdd("The Fast Food Jobs advertising team. ");
    $mail->bodyAdd("");
    $mail->bodyAdd("Tel: 0845 644 8252");
    $mail->bodyAdd("advertise@fastfoodjobsuk.co.uk ");
    $mail->send();
    echo "Email sent to: ".$mail->to."\n";
  }
}
  

// remove redundant logos
//---------------------------

if (isset($_GET["images"]){

  $query ="SELECT logo FROM franchise UNION ";
  $query.="SELECT logo FROM gold_membership UNION ";
  $query.="SELECT logo FROM platinum_membership UNION ";
  $query.="SELECT image1 FROM platinum_membership UNION ";
  $query.="SELECT image2 FROM platinum_membership UNION ";
  $query.="SELECT logo FROM restaurant UNION ";
  $query.="SELECT logo FROM supplier";
  
  $result=mysql_query($query);
  if (!$result){
    msg("Bad query ($query)");
    msg("Error: ".mysql_error());
  } else {
    
    $rowCount=mysql_num_rows($result);
    $dbFiles=array();
    
    // bug in function? The first element of the array cannot be found when searching (?)
    array_push($dbFiles,"");
    // the line above fixes this problem
    
    for ($i=0;$i<$rowCount;$i++){
      $data=mysql_fetch_row($result);
      array_push($dbFiles,$data[0]);
    }
  
  }
  
  $dir=opendir("logos");
  while (($f=readdir($dir)) !== false){
    $filename="logos/$f";
    if (is_file($filename)){
      if (!array_search($f,$dbFiles)){
        //echo "f=($f)";
        //unlink($filename);
        rename($filename, $filename.".deleted");
      }
    }
  }
  closedir($dir);

}

msg("END: ".date("r"));

?>
