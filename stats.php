<?php

$host = "303.itpwebdev.com";
$user = "perrymat_db_user";
$password = "uscItp2020!";
$db = "perrymat_final_db";

// DB Connection
$mysqli = new mysqli($host, $user, $password, $db);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}

$mysqli->set_charset('utf8');

$sql_wins = "SELECT players.name as name, wins.win_count as wins
                from wins
                join players
	                on wins.win_id = players.player_id
                order by wins.win_count desc;";

$results_wins = $mysqli->query($sql_wins);

if ( $results_wins == false ) {
	echo $mysqli->error;
	exit();
}

$sql_loss = "SELECT players.name as name, losses.loss_count as losses
            from losses
            join players
	            on losses.lose_id = players.player_id
            order by losses.loss_count desc;";

$results_loss = $mysqli->query($sql_loss);

if ( $results_loss == false ) {
	echo $mysqli->error;
	exit();
}

$sql_points = "SELECT players.name, num_wins.sum as wins, num_losses.sum as losses
                from num_wins
                join num_losses
	                on num_wins.win_id = num_losses.lose_id
                join players
	                on num_wins.win_id = players.player_id
                order by (num_wins.sum + num_losses.sum) desc;";

$results_points = $mysqli->query($sql_points);

if ( $results_points == false ) {
	echo $mysqli->error;
	exit();
}

$sql_games = "SELECT players.name as name, wins.win_count as wins, losses.loss_count as losses
                from wins
                join losses
	                on wins.win_id = losses.lose_id
                join players
	                on wins.win_id = players.player_id
                order by wins+losses desc;";

$results_games = $mysqli->query($sql_games);

if ( $results_games == false ) {
	echo $mysqli->error;
	exit();
}

$sql_perc = "SELECT players.name as name, wins.win_count as wins, losses.loss_count as losses
                from wins
                join losses
	                on wins.win_id = losses.lose_id
                join players
	                on wins.win_id = players.player_id
                order by wins/(wins+losses) desc;";

$results_perc = $mysqli->query($sql_perc);

if ( $results_perc == false ) {
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
            <a class="nav-item nav-link active" href="stats.php">Stats</a>
            <a class="nav-item nav-link" href="players.php">Players</a>
            <a class="nav-item nav-link" href="game.php">Add Game</a>
          </div>
        </div>
    </nav>
      

    <div class="container">
        <div class="row m-3 p-4">
            <div class="col-12 col-md-6 col-lg-4 p-4 stat">
                <?php  $row = $results_wins->fetch_assoc();?>
                <div class="stat-text">Wins</div>
                <div class="stat-box" style="background-image: url('images/<?php echo $row['name']; ?>.jpg');"></div>
                <div class="stat-winner">
                    <i class="fas fa-crown"></i>
                    <span><?php echo $row['name']; ?> </span>
                    <span class="count"><?php echo $row['wins']; ?></span>
                </div>

                    <ul class="list">
                        <?php for ( $i = 2; $i <= 6; $i++) : ?>
                        <?php  $row = $results_wins->fetch_assoc();?>
                        <li class="list">
                            <span class="rank"><?php echo $i; ?></span>
                                <?php echo $row['name']; ?>
                            <span class="count"><?php echo $row['wins']; ?></span>
                        </li>
                        <?php endfor; ?>
                    </ul>

            </div>

            <div class="col-12 col-md-6 col-lg-4 p-4 stat">
                <div class="stat-text">Win Percentage</div>
                <?php  $row = $results_perc->fetch_assoc();?>
                <div class="stat-box" style="background-image: url('images/<?php echo $row['name']; ?>.jpg');"></div>
                <div class="stat-winner">
                    <i class="fas fa-crown"></i>
                    <span><?php echo $row['name']; ?></span>
                    <span class="count"><?php echo $row['wins']/($row['wins']+$row['losses']); ?></span>
                </div>

                    <ul class="list">
                    <?php for ( $i = 2; $i <= 6; $i++) : ?>
                        <?php  $row = $results_perc->fetch_assoc();?>
                        <li class="list">
                            <span class="rank"><?php echo $i; ?></span>
                                <?php echo $row['name']; ?>
                            <span class="count"><?php echo $row['wins']/($row['wins']+$row['losses']);?></span>
                        </li>
                    <?php endfor; ?>
                    </ul>

            </div>

            <div class="col-12 col-md-6 col-lg-4 p-4 stat">
                <div class="stat-text">Games</div>
                <?php  $row = $results_games->fetch_assoc();?>
                <div class="stat-box" style="background-image: url('images/<?php echo $row['name']; ?>.jpg');"></div>
                <div class="stat-winner">
                    <i class="fas fa-crown"></i>
                    <span><?php echo $row['name']; ?></span>
                    <span class="count"><?php echo $row['wins']+$row['losses']; ?></span>
                </div>

                    <ul class="list">
                    <?php for ( $i = 2; $i <= 6; $i++) : ?>
                        <?php  $row = $results_games->fetch_assoc();?>
                        <li class="list">
                            <span class="rank"><?php echo $i; ?></span>
                                <?php echo $row['name']; ?>
                            <span class="count"><?php echo $row['wins']+$row['losses']; ?></span>
                        </li>
                        <?php endfor; ?>
                    </ul>

            </div>

            <div class="col-12 col-md-6 col-lg-4 p-4 stat">
                <div class="stat-text">Points</div>
                <?php  $row = $results_points->fetch_assoc();?>
                <div class="stat-box" style="background-image: url('images/<?php echo $row['name']; ?>.jpg');"></div>
                <div class="stat-winner">
                    <i class="fas fa-crown"></i>
                    <span><?php echo $row['name']; ?></span>
                    <span class="count"><?php echo $row['wins']+$row['losses']; ?></span>
                </div>

                    <ul class="list">
                    <?php for ( $i = 2; $i <= 6; $i++) : ?>
                        <?php  $row = $results_points->fetch_assoc();?>
                        <li class="list">
                            <span class="rank"><?php echo $i; ?></span>
                                <?php echo $row['name']; ?>
                            <span class="count"><?php echo $row['wins']+$row['losses']; ?></span>
                        </li>
                        <?php endfor; ?>
                    </ul>

            </div>

            <div class="col-12 col-md-6 col-lg-4 p-4 stat">
                <div class="stat-text">Losses</div>
                <?php  $row = $results_loss->fetch_assoc();?>
                <div class="stat-box" style="background-image: url('images/<?php echo $row['name']; ?>.jpg');"></div>
                <div class="stat-winner">
                    <i class="fas fa-crown"></i>
                    <span><?php echo $row['name']; ?> </span>
                    <span class="count"><?php echo $row['losses']; ?> </span>
                </div>

                    <ul class="list">
                        <?php for ( $i = 2; $i <= 6; $i++) : ?>
                        <?php  $row = $results_loss->fetch_assoc();?>
                        <li class="list">
                            <span class="rank"><?php echo $i; ?></span>
                                <?php echo $row['name']; ?>
                            <span class="count"><?php echo $row['losses']; ?></span>
                        </li>
                        <?php endfor; ?>
                    </ul>

            </div>
            
        </div>
        <hr class="my-2">
        <div class="row m-4">
            <i class="fas fa-table-tennis"></i>2335 Portland<i class="fas fa-table-tennis"></i>
        </div>
    </div>


    <script>
        $(".stat").on("click", function() {
            $(this).children("ul").slideToggle(300);
            
        });
    </script>
</body>
</html>

