<?php
/* a few common user funtions*/

// check user is logged in. If they are not, this script stops executing and they are redirected
function isUserLoggedIn(){
	if (isset($_SESSION["onlineuser"])){
		return $_SESSION["onlineuser"];
	} else {
		$_SESSION["redirect"]=$_SERVER["PHP_SELF"];
		header("Location: login.php");
		exit;
	}
}

// if active is true then the user is taken to the login page if they are not
// the super user. if active is false, then a return value is set to TRUE if
// the current user is the super user, and false if they are not
function isSuperUser($active=true){
  $user=(isset($_SESSION["superuser"])? $_SESSION["superuser"] : $_SESSION["onlineuser"]);
  if ($user->email=="super@fastfoodjobsuk.co.uk"){
	if (!isset($_SESSION["superuser"])){
	  $_SESSION["superuser"]=$_SESSION["onlineuser"];
	}
	
	if ($active){
	  return $_SESSION["superuser"];
	} else {
	  return true;
	}
	
  } else {
	if ($active){
	  $_SESSION["redirect"]=$_SERVER["PHP_SELF"];
	  header("Location: login.php");
	  exit;
	} else {
	  return false;
	}
  } 
}

function showLoggedInAs(){

  if (isset($_SESSION["onlineuser"])){
		$user = $_SESSION["onlineuser"];
		return $user->email;
	} else {
	 return false;
	}

}

function checkForAddress(){
	$user=$_SESSION["onlineuser"];
	if ($user->address_1==""){
		$_SESSION["redirect"]=$_SERVER["PHP_SELF"];
			header("Location: register_address.php");
			exit;
	}
}
function generateFilename($id,$originalFilename){
  $stamp=date("U");
  $filename=$id;
  for ($i=0;$i<strlen($stamp);$i++){
    $filename.=chr(97+(int)$stamp[$i]);
  }
  $filename.=strtolower(substr($originalFilename,strrpos($originalFilename,".")));
  
  return $filename;
}

function validate($d,$eregi,$length){

  switch ($eregi){
    case "email":
      $eregi='^[a-z0-9_\-\.]+@[a-z0-9\-]+\.[a-z0-9\-\.]+$';
      break;
    case "username":
    case "password":
      $eregi='^[a-z0-9_\-]+$';
      break;
    case "name":
      $eregi='^[a-z ]+$';
      break;
    case "phonenumber":
      $eregi='^[0-9\(\)\-]+$';
      break;
  }
   
	if ( $eregi!="" && !eregi($eregi,$d) ){
		return "invalid";
	} else if (strlen($d)>$length){
		return "too long";
	} else if (strlen($d)==0) {
	  return "mandatory";
	} else {
    return true;
	}

}
//get a list of all object
function getAllObjects($instance, $sortBy='', $ascending=true, $limit='')
{
	//eval('$instance = new '.$objectName.'();');
	//$instanceId = strtolower(get_class($instance))."Id";
	//return $instance->GetList(array(array($instanceId, ">", "0")));
	return 	$instance->GetList(array(array(true)), $sortBy, $ascending, $limit);
	
	
}

//expiry date
function expiryDate($numberOfDays=30)
{
	$future = mktime(23,59,59,date("m"),date("d")+$numberOfDays,date("Y"));
	return date("Y-m-d", $future);
}

?>
