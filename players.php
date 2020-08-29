<?php

$host = "x";
$user = "x";
$password = "x";
$db = "x";

// DB Connection
$mysqli = new mysqli($host, $user, $password, $db);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}

$mysqli->set_charset('utf8');

$sql = "SELECT players.player_id as id, players.name as name, cities.city as city, cities.state as state
        from players
        join cities
	        on players.city_id = cities.city_id;";

$results = $mysqli->query($sql);

if ($results == false){
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
            <a class="nav-item nav-link active" href="players.php">Players</a>
            <a class="nav-item nav-link" href="game.php">Add Game</a>
          </div>
        </div>
    </nav>
      

    <div class="container">
        <div class="row m-3 p-4">
        <?php while ( $row = $results->fetch_assoc() ) : ?>
        
            <div class="col-12 col-md-6 col-lg-4 p-4 player">
                <div class="player-name"><?php echo $row['name']; ?></div>
                <div><img class="player-pic" src="images/<?php echo $row['name']; ?>.jpg" alt="<?php echo $row['name']; ?>"></div>
                <div class="player-info">
                    <span>City: <?php echo $row['city']; ?>, <?php echo $row['state']; ?></span>
                    <a href="edit.php?player_id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                </div>
            </div>
        <?php endwhile ?> 

            
        </div>
        <hr class="my-2">
        <div class="row m-4">
            <i class="fas fa-table-tennis"></i>2335 Portland<i class="fas fa-table-tennis"></i>
        </div>
    </div>
</body>
</html>

