<?php
	if(!($configLocalLoaded || $configLoaded))
	{
		die();
	}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Elvanto to Send In Blue sync</title>
  </head>
  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
      <div class="container">
        <a class="navbar-brand" href=".">Elvanto to Send In Blue</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item<?php echo ($_GET['nav'] == "" ? ' active' : ''); ?>">
              <a class="nav-link" href=".">Sync
                <?php echo ($_GET['nav'] == "" ? '<span class="sr-only">(current)</span>' : ''); ?>
              </a>
            </li>
            <li class="nav-item<?php echo ($_GET['nav'] == "preview" ? ' active' : ''); ?>">
              <a class="nav-link" href="?nav=preview">Preview
                <?php echo ($_GET['nav'] == "preview" ? '<span class="sr-only">(current)</span>' : ''); ?>
              </a>
            </li>
            <li class="nav-item<?php echo ($_GET['nav'] == "elvanto" ? ' active' : ''); ?>">
              <a class="nav-link" href="?nav=elvanto">Elvanto
                <?php echo ($_GET['nav'] == "elvanto" ? '<span class="sr-only">(current)</span>' : ''); ?>
              </a>
            </li>
            <li class="nav-item<?php echo ($_GET['nav'] == "sendinblue" ? ' active' : ''); ?>">
              <a class="nav-link" href="?nav=sendinblue">Send In Blue
                <?php echo ($_GET['nav'] == "sendinblue" ? '<span class="sr-only">(current)</span>' : ''); ?>
              </a>
            </li>
            <li class="nav-item<?php echo ($_GET['nav'] == "settings" ? ' active' : ''); ?>">
              <a class="nav-link" href="?nav=settings">Settings
                <?php echo ($_GET['nav'] == "settings" ? '<span class="sr-only">(current)</span>' : ''); ?>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12">

