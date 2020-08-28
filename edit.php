<?php

$host = "303.itpwebdev.com";
$user = "perrymat_db_user";
$password = "uscItp2020!";
$db = "perrymat_final_db";

if( !isset($_GET['player_id']) || empty($_GET['player_id']) ) {
	echo "Invalid Player ID";
	exit();
}

// DB Connection.
$mysqli = new mysqli($host, $user, $password, $db);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}

$mysqli->set_charset('utf8');

$sql = "SELECT players.player_id as id, players.name as name, cities.city as city, cities.state as state
        from players
        join cities
	        on players.city_id = cities.city_id
        where players.player_id = ". $_GET["player_id"] . ";";
$results = $mysqli->query($sql);
if ( $results == false ) {
	echo $mysqli->error;
	exit();	
}

$row = $results->fetch_assoc();

$mysqli->close();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    

    <link href="styles.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/80730e8ea1.js" crossorigin="anonymous"></script>
    <script
	src="http://code.jquery.com/jquery-3.5.1.min.js"
	integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <title></title>
</head>
<body>

    <nav class="navbar navbar-expand-md navbar-light navbar-custom">
        <a class="navbar-brand" href="index.php"><i class="fas fa-home"></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-item nav-link" href="stats.php">Stats</a>
            <a class="nav-item nav-link" href="players.php">Players</a>
            <a class="nav-item nav-link" href="game.php">Add Game</a>
          </div>
        </div>
    </nav>

    <div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Edit a Player</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

			<div class="col-12 text-danger">
			<?php
			if (!$results) {
				echo $mysqli->error;
						exit();
			}
			?>
			</div>

			<form action="edit_confirmation.php" method="POST">

				<div class="form-group row">
					<label for="player-id" class="col-sm-3 col-form-label text-sm-right">Name:</label>
					<div class="col-sm-9">
						<input type="hidden" class="form-control" name="player_id" value="<?php echo $row['id'];?>" >
						<input type="text" class="form-control" id="player-id" name="player" value="<?php echo $row['name'];?>" required >
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="city-id" class="col-sm-3 col-form-label text-sm-right">City:</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="city-id" name="city" value="<?php echo $row['city'];?>" required>
					</div>
                </div> <!-- .form-group -->
                
                <div class="form-group row">
					<label for="state-id" class="col-sm-3 col-form-label text-sm-right">State:</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="state-id" name="state" value="<?php echo $row['state'];?>" required>
					</div>
                </div> <!-- .form-group -->
                
                <div class="form-group row">
					<div class="col-sm-3"></div>
					<div class="col-sm-9 mt-2">
						<button type="submit" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-light">Reset</button>
					</div>
				</div> <!-- .form-group -->

			</form>

	</div> <!-- .container -->
</body>
</html>