<?php 
ob_start();
include("../../config/connect.php");
$status = get_con();

session_start();

if (!isset($_SESSION['name'])) {
  // redirect if not set
  header("Location:../login.php");
}

$login_session = $_SESSION['name'];

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title> Scorify </title>
	<link rel="icon" href="../../imgs/logo.png">
	<link rel="stylesheet" href="../css/style.css">
	<link rel="stylesheet" href="assets/live.css">

</head>

<body>
	<link rel="stylesheet" href="../css/home.css">
	<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light px-3 shadow shadow-lg">
		<a class="navbar-brand" href="javascript:void(0)" onclick="loadHome()">
			<span class="fw-bold">
				<img src="../../imgs/logo.png" width="40" height="40" alt="">
				Scorify
			</span>
		</a>
		<a href="javascript:void(0)" class="h5 d-block d-lg-none" data-bs-toggle="collapse"
			data-bs-target="#nbcollapse">
			<img src="../../imgs/toggler.png" width="25" height="25" alt="">
		</a>

		<div class="collapse navbar-collapse" id="nbcollapse">
			<ul class="navbar-nav my-2 my-lg-0">
				<li class="nav-item mx-auto mx-lg-1 my-1 my-lg-0 shadow shadow-lg px-3 rounded-pill">
					<a class="nav-link active rounded-pill text-primary" aria-current="page" href="javascript:void(0)"
						onclick="newMatch()">
						<span>
							<img src="../../imgs/new-match.png" width="35" height="35" alt="">
						</span>
						<span> New match</span>
					</a>
				</li>
				<li id="running-match-nav"
					class="d-none nav-item mx-auto mx-lg-1 my-1 my-lg-0 shadow shadow-lg px-3 rounded-pill">
					<a class="nav-link active rounded-pill text-success" aria-current="page" href="javascript:void(0)"
						onclick="runningMatch()">
						<span>
							<img src="../../imgs/running-match.png" width="35" height="35" alt="">
						</span>
						<span> Running match</span>
					</a>
				</li>

				<li id="score-nav"
					class="d-none nav-item mx-auto mx-lg-1 my-1 my-lg-0 shadow shadow-lg px-3 pt-lg-1 rounded-pill">
					<a class="nav-link active rounded-pill text-success" aria-current="page" href="javascript:void(0)" onclick="teamFullCard(0)">
						<span>
							<img src="../../imgs/scoreboard.png" width="25" height="25" alt="">
						</span>
						<span> &nbspFull scorecard</span>
					</a>
				</li>

			</ul>
			<ul class="navbar-nav ms-auto">
				<li class="nav-item mx-1">
					<a class="nav-link active"> Welcome <?php echo $login_session; ?> </a>
				</li>
				<li class="nav-item mx-1">
					<a class="nav-link active" href="../login.php" id="signout" onclick="signout()">Sign Out</a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="container-fluid" id="main-container"></div>

	<div class="modal fade" id="error-modal" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Error Message</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div id="error-msg"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="new-match-modal" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Confirmation Message</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					A match is still running, Are you sure want to discard this match and start a new one?
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" id="new-match-btn" data-bs-dismiss="modal">Yes</button>
				</div>
			</div>
		</div>
	</div>
	</div>

	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="../js/route.js"></script>
	<script src="../js/setup.js"></script>
	<script src="../js/scoreboard.js"></script>
	<script src="../js/run.js"></script>
	<script src="../js/wicket.js"></script>
	<script src="../js/run_out.js"></script>
	<script src="../js/wide_ball.js"></script>
	<script src="../js/no_ball.js"></script>

	<script data-section-id="navbar" src="https://unpkg.com/@teleporthq/teleport-custom-scripts"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	

</body>
</html>