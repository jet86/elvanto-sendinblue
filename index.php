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

		include("header.php");

		if($_GET['nav'] == "")
		{
			echo '<h1 class="mt-5 text-center">Elvanto to Send In Blue one-click sync</h1>';
		}
		elseif($_GET['nav'] == "elvanto")
                {
                        echo '<h1 class="mt-5 text-center">Elvanto Groups</h1>' . "\n";
			echo '  <div class="accordion" id="elvantoGroups">' . "\n";
			$elvantoGroupCount = 1;
			foreach($elvantoGroupIDs as $elvantoGroupID)
			{
				// Traverse the Group IDs array
				$results = $elvanto->call('groups/getInfo', array('id'=>$elvantoGroupID, 'fields'=>array('people')));
				$elvantoGroup = $results->group[0];

				echo '    <div class="card">' . "\n" . '      <div class="card-header" id="heading' . $elvantoGroupCount;
				echo '"><h5 class="mb-0">';
				echo '<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse' . $elvantoGroupCount;
				echo '" aria-expanded="false" aria-controls="collapse' . $elvantoGroupCount . '">';

				echo $elvantoGroup->name . "</button></h5></div>\n";

				echo '      <div id="collapse' . $elvantoGroupCount;
				echo '" class="collapse" aria-labelledby="heading' . $elvantoGroupCount;
				echo '" data-parent="#elvantoGroups">' . "\n" . '        <div class="card-body">' . "\n";

				$elvantoGroupMembers = $elvantoGroup->people->person;
				$elvantoGroupMemberCount = 0;

				// setup table
				echo '          <table class="table table-sm table-hover">';
				echo '<thead><tr><td>Name</td><td>Email</td></tr></thead>';
				echo '<tbody>' . "\n";

				foreach($elvantoGroupMembers as $elvantoGroupMember)
				{
					if($elvantoGroupMember->email)
					{
						// Populate row with basic member info
						echo '            <tr><td>' . $elvantoGroupMember->firstname . ' ' . $elvantoGroupMember->lastname . '</td>';
						echo '<td>' . $elvantoGroupMember->email . "</td></tr>\n";
						$elvantoGroupMemberCount++;
					}
				}

				echo '          </tbody></table>';
				echo "$elvantoGroupMemberCount members\n";
				echo "        </div>\n      </div>\n    </div>\n";

				$elvantoGroupCount++;

				/**-/
				echo "<pre>";
				var_dump($elvantoGroupMembers);
				echo "</pre><br><br>";
				/**/
			}
			echo "</div>\n";
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
