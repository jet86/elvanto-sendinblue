<?PHP
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
	}
?>
