<?PHP
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
	
	//
	//
?>
