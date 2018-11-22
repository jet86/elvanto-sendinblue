<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	// Load Elvanto API wrapper
	require_once('Elvanto_API.php');
	$elvanto = new Elvanto_API();

	// Set static parameters
	$elvantoScope = "ManagePeople,ManageGroups";
	
	// Load dynamic/config parameters
	if(include("local_config.php"))
	{
		echo "Local config file included.<br>\n";
	}
	elseif(include("config.php"))
	{
		echo "Config file included.<br>\n";
	}
	else
	{
		echo "Config file not found.<br>\n";
		// Do something here
		die();
	}
	
	// Authorize Elvanto
	$authorize_url = $elvanto->authorize_url(
	$elvantoClientID,
	$elvantoRedirectURI,
	$elvantoScope,
	'stateData'
	);

	echo $authorize_url;
?>
