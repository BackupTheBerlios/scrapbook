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
$fields=array("franchise","gold_membership","job","platinum_membership","restaurant","supplier");

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


// pull out all ads that are due to expire in 7 days exactly
// and email users
//----------------------------------------------------------

$inSevenDays=date("Y-m-d",strtotime("+7 days"));

$mail=new Emailer();
$mail->setSubject("Advert Expiry Notice");
$mail->setFrom($configuration["fromEmail"]);

foreach ($fields as $className){

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
      $mail->bodyAdd("Thank you for advertising with Fast Food Jobs. We just wanted to");
      $mail->bodyAdd("let you know your job advert will expire in 7 days.");
      $mail->bodyAdd("Please <a href=\"http://www.fastfoodjobsuk.co.uk/account.php\">click here</a> to renew your advert for another month.");
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
    }
  }
}

// disable all ads that have expired
// and email users
//-----------------------------------------------

$mail=new Emailer();
$mail->setSubject("Advert Expired Notice");
$mail->setFrom($configuration["fromEmail"]);

foreach ($fields as $className){

  $query="SELECT $className.".$className."id, onlineuser.email, onlineuser.first_name, onlineuser.last_name
          FROM $className, onlineuser
          WHERE $className.onlineuser_onlineuserid=onlineuser.onlineuserid
                AND $className.dt_expire<'".date("Y-m-d")."'
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
      $mail->bodyAdd("Thank you for advertising with Fast Food Jobs. We just wanted to");
      $mail->bodyAdd("let you know your job advert has expired.");
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
      
      /*
      $query="UPDATE $className
              SET ".$className."_status='disabled'
              WHERE ".$className."id='".$data[0]."'";
      
      $updateResult=mysql_query($query);
      if (!$updateResult){
        msg("Bad query ($updateResult)");
        msg("Error: ".mysql_error());
      }
      */
      
    }
  }

}

// remove redundant logos
//---------------------------

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
      echo "f=($f)";
      //unlink($filename);
      rename($filename, $filename.".deleted");
    }
  }
}
closedir($dir);

msg("END: ".date("r"));

?>
