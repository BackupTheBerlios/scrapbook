<?php
include("phpfn.php");
/* a few common user funtions*/

// check user is logged in. If they are not, this script stops executing and they are redirected
function isUserLoggedIn(){
	if (isset($_SESSION["onlineuser"])){
		return $_SESSION["onlineuser"];
	} else {
		//$_SESSION["redirect"]= $_SERVER["PHP_SELF"];
		$_SESSION["redirect"]= $_SERVER["REQUEST_URI"];
		header("Location: login.php");
		exit;
	}
}

// if active is true then the user is taken to the login page if they are not
// the super user. if active is false, then a return value is set to TRUE if
// the current user is the super user, and false if they are not
function isSuperUser($active=true){
  $user=(isset($_SESSION["superuser"])? $_SESSION["superuser"] : $_SESSION["onlineuser"]);
  if (isset($user)&&$user->isSuperAdmin()){
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
	  //$_SESSION["redirect"]=$_SERVER["PHP_SELF"];
	  $_SESSION["redirect"]= $_SERVER["REQUEST_URI"];
	  header("Location: logout.php");
	  exit;
	} else {
	  return false;
	}
  } 
}

function isUniqueVisit($class,$id,$type){
  if (!isset($_COOKIE["ffjvisit_".$class.$id.$type])){
    setcookie("ffjvisit_".$class.$id.$type, "true", (time()+86400), "/", ".fastfoodjobsuk.co.uk");
    updateStats($class,$id,$type);
    return true;
  } else {
    return false;
  }
}

function updateStats($objectName,$objectId,$type){
  $db=new DatabaseConnection();
  $stats=new Stats();
  //$query="SELECT statsid FROM stats WHERE objectname='platinum_membership' AND objectid='".$platinumImages[$i][0]."'";
  $query="SELECT statsid FROM stats WHERE objectname='$objectName' AND objectid='$objectId'";
  $results=$db->Query($query);
  if ($db->Rows()>0){
    $data=mysql_fetch_row($results);
    $stats=$stats->Get((int)$data[0]);
  } else {
    //$stats->objectname="platinum_membership";
    //$stats->objectid=$platinumImages[$i][0];
    $stats->objectname=$objectName;
    $stats->objectid=$objectId;
  }
  
  $stats->$type=$stats->$type+1;
  $stats->Save();
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
		//$_SESSION["redirect"]=$_SERVER["PHP_SELF"];
		$_SESSION["redirect"]= $_SERVER["REQUEST_URI"];
			header("Location: register_address.php");
			exit;
	}
}
function generateFilename($id,$originalFilename){
  $stamp=date("U");
	//trim sapce
  $filename=ereg_replace( ' +', '', $originalFilename );
  $filename=strtolower($id.'_'.$stamp.'_'.$filename);
  return $filename;
}

function validate($d,$eregi,$length,$minLength=0){

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
      $eregi='^[0-9\(\)\-\ ]+$';
      break;
  }
  
  if ($eregi=="words"){
    
    // special case whereby we want to check how many words there are
    $reformat=$d;
    $reformat=str_replace(", ", ",", $reformat);
    $reformat=str_replace(". ", ".", $reformat);
    $reformat=str_replace(" - ", "-", $reformat);
    $wordCount=0;
    $wordCount+=substr_count($reformat,".");
    $wordCount+=substr_count($reformat,",");
    $wordCount+=substr_count($reformat," ");
    $wordCount+=substr_count($reformat,"-");
    
    // there are 6.8 characters on average per english word
    // so 7 should be enough
    if ($wordCount>=$length || strlen($d)>(7*$length)){
      return "too long";
    } else if (strlen($d)<=$minLength){
      return "mandatory";
    } else {
      return true;    
    }
    
  } else {
  
  	if ( $eregi!="" && !eregi($eregi,$d) ){
  		return "invalid";
  	} else if (strlen($d)>$length){
  		return "too long";
  	}else if (strlen($d)<$minLength){
  		return "too short";
  	}else if (strlen($d)==0) {
  	  return "mandatory";
  	} else {
      return true;
  	}
  
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

//load options from a file
function loadOptions($listFile,$selectedValue)
{
	if (isset($selectedValue)){
		$f=fopen($listFile,"r");
		while (!feof($f)){
			$d=fgets($f);
			$start=strpos($d,"\"")+1;
			$end=strrpos($d,"\"");
			$val=substr($d,$start,$end-$start);
			if ($val==$selectedValue){
			  $newD=substr($d,0,$end+1);
			  $newD.=" SELECTED";
			  $newD.=substr($d,$end+1);
			  $d=$newD;
			}
			echo $d;
		}
		fclose($f);
    }else{
		require($listFile);
	}
}

//load options from a file
function getOptionLabel($listFile,$selectedValue)
{
	$f=fopen($listFile,"r");
	while (!feof($f)){
		$d=fgets($f);
		$start=strpos($d,"\"")+1;
		$end=strrpos($d,"\"");
		$val=substr($d,$start,$end-$start);
		
		if ($val==$selectedValue){
		
			$lstart=strpos($d,">")+1;
			$lend=strrpos($d,"<");
			$Label=substr($d,$lstart,$lend-$lstart);
			break;
		}

	}
	fclose($f);
	return $Label;
}

function super_generate($title,$user,$object){
  global $truncateText;

	   $results=  getAllObjects($object, "dt_created", false);


  $alt=false;
  $rowclass="";
  
  if (count($results)>0||isSuperUser(false)) {
    $class=strtolower(get_class($object));
	echo $title." Admin";

  echo "  - <a href='".$class."_form.php'>create new</a>";

  	echo "<div class=\"spacer\"></div>";
    echo "<table class=\"table\">";
	  if (count($results)==0){
				echo "<tr><td>";
				echo "currently have no entries";
				echo "</td></tr>";

  	 }else{
	
		$hasName=isset($results[0]->name);
		$hasHeading=isset($results[0]->heading);
		$hasDescription=isset($results[0]->description);
		$hasText=isset($results[0]->text);
		$hasLink=isset($results[0]->link);

    echo "<TR>";
    if ($hasName){
      echo "<TD>Name</td>";
    } elseif ($hasHeading){
      echo "<TD>Heading</td>";
    }
    if ($hasDescription){
      echo "<TD>Description</td>";
    } elseif ($hasText){
      echo "<TD>Text</td>";
    }
    if ($hasLink){
      echo "<TD>URL</td>";
    }
    echo "<TD>Created</td>";
    echo "<TD><!-- Functions --></td>";
    echo "</tr>";
		
    foreach ($results as $obj){
		  
		  if ($alt){
        $rowclass="row_even";
		  } else {
        $rowclass="row_odd";
		  }
		  $alt=!$alt;
		  
		  echo "<tr>";
		  if ($hasName){
        echo "<td class=\"$rowclass\">".$obj->name."</td>";
		  } else if($hasHeading) {
        echo "<td class=\"$rowclass\">".$obj->heading."</td>";
		  }
		  if ($hasDescription){
        echo "<td class=\"$rowclass\">".strip_tags(substr($obj->description,0,$truncateText))."...</td>";
		  } else if($hasText){
        echo "<td class=\"$rowclass\">".strip_tags(substr($obj->text,0,$truncateText))."...</td>";
		  }
		  if ($hasLink){
        echo "<td class=\"$rowclass\">".$obj->link."</td>";
		  }
		  
      echo "<td class=\"$rowclass\">".FormatDateTime($obj->dt_created,5)."</td>";
		  
			$classId=$class."Id"; 
		  $status=$class."_status"; 
		  echo "<td class=\"$rowclass\">";
		  echo "<ul><li><a href=\"".$class."_form.php?id=".$obj->$classId."\">Modify</a></li>";
		  //echo "</td>";
		  

        switch ($obj->$status){
          case "temp":
    			  echo "<li><a href=\"activate.php?type=$class&id=".$obj->$classId."\">Activate</a></li>";
            break;
			/*
          case "active":
    			  //echo "<td class=\"$rowclass\">";
            echo "<li><a href=\"deactivate.php?type=$class&id=".$obj->$classId."\">Deactivate</a></li>";
    			  //echo "</td>";
    			  break;
    			case "disabled":
    			  //echo "<td class=\"$rowclass\">";
    			  echo "<li><a href=\"activate.php?type=$class&id=".$obj->$classId."\">Activate</a></li>";
    			  //echo "</td>";
    			  break;
  		  */
  		}

		 echo "<li><a href=\"#\" onClick=\"sure('$class','".$obj->$classId."')\">Delete</a></li>";

		  echo "</ul>";
		  echo "</td>";
		  echo "</tr>";
		}
	}
	echo "</table>";
  }
  echo "<br/>";
  echo "<br/>";
}


function generate($title,$user,$object){
  global $truncateText;

  		$results=$object->GetList(array(array("onlineuser_onlineuserid","=",$user->onlineuserId)) );

  $alt=false;
  $rowclass="";
  
  if (count($results)>0||isSuperUser(false)) {
    $class=strtolower(get_class($object));
	echo $title." Admin";
	echo "  - <a href='".$class."_form.php'>create new</a>";
  	echo "<div class=\"spacer\"></div>";
    echo "<table class=\"table\">";
	  if (count($results)==0){
	  		if (isSuperUser(false))
			{
				echo "<tr><td>";
				echo "currently have no entries";
				echo "</td></tr>";
			}
  	 }else{
		$hasName=isset($results[0]->name);
		$hasHeading=isset($results[0]->heading);
		$hasDescription=isset($results[0]->description);
		$hasText=isset($results[0]->text);
		$hasLink=isset($results[0]->link);

    echo "<TR>";
    if ($hasName){
      echo "<TD>Name</td>";
    } elseif ($hasHeading){
      echo "<TD>Heading</td>";
    }
    if ($hasDescription){
      echo "<TD>Description</td>";
    } elseif ($hasText){
      echo "<TD>Text</td>";
    }
    if ($hasLink){
      echo "<TD>URL</td>";
    }
    echo "<TD>Created</td>";
    echo "<TD>Expires</td>";
	echo "<td>Status</td>";
    echo "<TD><!-- Functions --></td>";
    echo "</tr>";
		
    foreach ($results as $obj){
		  
		  if ($alt){
        $rowclass="row_even";
		  } else {
        $rowclass="row_odd";
		  }
		  $alt=!$alt;
		  
		  echo "<tr>";
		  if ($hasName){
        echo "<td class=\"$rowclass\">".$obj->name."</td>";
		  } else if($hasHeading) {
        echo "<td class=\"$rowclass\">".$obj->heading."</td>";
		  }
		  if ($hasDescription){
        	echo "<td class=\"$rowclass\">".strip_tags(substr($obj->description,0,$truncateText))."...</td>";
		  } else if($hasText){
       	 	echo "<td class=\"$rowclass\">".strip_tags(substr($obj->text,0,$truncateText))."...</td>";
		  }
		  if ($hasLink){
        	echo "<td class=\"$rowclass\">".$obj->link."</td>";
		  }
		  
      	  echo "<td class=\"$rowclass\">".FormatDateTime($obj->dt_created,5)."</td>";
		  echo "<td class=\"$rowclass\">".(($d=FormatDateTime($obj->dt_expire,5)) == "0000/00/00" ? "please<BR>activate" : $d)."</td>";
		  
		  $classId=$class."Id"; 
		  $status=$class."_status"; 

		  //echo "</td>";
		  
      if ($obj->$status!="temp" && $obj->dt_expire<=date("Y-m-d")){
	  	echo "<td class=\"$rowclass\">Expired</td><td class=\"$rowclass\"><ul>";
        echo "<li><a href=\"renew.php?type=$class&id=".$obj->$classId."\">Renew</a></li>";
      } else {
      
        	switch ($obj->$status){
				case "temp":
					  echo "<td class=\"$rowclass\">Temporary</td><td class=\"$rowclass\"><ul>";	
					  echo "<li><a href=\"activate.php?type=$class&id=".$obj->$classId."\">Activate</a></li>";
				break;
				case "active":
					echo "<td class=\"$rowclass\">Active</td><td class=\"$rowclass\"><ul>";
					if (isSuperUser(false))
						echo "<li><a href=\"deactivate.php?type=$class&id=".$obj->$classId."\">Pause</a></li>";
					break;			
				case "disabled":
					echo "<td class=\"$rowclass\">Paused</td><td class=\"$rowclass\"><ul>";
					if (isSuperUser(false))
						echo "<li><a href=\"activate.php?type=$class&id=".$obj->$classId."\">Continue</a></li>";
				break;
  		  }
  		  
  		}
		  echo "<li><a href=\"".$class."_form.php?id=".$obj->$classId."\">Modify</a></li>";			
		  if ( ($class=="gold_membership" || $class=="supplier") && (isSuperUser(false)) ){
			echo "<li><a href=\"spotlight_form.php?type=$class&membershipid=".$obj->$classId."\">Spotlight</a></li>";
		  }		
		  echo "</ul>";
		  echo "</td>";
		  echo "</tr>";
		}
	}
	echo "</table>";
  }
  echo "<br/>";
  echo "<br/>";
}
?>
