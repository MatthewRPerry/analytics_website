<?php

if ( !isset($_POST['winner_id']) || empty($_POST['winner_id']) ||
        !isset($_POST['loser_id']) || empty($_POST['loser_id']) ||
        !isset($_POST['wpoints']) || empty($_POST['wpoints']) ||
        !isset($_POST['lpoints']) || empty($_POST['lpoints']) ||
        !isset($_POST['date']) || empty($_POST['date'])) {
	$error = "Please fill out all required fields.";
}
else {
	$host = "303.itpwebdev.com";
	$user = "perrymat_db_user";
	$password = "uscItp2020!";
	$db = "perrymat_final_db";

	$mysqli = new mysqli($host, $user, $password, $db);
	if ( $mysqli->errno ) {
		echo $mysqli->error;
		exit();
    }

    $winner = $mysqli->real_escape_string($_POST["winner_id"]);
    $loser = $mysqli->real_escape_string($_POST["loser_id"]);
    $wpoints = $mysqli->real_escape_string($_POST["wpoints"]);
    $lpoints = $mysqli->real_escape_string($_POST["lpoints"]);
    $date = $mysqli->real_escape_string($_POST["date"]);

    $sql = "INSERT INTO matches(win_id, lose_id, win_points, lose_points, date)
            VALUES (" . $winner. ","
            . $loser
            . "," 
            . $wpoints
            . "," 
            . $lpoints
            . "," 
            . $date
            . ");";
    
    $results = $mysqli->query($sql);
	if(!$results) {
		echo $mysqli->error;
		exit();
    }
    
    if($mysqli->affected_rows == 1) {
		$isInserted = true;
	} else{
		$isInserted = false;
	}

    $mysqli->close();

    $to = 'mperry276@gmail.com'; 
  $from = 'sender@example.com'; 
  $fromName = 'SenderName'; 
 
  $subject = "New Match"; 
 
  $htmlContent = ' 
    <html> 
    <head> 
        <title>New Match Played!</title> 
    </head> 
    <body> 
        <h1>A New Match Water Played!</h1> 
        <p>Player '.$winner.' beat Player '.$loser.'!</p>
        <p>Score: '.$wpoints.'-'.$lpoints.'</p>
        <p>Date: '.$date.'</p>
    </body> 
    </html>'; 
 
$headers = 'Cc: perrymat@usc.edu' . "\r\n"; 
 
if(mail($to, $subject, $htmlContent, $headers)){ 
}else{ 
   echo 'Email sending failed.'; 
}
}

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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
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
            <a class="nav-item nav-link" href="players.html">Players</a>
            <a class="nav-item nav-link" href="game.php">Add Game</a>
          </div>
        </div>
    </nav>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Add a game</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

				<?php if( isset($error) && !empty($error)) :?>
					<div class="text-danger">
						<?php echo $error; ?>
					</div>
				<?php endif; ?>

				<?php if($isInserted): ?>

					<div class="text-success">
					Game was successfully added.
					</div>

				<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="game.php" role="button" class="btn btn-primary">Back to Add Game</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>
