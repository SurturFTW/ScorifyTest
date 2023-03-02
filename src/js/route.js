let view = (url, fun, params) => {
	const xhr = new XMLHttpRequest();
	xhr.open("GET", url);
	xhr.send();
	xhr.addEventListener("readystatechange", () => {
		if (xhr.readyState == 4) {
			document.querySelector("#main-container").innerHTML = xhr.responseText;
			fun(params);
		}
	});
};

let loadHome = () => {
	view("home.php", () => {
		let match = JSON.parse(localStorage.getItem("match"));

		if (match && match.title) {
			document.querySelector("#running-match-nav").classList.remove("d-none");
		}
		if (match && match.onStrikeBatsman) {
			document.querySelector("#score-nav").classList.remove("d-none");
			document.querySelector("#home-rm").classList.remove("d-none");
		}
	});
};

let loadScoreCard = () => {
	view("viewcard.php", () => {
		$("#match").on('change', (e) => {
			console.log(e);
			
			let match = $("#match").val();
			console.log(match);

			if(match == "--"){
				$("#teamOneName").hide();
				$("#teamTwoName").hide();
				$("#battingCard1").hide();
				$("#battingCard2").hide();
				$("#bowlingCard1").hide();
				$("#bowlingCard2").hide();
			}
			else{
				$("#teamOneName").show();
				$("#teamTwoName").show();
				$("#battingCard1").show();
				$("#battingCard2").show();
				$("#bowlingCard1").show();
				$("#bowlingCard2").show();
			//Team-1 Name
			$.ajax({
				url : "../ajax/db_ajaxcalls.php",
				type : "POST",
				data : {
					team1Name : "YES",
					matchId : match,
				},
				success: function (res) {
					$("#teamOneName").html(res);
				},
				error : function (err) {
					console.log(err);
				}	
			})

			//Team-2 Name
			$.ajax({
				url : "../ajax/db_ajaxcalls.php",
				type : "POST",
				data : {
					team2Name : "YES",
					matchId : match,
				},
				success: function (res) {
					$("#teamTwoName").html(res);
				},
				error : function (err) {
					console.log(err);
				}	
			})

			//Team-1 Batting
			$.ajax({
				url : "../ajax/db_ajaxcalls.php",
				type : "POST",
				data : {
					// team1PlayerNames : "YES",
					matchId : match,

					team1batting : "YES"
				},
				success: function (res) {
					$("#battingCard1").html(res);
				},
				error : function (err) {
					console.log(err);
				}	
			})

			//Team-2 Batting
			$.ajax({
				url : "../ajax/db_ajaxcalls.php",
				type : "POST",
				data : {
					// team2PlayerNames : "YES",
					matchId : match,

					team2batting : "YES"
				},
				success: function (res) {
					//console.log(res);
					$("#battingCard2").html(res);
				},
				error : function (err) {
					console.log(err);
				}	
			})

			//Team-1 Bowling
			$.ajax({
				url : "../ajax/db_ajaxcalls.php",
				type : "POST",
				data : {
					// team1PlayerNames : "YES",
					matchId : match,

					team1bowling : "YES"
				},
				success: function (res) {
					//console.log(res);
					$("#bowlingCard1").html(res);
				},
				error : function (err) {
					console.log(err);
				}	
			})

			//Team-2 Bowling
			$.ajax({
				url : "../ajax/db_ajaxcalls.php",
				type : "POST",
				data : {
					// team2PlayerNames : "YES",
					matchId : match,

					team2bowling : "YES",
				},
				success: function (res) {
					//console.log(res);
					$("#bowlingCard2").html(res);
				},
				error : function (err) {
					console.log(err);
				}	
			})
		}
		})
	})
}


let loadScoreBoardAdditional = () => {
	let match = JSON.parse(localStorage.getItem("match"));

	let options = {
		weekday: "long",
		year: "numeric",
		month: "long",
		day: "numeric",
	};
	let date_time = new Date(match.startTime);
	date_time = date_time.toLocaleDateString("en-US", options);
	document.querySelector(
		"#toss-win"
	).innerHTML = `${match.tossWonBy}, chose to ${match.tossDecision} | `;

	let ii = match.runningInnings == 0 ? "1st" : "2nd";
	document.querySelector(
		"#innings-indicator"
	).innerHTML = `${ii} innings running`;
	document.querySelector(
		"#match-heading"
	).innerHTML = `${match.title} <span class="text-dark fw-bold">|</span> ${date_time} <span class="text-dark fw-bold">|</span> ${match.teams[0]} vs ${match.teams[1]} <span class="text-dark fw-bold">|</span> ${match.venue}`;

	loadScore();

	if (
		!match.verdict ||
		(match.verdict &&
			!match.verdict.includes("won") &&
			!match.verdict.includes("tied"))
	) {
		for (yy of document.querySelectorAll(".score-counter")) {
			yy.classList.remove("d-none");
		}
	}
};

let runningMatch = () => {
	if (localStorage.getItem("match") === null) {
		view("details.php", () => {});
	} else {
		match = JSON.parse(localStorage.getItem("match"));
		if (match.onStrikeBatsman) {
			view("play.php", loadScoreBoardAdditional);
		} else if (match.teamLineUp && match.teamLineUp[1].length > 0) {
			view("openers.php", setDomOpeners);
		} else if (match.teamLineUp && match.teamLineUp[0].length > 0) {
			view("lineup_1.php", setDomLineUp, 1);
		} else if (match.tossWonBy) {
			view("lineup_0.php", setDomLineUp, 0);
		} else if (match.title) {
			view("toss.php", setDomToss);
		}
	}
};

let teamFullCard = (track) => {
	view("scorecard.php", loadFullScorecard, track);
};

window.addEventListener("load", () => {
	loadHome();
});
