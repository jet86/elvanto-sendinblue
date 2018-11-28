<?php
	/**-/ // Only enable during development!
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	/**/

	// Start or resume the PHP session
	session_start();

	// Load Elvanto API wrapper
	require_once('Elvanto_API.php');

	// Set "constant" parameters
	$elvantoScope = "ManagePeople,ManageGroups";

	// Setup some variables
	$configLocalLoaded = false;
	$configLoaded = false;

	// Load dynamic/config parameters
	if(include("local_config.php"))
	{
		$configLocalLoaded = true;
	}
	elseif(include("config.php"))
	{
		$configLoaded = true;
	}
	else
	{
		echo "Config file not found.<br>\n";
		// Do something here
		die();
	}

	if(!($_SESSION['elvantoAccessToken'] && $_SESSION['elvantoAccessExpires'] && $_SESSION['elvantoAccessRefresh']))
	{
		$elvanto = new Elvanto_API();
		if(!($_GET['state'] == 'didAuth' && $_GET['code']))
		{
			// Authorize Elvanto
			$authorize_url = $elvanto->authorize_url(
			$elvantoClientID,
			$elvantoRedirectURI,
			$elvantoScope,
			'didAuth'
			);

			//
			header("Location: $authorize_url");
			die();
		}
		else
		{
			// Exchange user code for access token
			$result = $elvanto->exchange_token(
				$elvantoClientID,
				$elvantoClientSecret,
				$elvantoRedirectURI,
				$_GET['code'] // Get the code parameter from the query string.
			);

			$_SESSION['elvantoAccessToken'] = $result->access_token;
			$_SESSION['elvantoAccessExpires'] = $result->expires_in;
			$_SESSION['elvantoAccessRefresh'] = $result->refresh_token;

			header("Location: $elvantoRedirectURI");
			die();
		}
	}
	else
	{
		// Setup connection with auth details
		$auth_details = array(
			'access_token' => $_SESSION['elvantoAccessToken'],
			'refresh_token' => $_SESSION['elvantoAccessRefresh']
		);
		$elvanto = new Elvanto_API($auth_details);

		// Do stuff here
		include("header.php");

		if($_GET['nav'] == "")
		{
			echo '<h1 class="mt-5 text-center">Elvanto to Send In Blue one-click sync</h1>';
		}
		elseif($_GET['nav'] == "elvanto")
                {
                        echo '<h1 class="mt-5 text-center">Elvanto Groups</h1>';
			foreach($elvantoGroupIDs as $elvantoGroupID)
			{
				// Traverse the Group IDs array
				$results = $elvanto->call('groups/getInfo', array('id'=>$elvantoGroupID, 'fields'=>array('people')));

				echo "<pre>";
				var_dump($results);
				echo "</pre>";
			}
			// List basic details of all groups
                }
		else
		{
                        echo '<h1 class="mt-5 text-center">Page Does Not Exist</h1>';
			echo '<p class="lead text-center">Please use the navigation bar above to find the correct page.</p>';
		}

//		$results = $elvanto->call('people/getAll');
//		$results = $elvanto->call('groups/getAll');
//		$results = $elvanto->call('groups/getInfo', array('id'=>'1234', 'fields'=>array('people')));
//		echo "<pre>";
//		var_dump($results);
//		echo "</pre>";

		include("footer.php");
	}
?>
