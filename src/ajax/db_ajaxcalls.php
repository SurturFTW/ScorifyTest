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
    // Team Table
    $teamOneName = $_POST['teamOneName'];
    $teamTwoName = $_POST['teamTwoName'];
    $teamOneRuns = $_POST['teamOneRuns'];
    $teamTwoRuns = $_POST['teamTwoRuns'];
    $teamOneBalls = $_POST['teamOneBalls'];
    $teamTwoBalls = $_POST['teamTwoBalls'];
    $teamOneWickets = $_POST['teamOneWickets'];
    $teamTwoWickets = $_POST['teamTwoWickets'];
    
    $con = get_con();
    
    // Insert into game table
    $match = "INSERT INTO `game` (`userid`, `title`, `venue`, `tossWon`, `tossResult`, `maxOvers`, `result`) VALUES ('$userId', '$title', '$venue', '$tossWon', '$tossResult', '$maxOvers', '$result');"; 
    // $con->query($match);
    if ($con->query($match) === TRUE) {
        echo "Match Inserted";
    } 
    else {
        echo "Error 500";
    }

    // Get matchId from game table
    $getMatchId = "SELECT * FROM `game` WHERE `userid` = '" . $userId . " AND `title`='" . $title . " AND `venue` = '" . $venue . " AND `tossWon` ='" . $tossWon . " AND `tossResult` ='" . $tossResult . " AND `maxOvers` ='" . $maxOvers . " AND `result` ='" . $result . ";";
    $result1 = $con->query($getMatchId);
    $row1 = $result1->fetch_assoc();
    $matchId = $row1['matchId'];
    // Insert into team table
    $team = "INSERT INTO `team` (`matchId`, `teamOneName`, `teamTwoName`, `teamOneRuns`, `teamTwoRuns`, `teamOneBalls`, `teamTwoBalls`, `teamOneWickets`, `teamTwoWickets`) VALUES ('$matchId', '$teamOneName', '$teamTwoName', '$teamOneRuns', '$teamTwoRuns' , '$teamOneBalls', '$teamTwoBalls', '$teamOneWickets', '$teamTwoWickets');";

    if ($con->query($team) === TRUE) {
        echo "Team Inserted";
    } 
    else {
        echo "Error 500";
    }
    $con->close();
}

ob_end_flush();
?>
