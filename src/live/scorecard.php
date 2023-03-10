<?php
session_start(); 
?>

<div class="mt-5 row d-flex justify-content-center mx-1 mx-lg-5 ">
	<div class="col-12 my-lg-0 col-lg-5 text-center shadow shadow-lg fw-bold mx-2 rounded-pill" id="teamOneCard"
		style="font-size: 1.3rem;">
		<a id="teamOneName" class="nav-link active rounded-pill text-success" aria-current="page"
			href="javascript:void(0)" onclick="teamFullCard(0)">
		</a>
	</div>
	<div class="col-12 mt-3 my-lg-0 col-lg-5 text-center shadow shadow-lg fw-bold mx-2 rounded-pill" id="teamTwoCard"
		style="font-size: 1.3rem;">
		<a id="teamTwoName" class="nav-link active rounded-pill text-success" aria-current="page"
			href="javascript:void(0)" onclick="teamFullCard(1)">
		</a>
	</div>
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
				<th>SR</th>
				<th>role</th>
			</tr>
		</thead>
		<tbody id="battingCard">
		</tbody>
	</table>
	<div id="extraRuns"></div>
	<div class="my-3" id="scoreRateOver" style="font-size: 1.3rem;">
	</div>
	<table class="table table-hover mt-5" id="bowlingTable">
		<thead>
			<tr class="fw-bold">
				<th>Bowling</th>
				<th>O</th>
				<th>R</th>
				<th>M</th>
				<th>W</th>
				<th>Eco</th>
				<th>0s</th>
				<th>4s</th>
				<th>6s</th>
				<th>Wd</th>
				<th>Nb</th>
			</tr>
		</thead>
		<tbody id="bowlingCard">
		</tbody>
	</table>

	<div class="bridge">
		<input type="button" class="mt-3 mx-1 btn btn-lg btn-primary rounded-pill" value="Save" id="savedata">
	</div>
</div>


