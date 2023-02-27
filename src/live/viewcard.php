<?php 
ob_start();
include("../../config/connect.php");
$status = get_con();

session_start();

if (!isset($_SESSION['name'])) {
  // redirect if not set
  header("Location:../login.php");
}

$userId = $_SESSION['id'];;

ob_end_flush();
?>

<br>
<label class="form-label text-success h5" for="match">Choose a match:</label>
	<select class="form-select bg-dark text-white" name="match" id="match">
  	<?php
		//get ref of user for match 
		$query = "SELECT * FROM `game` WHERE `userId` = '$userId'";
		$result = mysqli_query($status, $query);

		echo "<option value=" . "--" . ">" . "--" . "</option>";

		while ($row3 = $result -> fetch_assoc()) { 
			echo "<option value=" . $row3["matchId"] . ">" . $row3["title"] . "</option>";
		}
 ?>
</select>

<!--Team-1 Scorecard-->
<div class="mt-5 row d-flex justify-content-center mx-1 mx-lg-5 ">
	<div class="col-12 my-lg-0 col-lg-5 text-center shadow shadow-lg fw-bold mx-2 rounded-pill" id="teamOneCard" style="font-size: 1.3rem;">
		<span id="teamOneName" class="nav-link text-center active rounded-pill text-success" ></span>
	</div>

	<div class="my-5 mx-lg-5 px-2">
		<table class="table table-hover">
			<thead>
				<tr class=" fw-bold">
					<th>Batting</th>
					<th></th>
					<th>R</th>
					<th>B</th>
					<th>0s</th>
					<th>4s</th>
					<th>6s</th>
				</tr>
			</thead>
			<tbody id="battingCard1"> </tbody>
		</table>
	
		<div id="extraRuns"></div>
		<div class="my-3" id="scoreRateOver" style="font-size: 1.3rem;"> </div>
		<table class="table table-hover mt-5" id="bowlingTable1">
			<thead>
				<tr class="fw-bold">
					<th>Bowling</th>
					<th>O</th>
					<th>R</th>
					<th>M</th>
					<th>W</th>
					<th>Wd</th>
					<th>Nb</th>
				</tr>
			</thead>
		<tbody id="bowlingCard1"></tbody>
		</table>
	</div>

<!--Team-2 Scorecard-->
	<div class="col-11 mt-3 my-lg-0 col-lg-5 text-center shadow shadow-lg fw-bold mx-2 rounded-pill" id="teamTwoCard" style="font-size: 1.3rem;">
		<p id="teamTwoName" class="nav-link text-center active rounded-pill text-success" aria-current="page"> </p>
	</div>

	<div class="my-5 mx-lg-5 px-2">
		<table class="table table-hover">
			<thead>
				<tr class=" fw-bold">
					<th>Batting</th>
					<th></th>
					<th>R</th>
					<th>B</th>
					<th>0s</th>
					<th>4s</th>
					<th>6s</th>
				</tr>
			</thead>
			<tbody id="battingCard2"> </tbody>
		</table>
	
		<div id="extraRuns"></div>
		<div class="my-3" id="scoreRateOver" style="font-size: 1.3rem;"> </div>
		<table class="table table-hover mt-5" id="bowlingTable1">
			<thead>
				<tr class="fw-bold">
					<th>Bowlling</th>
					<th>O</th>
					<th>R</th>
					<th>M</th>
					<th>W</th>
					<th>Wd</th>
					<th>Nb</th>
				</tr>
			</thead>
		<tbody id="bowlingCard2"></tbody>
		</table>
	</div>
</div>

