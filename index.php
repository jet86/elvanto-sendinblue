<?PHP
	// Load Elvanto API wrapper
	require_once('Elvanto_API.php');
	$elvanto = new Elvanto_API();

	// Set static parameters
	$elvantoScope = "ManagePeople,ManageGroups";
	
	// Load dynamic/config parameters
	if include("local_config.php")
	{
		echo "Local config file included.";
	}
	elseif include("config.php")
	{
		echo "Config file included.";
	}
	else
	{
		echo "Config file not found.";
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
?>
