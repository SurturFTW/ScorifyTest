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
    $playerNames1 = $team1Players[0];
    $playerRole1 = $team1Players[1];

    for($i = 0; $i < $noOfPlayers; $i++){
        $score1 = "INSERT INTO `player` (`teamId`, `matchId`, `playerName`, `playerRole`) VALUES ('$teamId', '$matchId', '$playerNames1[$i]', '$playerRole1[$i]');";

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
    $playerNames2 = $team2Players[0];
    $playerRole2 = $team2Players[1];

    for($i = 0; $i < $noOfPlayers; $i++){
        $score1 = "INSERT INTO `player` (`teamId`, `matchId`, `playerName`, `playerRole`) VALUES ('$teamId', '$matchId', '$playerNames2[$i]', '$playerRole2[$i]');";

        if ($con->query($score1) === TRUE) {
            echo "\nScore Inserted";
        } 
        else {
            echo "Error 500";
        }
    }


    $con->close();
}


ob_end_flush();
?>
