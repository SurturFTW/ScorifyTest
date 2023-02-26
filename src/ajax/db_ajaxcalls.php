<?php 
ob_start();
include("../../config/connect.php");
$status = get_con();

session_start();

$login_session = $_SESSION['name'];
$userId = $_SESSION['id'];

if(isset($_POST['flag'])){
    
    //Match Table
    $title = $_POST['title'];
    $venue = $_POST['venue'];
    $tossWon = $_POST['tossWon'];
    $tossResult = $_POST['tossResult'];
    $maxOvers = $_POST['maxOvers'];
    $result = $_POST['result'];

    //Team Table
    $teamOneName = $_POST['teamOneName'];
    $teamTwoName = $_POST['teamTwoName'];
    $teamOneRuns = $_POST['teamOneRuns'];
    $teamTwoRuns = $_POST['teamTwoRuns'];
    $teamOneBalls = $_POST['teamOneBalls'];
    $teamTwoBalls = $_POST['teamTwoBalls'];
    $teamOneWickets = $_POST['teamOneWickets'];
    $teamTwoWickets = $_POST['teamTwoWickets'];

    //Max Players
    $noOfPlayers = $_POST["noOfPlayers"];

    //Team 1 & 2 Players
    $team1Players = $_POST["team1"];
    $team2Players = $_POST["team2"];

    $con = get_con();

    
    // Insert into game table
    $match = "INSERT INTO `game` (`userid`, `title`, `venue`, `tossWon`, `tossResult`, `maxOvers`, `result`) VALUES ('$userId', '$title', '$venue', '$tossWon', '$tossResult', '$maxOvers', '$result');"; 
    if ($con->query($match) === TRUE) {
        echo "\nMatch Inserted";
    } 
    else {
        echo "Error 500";
    }


    // Get matchId from game table
    $getMatchId = "SELECT * FROM `game` WHERE `userid` = '$userId' AND `title` = '$title' AND `venue` = '$venue' AND `tossWon` = '$tossWon' AND `tossResult` = '$tossResult' AND `maxOvers` = '$maxOvers' AND `result` = '$result'";
    $result1 = $con->query($getMatchId);
    $row1 = $result1->fetch_assoc();
    $matchId = $row1['matchId'];


    // Insert into team table
    $team = "INSERT INTO `team` (`matchId`, `teamName`, `teamRuns`, `teamBalls`, `teamWickets`) VALUES ('$matchId', '$teamOneName', '$teamOneRuns', '$teamOneBalls', '$teamOneWickets');";
    $team2 = "INSERT INTO `team` (`matchId`, `teamName`, `teamRuns`, `teamBalls`, `teamWickets`) VALUES ('$matchId', '$teamTwoName', '$teamTwoRuns', '$teamTwoBalls', '$teamTwoWickets');";

    if ($con->query($team) && $con->query($team2) === TRUE) {
        echo "\nTeams Inserted";
    } 
    else {
        echo "Error 500";
    }

    
    // Get teamID for Team-1 from team table
    $getTeamId = "SELECT * FROM `team` WHERE `teamName` = '$teamOneName' AND `teamRuns` = '$teamOneRuns' AND `teamBalls` = '$teamOneBalls' AND `teamWickets` = '$teamOneWickets'";
    $result2 = $con->query($getTeamId);
    $row2 = $result2->fetch_assoc();
    $teamId = $row2['teamId'];

    
    // Insert into Player table for Team-1
    $playerNames1 = $team1Players[0];
    $playerRole1 = $team1Players[1];
    $playerStatus1 = $team1Players[2];

    $playerRunScored1 = $team1Players[3];
    $playerBallFaced1 = $team1Players[4];
    $playerBallDotted1 = $team1Players[5];
    $playerFourHitted1 = $team1Players[6];
    $playerSixHitted1 = $team1Players[7];
    $playerBallsBowled1 = $team1Players[8];
    $playerRunsGiven1 = $team1Players[9];
    $playerDotGiven1 = $team1Players[10];
    $playerMaidenGiven1 = $team1Players[11];
    $playerFourConsidered1 = $team1Players[12];
    $playerSixConsidered1 = $team1Players[13];
    $playerWideGiven1 = $team1Players[14];
    $playerNoBallGiven1 = $team1Players[15];
    $playerWicketTaken1 = $team1Players[16];

    for($i = 0; $i < $noOfPlayers; $i++){
        $player1 = "INSERT INTO `player` (`teamId`, `matchId`, `playerName`, `playerRole`, `playerStatus`) VALUES ('$teamId', '$matchId', '$playerNames1[$i]', '$playerRole1[$i]', '$playerStatus1[$i]');";

        if ($con->query($player1) === TRUE) {
            echo "\nPlayer Inserted";
        } 
        else {
            echo "Error 500";
        }
    }
    

    // Get playerId for Team-1 from player table
    $getPlayerId1 = "SELECT * FROM `player` WHERE `teamId` = '$teamId'";
    $result2 = $con->query($getPlayerId1);

    $j = 0;
    while ($row2 = $result2 -> fetch_assoc()) {
        $playerId = $row2['playerId'];

        //Insert into Score Table for Team-1
        $score1 = "INSERT INTO `score` (`matchId`, `teamId`, `playerId`, `runScored`, `ballFaced`, `ballDotted`, `fourHitted`, `sixHitted`, `ballsBowled`, `runGiven`, `dotGiven`, `maidenGiven`, `fourConsidered`, `sixConsidered`, `wideGiven`, `noBallGiven`, `wicketTaken`) 
            VALUES ('$matchId', '$teamId', '$playerId', '$playerRunScored1[$j]', '$playerBallFaced1[$j]', '$playerBallDotted1[$j]', '$playerFourHitted1[$j]', '$playerSixHitted1[$j]', '$playerBallsBowled1[$j]', '$playerRunsGiven1[$j]', 
            '$playerDotGiven1[$j]', '$playerMaidenGiven1[$j]', '$playerFourConsidered1[$j]', '$playerSixConsidered1[$j]', '$playerWideGiven1[$j]', '$playerNoBallGiven1[$j]', '$playerWicketTaken1[$j]')";
        
        if ($con->query($score1) === TRUE) {
            echo "\nScore Inserted";
        } 
        else {
            echo "Error 500";
        }
        $j = $j+1;
    }

///////////////////////////////////////////////////////////////////


    // Get teamID for Team-2 from team table
    $getTeamId = "SELECT * FROM `team` WHERE `teamName` = '$teamTwoName' AND `teamRuns` = '$teamTwoRuns' AND `teamBalls` = '$teamTwoBalls' AND `teamWickets` = '$teamTwoWickets'";
    $result2 = $con->query($getTeamId);
    $row2 = $result2->fetch_assoc();
    $teamId = $row2['teamId'];


    // Insert into Player table of Team-2
    $playerNames2 = $team2Players[0];
    $playerRole2 = $team2Players[1];
    $playerStatus2 = $team2Players[2];

    $playerRunScored2 = $team2Players[3];
    $playerBallFaced2 = $team2Players[4];
    $playerBallDotted2 = $team2Players[5];
    $playerFourHitted2 = $team2Players[6];
    $playerSixHitted2 = $team2Players[7];
    $playerBallsBowled2 = $team2Players[8];
    $playerRunsGiven2 = $team2Players[9];
    $playerDotGiven2 = $team2Players[10];
    $playerMaidenGiven2 = $team2Players[11];
    $playerFourConsidered2 = $team2Players[12];
    $playerSixConsidered2 = $team2Players[13];
    $playerWideGiven2 = $team2Players[14];
    $playerNoBallGiven2 = $team2Players[15];
    $playerWicketTaken2 = $team2Players[16];

    for($i = 0; $i < $noOfPlayers; $i++){
        $player2 = "INSERT INTO `player` (`teamId`, `matchId`, `playerName`, `playerRole`, `playerStatus`) VALUES ('$teamId', '$matchId', '$playerNames2[$i]', '$playerRole2[$i]', '$playerStatus2[$i]');";

        if ($con->query($player2) === TRUE) {
            echo "\nPlayer Inserted";
        } 
        else {
            echo "Error 500";
        }
    }
    

    // Get playerId for Team-1 from player table
    $getPlayerId2 = "SELECT * FROM `player` WHERE `teamId` = '$teamId'";
    $result3 = $con->query($getPlayerId2);

    $j = 0;
    while ($row3 = $result3 -> fetch_assoc()) {
        $playerId = $row3['playerId'];

        //Insert into Score Table for Team-1
        $score1 = "INSERT INTO `score` (`matchId`, `teamId`, `playerId`, `runScored`, `ballFaced`, `ballDotted`, `fourHitted`, `sixHitted`, `ballsBowled`, `runGiven`, `dotGiven`, `maidenGiven`, `fourConsidered`, `sixConsidered`, `wideGiven`, `noBallGiven`, `wicketTaken`) 
            VALUES ('$matchId', '$teamId', '$playerId', '$playerRunScored2[$j]', '$playerBallFaced2[$j]', '$playerBallDotted2[$j]', '$playerFourHitted2[$j]', '$playerSixHitted2[$j]', '$playerBallsBowled2[$j]', '$playerRunsGiven2[$j]', 
            '$playerDotGiven2[$j]', '$playerMaidenGiven2[$j]', '$playerFourConsidered2[$j]', '$playerSixConsidered2[$j]', '$playerWideGiven2[$j]', '$playerNoBallGiven2[$j]', '$playerWicketTaken2[$j]')";
        
        if ($con->query($score1) === TRUE) {
            echo "\nScore Inserted";
        } 
        else {
            echo "Error 500";
        }
        $j = $j+1;
    }
    
    $con->close();
}


ob_end_flush();
?>
