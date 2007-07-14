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

global $goldTableCols,$truncateText,$logoWidth,$logoHeight,$platinumImageWidth,$platinumImageHeight;
// controls the table size of the gold membership and restaurants
 $goldTableCols=3;

// controls how much of a description or heading is displayed on the accounts.php page
 $truncateText=25;

// controls the logo size
 $logoWidth=140;
 $logoHeight=120;

// platinum image sizes
 $platinumImageWidth=1532;
 $platinumImageHeight=104;
?>
