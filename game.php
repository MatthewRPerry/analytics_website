<?php

$host = "x";
$user = "x";
$password = "x";
$db = "x";

// DB Connection.
$mysqli = new mysqli($host, $user, $password, $db);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}

$mysqli->set_charset('utf8');

$sql_winner = "SELECT * FROM players;";
$results_winner = $mysqli->query($sql_winner);
if ( $results_winner == false ) {
	echo $mysqli->error;
	exit();	
}


$sql_loser = "SELECT * FROM players;";
$results_loser = $mysqli->query($sql_loser);
if ( $results_loser == false ) {
	echo $mysqli->error;
	exit();	
}
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
            <a class="nav-item nav-link" href="players.php">Players</a>
            <a class="nav-item nav-link active" href="game.php">Add Game</a>
          </div>
        </div>
    </nav>

    <div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Add a game</h1>
		</div> 
    </div> 
    
    <div class="container">
		<form action="add_confirmation.php" method="POST">
            <div class="form-group row">
				<label for="winner-id" class="col-sm-3 col-form-label text-sm-right">Winner:</label>
				<div class="col-sm-9 col-md-6 col-lg-3">
					<select name="winner_id" id="winner-id" class="form-control" required>
                        <option value="" selected disabled>-- Select One --</option>
                        
                        <?php while ( $row = $results_winner->fetch_assoc() ) : ?>
							<option value="<?php echo $row['player_id']; ?>">
								<?php echo $row['name']; ?>
							</option>
						<?php endwhile; ?>

					</select>
				</div>
            </div>
            
            <div class="form-group row">
				<label for="wpoints-id" class="col-sm-3 col-form-label text-sm-right">Points: </label>
				<div class="col-sm-9 col-md-6 col-lg-3">
                    <input type="number" class="form-control" id="wpoints-id" name="wpoints" required>
                    <div class="w-error-message"></div>
				</div>
			</div>
            
            
            <div class="form-group row">
				<label for="loser-id" class="col-sm-3 col-form-label text-sm-right">Loser:</label>
				<div class="col-sm-9 col-md-6 col-lg-3">
					<select name="loser_id" id="loser-id" class="form-control" required>
						<option value="" selected disabled>-- Select One --</option>
                        <?php while ( $row = $results_loser->fetch_assoc() ) : ?>
							<option value="<?php echo $row['player_id']; ?>">
								<?php echo $row['name']; ?>
							</option>
						<?php endwhile; ?>
					</select>
				</div>
            </div> 
            
            <div class="form-group row">
				<label for="lpoints-id" class="col-sm-3 col-form-label text-sm-right">Points: </label>
				<div class="col-sm-9 col-md-6 col-lg-3">
                    <input type="number" class="form-control" id="lpoints-id" name="lpoints" required>
                    <div class="l-error-message"></div>
				</div>
			</div> 
            
            <div class="form-group row">
				<label for="date-id" class="col-sm-3 col-form-label text-sm-right">Date:</label>
				<div class="col-sm-9 col-md-6 col-lg-3">
					<input type="date" class="form-control" id="date-id" name="date" required>
				</div>
            </div> 
            
            <div class="form-group row">
				<div class="col-sm-9 col-md-6 col-lg-3 mt-2">
					<button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-light">Reset</button>
                    <div class="error-message" style="color:red;"></div>
				</div>
			</div>
        </form>
    </div>
    
    
    
    <hr class="my-2">
    <div class="row m-4">
        <i class="fas fa-table-tennis"></i>2335 Portland<i class="fas fa-table-tennis"></i>
    </div>


<script>
    document.querySelector("#winner-id").onchange = function(event){
        if (document.querySelector("#winner-id").value == document.querySelector("#loser-id").value){
            document.querySelector(".error-message").innerHTML = "Winner & Loser cannot match";
        }
        else{
            document.querySelector(".error-message").innerHTML = "";
        }
    }

    document.querySelector("#loser-id").onchange = function(event){
        if (document.querySelector("#winner-id").value == document.querySelector("#loser-id").value){
            document.querySelector(".error-message").innerHTML = "Winner & Loser cannot match";
        }
        else{
            document.querySelector(".error-message").innerHTML = "";
        }
    }
</script>
</body>
</html>