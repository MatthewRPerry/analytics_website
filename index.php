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

$sql_recent = "SELECT match_id, p1.name as p1, p2.name as p2, win_points, lose_points from matches
        join players p1
	        on matches.win_id = p1.player_id
        join players p2
	        on matches.lose_id = p2.player_id
        order by match_id desc";

$results_recent = $mysqli->query($sql_recent);

$sql_board = "SELECT players.name as name, wins.win_count as wins, losses.loss_count as losses
            from wins
            join losses
	            on wins.win_id = losses.lose_id
            join players
            on wins.win_id = players.player_id";
            
$results_board = $mysqli->query($sql_board);

if ( $results_recent == false ) {
	echo $mysqli->error;
	exit();
}

if ($results_board == false){
    echo $mysqli->error;
	exit();
}

$num =1;

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
            <a class="nav-item nav-link" href="game.php">Add Game</a>
          </div>
        </div>
    </nav>
      
    <div class="jumbotron"  id="header" style="background-image: url('images/background.jpg');">
        <div class="container">
          <h1 class="display-4"><i class="fas fa-table-tennis"></i>2335 Portland Ping Pong<i class="fas fa-table-tennis"></i></h1>
        </div>
    </div>

    <div class="container" id="wrapper">
        <div class="row m-4 p-4">
            <div class="col-12 col-md-6 p-2">
                <div class="title"><h2>Recent Matches</h2></div>
                <div>
                    <table class="table table-hover table-responsive mt-4">
					<thead>
						<tr>
                            
							<th><i class="fas fa-trophy"></i></th>
							<th><i class="fas fa-skull-crossbones"></i></th>
                            <th>Score</th>
                            <th><th>
						</tr>
					</thead>
					<tbody>
                    <?php for ( $i = 0; $i < 5; $i++) : ?>
                        <tr>
                            
                            <?php $row = $results_recent->fetch_assoc()?>
                            
                            <td><?php echo $row['p1']; ?></td>
							<td><?php echo $row['p2']; ?></td>
                            <td><?php echo $row['win_points']; ?> - <?php echo $row['lose_points']; ?></td>
                            <td>
								<a onclick="return confirm('Are you sure you want to delete this match?');" href="delete.php?match_id=<?php echo $row['match_id']; ?>" class="btn btn-outline-danger">
										Delete
								</a>
							</td>
                        </tr>
                    <?php endfor; ?>
                    </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 col-md-6 p-2">
                <img src="images/pong.jpg" alt="Ping Pong" class="img-fluid">
            </div>
        </div>
        <hr class="my-4">
        <div class="row m-4 p-4 ">
            <div class="col-12 p-2 container-fluid">
                <div class="title center"><h2>Leaderboard</h2></div>
                <div>
                    <table class="table table-hover table-responsive mt-4 ">
					<thead class="container-fluid">
						<tr>
							<th><i class="fas fa-hashtag"></i></th>
							<th><i class="fas fa-user"></i></th>
							<th>Wins</th>
                            <th>Losses</th>
                            <th><i class="fas fa-percent"></i></th>
						</tr>
					</thead>
					<tbody>
                    <?php while ( $row = $results_board->fetch_assoc() ) : ?>
                        <tr class="table">
                            <td><?php echo $num; ?></td>
							<td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['wins']; ?></td>
                            <td><?php echo $row['losses']; ?></td>
                            <?php $percent = $row['wins'] / ($row['wins'] + $row['losses']) ?>
                            <td><?php echo $percent; ?></td>
                        </tr>
                        <?php $num = $num+1 ?>
                    <?php endwhile ?>    
                    </tbody>
                    </table>
                </div>
            </div> 
        </div>
        <hr class="my-2">
        <div class="row m-4">
            <i class="fas fa-table-tennis"></i>2335 Portland<i class="fas fa-table-tennis"></i>
        </div>
    </div>
</body>
</html>