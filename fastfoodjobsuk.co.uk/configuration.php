<?php
if (!isset($_SESSION)){
	session_start();
}

global $configuration;

//db_encoding=1 is highly recommended unless you know what you're doing
$configuration['db_encoding'] = 0;

// edit the information below to match your database settings

$configuration['db']	= 'web84-fastfood'; 		//	database name
$configuration['host']	= 'fastfoodjobsuk.co.uk';	//	database host
$configuration['user']	= 'web84-fastfood';		//	database user
$configuration['pass']	= 'pizza555';		//	database password
$configuration['port'] 	= '3306';		//	database port

//plugin settings
$configuration['plugins_path'] = '';  //absolute path to plugins folder, e.g c:/mycode/test/plugins or /home/phpobj/public_html/plugins

// admin email address
  $configuration["adminEmail"]="me@chrissweeney.co.uk";
  //$configuration["adminEmail"]="admin@fastfoodjobsuk.co.uk";
// from email address
  $configuration["fromEmail"]="noreply@fastfoodjobsuk.co.uk";

global $goldTableCols,$truncateText,$logoWidth,$logoHeight,$platinumImageWidth,$platinumImageHeight;
// controls the table size of the gold membership and restaurants
 $goldTableCols=3;

// controls how much of a description or heading is displayed on the accounts.php page
 $truncateText=25;

// controls the logo size
 $logoWidth=134;
 $logoHeight=115;

// platinum image sizes
 $platinumImageWidth=153;
 $platinumImageHeight=104;
 
?>
