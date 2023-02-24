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

    if ($con->query($team) === TRUE) {
        echo "\nTeam1 Inserted";
    } 
    else {
        echo "Error 500";
    }
    if ($con->query($team2) === TRUE) {
        echo "\nTeam2 Inserted";
    } 
    else {
        echo "Error 500";
    }
    
    // Get teamID for Team-1 from team table
    $getTeamId = "SELECT * FROM `team` WHERE `teamName` = '$teamOneName' AND `teamRuns` = '$teamOneRuns' AND `teamBalls` = '$teamOneBalls' AND `teamWickets` = '$teamOneWickets'";
    $result2 = $con->query($getTeamId);
    $row2 = $result2->fetch_assoc();
    $teamId = $row2['teamId'];
    
    // Insert into score table of Team-1
    $player1Name = $team1Players[0];
    $player1Role = $team1Players[1];
    $player1Status = $team1Players[2];
    $player1RunsScored = $team1Players[3];
    $player1Ballfaced = $team1Players[4];
    $player1BallDotted = $team1Players[5];
    $player1FourHitted = $team1Players[6];
    $player1SixHitted = $team1Players[7];
    $player1BallsBowled = $team1Players[8];
    $player1RunsGiven = $team1Players[9];
    $player1DotGiven = $team1Players[10];
    $player1MaidenGiven = $team1Players[11];
    $player1FourConsidered = $team1Players[12];
    $player1SixConsidered = $team1Players[13];
    $player1WideGiven = $team1Players[14];
    $player1NoBallGiven = $team1Players[15];
    $player1WicketTaken = $team1Players[16];

    for($i = 0; $i < $noOfPlayers; $i++){
        $player1 = "INSERT INTO `player` (`teamId`, `matchId`, `playerName`, `playerRole`) VALUES ('$teamId', '$matchId', '$player1Name[$i]', '$player1Role[$i]');";

        if ($con->query($player1) === TRUE) {
            echo "\nPlayer1 Inserted";
        } 
        else {
            echo "Error 500";
        }
    }

    //Get Player Id from Player Table
    $getplayerId = "SELECT * FROM `player` WHERE `matchId` = '$matchId' AND `playerName` = '$playerName' AND `playerRole` = '$playerRole'";
        $result3 = $con->query($getplayerId);
        $row3 = $result3->fetch_assoc();
        $playerId = $row3['playerId'];

    for($i = 0; $i < $noOfPlayers; $i++){
        $score1 = "INSERT INTO `score` (`matchId`, `teamId`, `playerId`, `runScored`, `ballFaced`) VALUES ('$matchId', '$teamId', '$player1Id', '$player1RunsScored[$i]', '$player1Ballfaced[$i]');";
        if ($con->query($score1) === TRUE) {
            echo "\nScore Inserted";
        } 
        else {
            echo "Error 500";
        }
    }

    // Get teamID for Team-2 from team table
    $getTeamId = "SELECT * FROM `team` WHERE `teamName` = '$teamTwoName' AND `teamRuns` = '$teamTwoRuns' AND `teamBalls` = '$teamTwoBalls' AND `teamWickets` = '$teamTwoWickets'";
    $result2 = $con->query($getTeamId);
    $row2 = $result2->fetch_assoc();
    $teamId = $row2['teamId'];

    // Insert into score table of Team-2
    $player2Name = $team2Players[0];
    $player2Role = $team2Players[1];
    $player2Status = $team2Players[2];
    $player2RunsScored = $team2Players[3];
    $player2Ballfaced = $team2Players[4];
    $player2BallDotted = $team2Players[5];
    $player2FourHitted = $team2Players[6];
    $player2SixHitted = $team2Players[7];
    $player2BallsBowled = $team2Players[8];
    $player2RunsGiven = $team2Players[9];
    $player2DotGiven = $team2Players[10];
    $player2MaidenGiven = $team2Players[11];
    $player2FourConsidered = $team2Players[12];
    $player2SixConsidered = $team2Players[13];
    $player2WideGiven = $team2Players[14];
    $player2NoBallGiven = $team2Players[15];
    $player2WicketTaken = $team2Players[16];

    for($i = 0; $i < $noOfPlayers; $i++){
        $score2 = "INSERT INTO `player` (`teamId`, `matchId`, `playerName`, `playerRole`) VALUES ('$teamId', '$matchId', '$player2Name[$i]', '$player2Role[$i]');";

        if ($con->query($score2) === TRUE) {
            echo "\nPlayer Inserted";
        } 
        else {
            echo "Error 500";
        }
        
    }

    $con->close();
}


ob_end_flush();
?>
