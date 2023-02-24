let getVerdict = () => {
	// returns one of four three integers
	// 1 = first innings running
	// 2 = first innings ends
	// 3 = second innings running
	// 4 = second innings ends
	let match = JSON.parse(localStorage.getItem("match"));
	let track = match.batting == match.teams[0] ? 0 : 1;
	let firstInningsOver = false;
	let crr = (
		(match.teamScoreboard[track].totalRunScored /
			match.teamScoreboard[track].ballsPlayed) *
		6
	).toFixed(2);
	if (match.teamScoreboard[track].ballsPlayed == 0) {
		crr = "0.00";
	}

	match.verdictFlag = 1;
	// first innings
	if (match.runningInnings == 0) {
		match.verdict = `Current run rate: ${crr}`;
		let prevMsg = "";
		if (
			// if all out
			match.noOfPlayers ==
			match.teamScoreboard[track].wicketFall + 1
		) {
			firstInningsOver = true;
			prevMsg = `All out<br>${match.lastWicketFallMessage}`;
		} else if (
			// if over is completed
			match.noOfOvers * 6 ==
			match.teamScoreboard[track].ballsPlayed
		) {
			firstInningsOver = true;
			prevMsg = `${match.noOfOvers} over is completed<br>`;
		}
		if (firstInningsOver) {
			match.verdictFlag = 2;
			new bootstrap.Modal(
				document.querySelector("#second-innings-modal")
			).show();
			document.querySelector(
				"#second-innings-message"
			).innerHTML = `${prevMsg}<br>${match.batting} - ${
				match.teamScoreboard[track].totalRunScored
			}/${match.teamScoreboard[track].wicketFall}<br>${match.fielding} Needs ${
				match.teamScoreboard[track].totalRunScored + 1
			} runs to win from ${match.noOfOvers} overs at ${(
				(match.teamScoreboard[track].totalRunScored + 1) /
				match.noOfOvers
			).toFixed(2)} RPO`;

			document.querySelector("#proceed").addEventListener("click", () => {
				console.log("procedd clicked");
				match.runningInnings = 1;
				[match.batting, match.fielding] = [match.fielding, match.batting];
				match.onStrikeBatsman = "";
				match.nonStrikeBatsman = "";
				match.onStrikeBowler = "";
				localStorage.setItem("match", JSON.stringify(match));
				for (yy of document.querySelectorAll(".score-counter")) {
					yy.classList.add("d-none");
				}
				view("openers.php", setDomOpeners);
			});
		}
	}

	// second innings
	else {
		match.verdictFlag = 3;
		// console.log("second");
		// match running = wickets in hand and balls remaining
		// match ended = all out or ball is over
		// match results with wickets in hand and balls remaining
		let runsNeeded =
			match.teamScoreboard[1 - track].totalRunScored -
			match.teamScoreboard[track].totalRunScored +
			1;
		let remBowls =
			match.noOfOvers * 6 - match.teamScoreboard[track].ballsPlayed;
		let rr = ((runsNeeded / remBowls) * 6).toFixed(2);

		if (
			match.teamScoreboard[track].totalRunScored ==
			match.teamScoreboard[1 - track].totalRunScored
		) {
			// score level, 2 possibilities either score level if match running or match tied if match ended
			if (
				match.teamScoreboard[track].wicketFall + 1 < match.noOfPlayers &&
				remBowls > 0
			) {
				//match running
				match.verdict = `current rate: ${crr} | score is level, needs 1 run from ${remBowls} balls | required rate: ${rr}`;
			} else if (
				match.teamScoreboard[track].wicketFall + 1 == match.noOfPlayers ||
				remBowls == 0
			) {
				// All out or balls over
				match.verdictFlag = 4;
				match.verdict = "Match tied";
				for (yy of document.querySelectorAll(".score-counter")) {
					yy.classList.add("d-none");
				}
			}
		} else if (
			match.teamScoreboard[track].totalRunScored <
			match.teamScoreboard[1 - track].totalRunScored
		) {
			// runs needed, two possibilities, either lose or to fillup target
			if (
				match.teamScoreboard[track].wicketFall + 1 == match.noOfPlayers ||
				remBowls == 0
			) {
				match.verdictFlag = 4;
				match.verdict = `${match.fielding} won by ${runsNeeded - 1} runs`;
				for (yy of document.querySelectorAll(".score-counter")) {
					yy.classList.add("d-none");
				}
			} else if (
				match.teamScoreboard[track].wicketFall + 1 < match.noOfPlayers &&
				remBowls > 0
			) {
				match.verdict = `current rate: ${crr} | needs ${runsNeeded} runs from ${remBowls} balls | required rate: ${rr}`;
			}
		} else if (
			match.teamScoreboard[track].totalRunScored >
			match.teamScoreboard[1 - track].totalRunScored
		) {
			// team batting second wins
			match.verdictFlag = 4;
			match.verdict = `${match.batting} won by ${
				match.noOfPlayers - 1 - match.teamScoreboard[track].wicketFall
			} wickets with ${remBowls} balls remaining.`;
			for (yy of document.querySelectorAll(".score-counter")) {
				yy.classList.add("d-none");
			}
		}
	}
	document.querySelector("#verdict").innerHTML = match.verdict;
	localStorage.setItem("match", JSON.stringify(match));
};

let loadScore = () => {
	let match = JSON.parse(localStorage.getItem("match"));
	let track = match.batting == match.teams[0] ? 0 : 1;

	let batsmanId1 = match.teamLineUp[track].findIndex(
		(playerObj) => playerObj.name == match.onStrikeBatsman
	);
	let batsmanId2 = match.teamLineUp[track].findIndex(
		(playerObj) => playerObj.name == match.nonStrikeBatsman
	);
	let bowlerId = match.teamLineUp[1 - track].findIndex(
		(playerObj) => playerObj.name == match.onStrikeBowler
	);

	let batsman1 = match.teamLineUp[track][batsmanId1];
	match.teamLineUp[track][batsmanId1].hasBatted = true;
	match.teamLineUp[track][batsmanId2].hasBatted = true;
	let batsmanOneStrikeRate = (
		(batsman1.runScored * 100) /
		batsman1.ballFaced
	).toFixed(2);
	if (batsman1.ballFaced == 0) {
		batsmanOneStrikeRate = 0.0;
	}

	let displaybatsman1 = `<td>${batsman1.name}*</td>
		<td>${batsman1.runScored}</td>
		<td>${batsman1.ballFaced}</td>
		<td>${batsman1.ballDotted}</td>
		<td>${batsman1.fourHitted}</td>
		<td>${batsman1.sixHitted}</td>
		<td>${batsmanOneStrikeRate}</td>`;

	let batsman2 = match.teamLineUp[track][batsmanId2];
	match.teamLineUp[track][batsmanId2].hasBatted = true;
	let batsmanTwoStrikeRate = (
		(batsman2.runScored * 100) /
		batsman2.ballFaced
	).toFixed(2);
	if (batsman2.ballFaced == 0) {
		batsmanTwoStrikeRate = 0.0;
	}

	let displaybatsman2 = `<td>${batsman2.name}</td>
		<td>${batsman2.runScored}</td>
		<td>${batsman2.ballFaced}</td>
		<td>${batsman2.ballDotted}</td>
		<td>${batsman2.fourHitted}</td>
		<td>${batsman2.sixHitted}</td>
		<td>${batsmanTwoStrikeRate}</td>`;

	let bowler = match.teamLineUp[1 - track][bowlerId];
	match.teamLineUp[1 - track][bowlerId].hasBowled = true;

	let bowler_economy = ((bowler.runGiven * 6) / bowler.ballBowled).toFixed(2);
	if (bowler.ballBowled == 0) {
		bowler_economy = "0.00";
	}
	let displayBowler = `<td>${bowler.name}</td>
		<td>${parseInt(bowler.ballBowled / 6)}.${bowler.ballBowled % 6}</td>
		<td>${bowler.maidenGiven}</td>
		<td>${bowler.runGiven}</td>
		<td>${bowler.wicketTaken}</td>
		<td>${bowler_economy}</td>`;

	if (match.runningInnings == 1) {
		if (document.querySelector("#teamBatted").classList.contains("d-none")) {
			document.querySelector("#teamBatted").classList.remove("d-none");
		}
		document.querySelector("#teamBattedNameScoreWicket").innerHTML = `${
			match.fielding
		} - ${match.teamScoreboard[1 - track].totalRunScored} / ${
			match.teamScoreboard[1 - track].wicketFall
		} (${parseInt(match.teamScoreboard[1 - track].ballsPlayed / 6)}.${
			match.teamScoreboard[1 - track].ballsPlayed % 6
		})`;
	} else {
		document.querySelector("#teamBatted").classList.add("d-none");
	}

	document.querySelector("#teamName").innerHTML = `${match.batting} - `;
	document.querySelector(
		"#scoreAndWicket"
	).innerHTML = `${match.teamScoreboard[track].totalRunScored} / ${match.teamScoreboard[track].wicketFall}`;
	document.querySelector("#showOver").innerHTML = `Overs: ${parseInt(
		match.teamScoreboard[track].ballsPlayed / 6
	)}.${match.teamScoreboard[track].ballsPlayed % 6}(${match.noOfOvers})`;

	document.querySelector("#batsman1").innerHTML = displaybatsman1;
	document.querySelector("#batsman2").innerHTML = displaybatsman2;
	document.querySelector("#bowler").innerHTML = displayBowler;

	document.querySelector("#over").innerHTML = "";
	for (let j of match.teamScoreboard[track].curOver) {
		let newBowl = document.createElement("span");
		let bowl_btn_cls = "btn-outline-primary";
		if (j.includes("0")) {
			bowl_btn_cls = "btn-outline-secondary";
		}
		if (j.includes("b")) {
			bowl_btn_cls = "btn-outline-dark";
		}
		if (j.includes("wd")) {
			bowl_btn_cls = "btn-outline-secondary";
		}
		if (j.includes("nb")) {
			bowl_btn_cls = "btn-outline-warning";
		}
		if (j.includes("4")) {
			bowl_btn_cls = "btn-outline-success";
		}
		if (j.includes("6")) {
			bowl_btn_cls = "btn-outline-purple";
		}
		if (j.includes("W")) {
			bowl_btn_cls = "btn-outline-danger";
		}
		newBowl.classList.add("btn", bowl_btn_cls, "rounded-pill", "mx-1");
		newBowl.innerText = j;
		document.querySelector("#over").appendChild(newBowl);
	}

	getVerdict();
	match = JSON.parse(localStorage.getItem("match"));
};

let loadFullScorecard = (track) => {
	let match = JSON.parse(localStorage.getItem("match"));

	document.querySelector("#teamOneName").innerHTML = match.teams[0].substring(
		0,
		10
	);
	document.querySelector("#teamTwoName").innerHTML = match.teams[1].substring(
		0,
		10
	);

	if (track == 0) {
		document.querySelector("#teamOneCard").classList.add("bg-dark");
		document.querySelector("#teamOneName").classList.add("text-white");
	} else {
		document.querySelector("#teamTwoCard").classList.add("bg-dark");
		document.querySelector("#teamTwoName").classList.add("text-white");
	}

	let displayBatsman = "";
	let displayBowler = "";
	let yet_to_bat = "";

	let batsmanArray = match.teamLineUp[track];
	batsmanArray.sort((x, y) => {
		if (x.batPosition < y.batPosition) {
			return -1;
		} else if (x.batPosition > y.batPosition) {
			return 1;
		} else {
			return 0;
		}
	});

	for (let batsman of batsmanArray) {
		let batsmanStrikeRate = (
			(batsman.runScored * 100) /
			batsman.ballFaced
		).toFixed(2);
		if (batsman.ballFaced == 0) {
			batsmanStrikeRate = 0.0;
		}

		displayBatsman += `<tr><td>${batsman.name}</td>
			<td>${batsman.status}</td>
			<td>${batsman.runScored}</td>
			<td>${batsman.ballFaced}</td>
			<td>${batsman.ballDotted}</td>
			<td>${batsman.fourHitted}</td>
			<td>${batsman.sixHitted}</td>
			<td>${batsmanStrikeRate}</td><td>`;

		if (batsman.role == "bat") {
			displayBatsman += `<img src="assets/images/batsman.png" width="15" height="15">`;
		} else if (batsman.role == "bowl") {
			displayBatsman += `<img src="assets/images/bowler.png" width="15" height="15">`;
		} else if (batsman.role == "all_r") {
			displayBatsman += `<img src="assets/images/all-rounder.png" width="15" height="15">`;
		} else if (batsman.role == "wk") {
			displayBatsman += `<img src="assets/images/wicket-keeper.png" width="15" height="15">`;
		}

		displayBatsman += "</td></tr>";
	}

	let bowlerArray = match.teamLineUp[1 - track];
	bowlerArray.sort((x, y) => {
		if (x.bowlPosition < y.bowlPosition) {
			return -1;
		} else if (x.bowlPosition > y.bowlPosition) {
			return 1;
		} else {
			return 0;
		}
	});

	for (let bowler of bowlerArray) {
		if (!bowler.hasBowled) {
			continue;
		}
		let bowler_economy = ((bowler.runGiven * 6) / bowler.ballBowled).toFixed(2);
		if (bowler.ballBowled == 0) {
			bowler_economy = "0.00";
		}

		displayBowler += `<tr><td>${bowler.name}</td>
			<td>${parseInt(bowler.ballBowled / 6)}.${bowler.ballBowled % 6}</td>
			<td>${bowler.runGiven}</td>
			<td>${bowler.maidenGiven}</td>
			<td>${bowler.wicketTaken}</td>
			<td>${bowler_economy}</td>
			<td>${bowler.dotGiven}</td>
			<td>${bowler.fourConsidered}</td>
			<td>${bowler.sixConsidered}</td>
			<td>${bowler.wideGiven}</td>
			<td>${bowler.noBallGiven}</td></tr>`;
	}

	document.querySelector("#battingCard").innerHTML = displayBatsman;
	if (match.teams[track] != match.batting && match.runningInnings == 0) {
		// first innings is running & this team is fielding
		document.querySelector("#extraRuns").classList.add("d-none");
		document.querySelector("#scoreRateOver").classList.add("d-none");
		document.querySelector("#bowlingTable").classList.add("d-none");
	} else {
		if (document.querySelector("#extraRuns").classList.contains("d-none")) {
			document.querySelector("#extraRuns").classList.remove("d-none");
			document.querySelector("#scoreRateOver").classList.remove("d-none");
			document.querySelector("#bowlingTable").classList.remove("d-none");
		}
	}
	document.querySelector(
		"#extraRuns"
	).innerHTML = `Extras: ${match.teamScoreboard[track].runsFromExtras}`;

	let crr = (
		(match.teamScoreboard[track].totalRunScored /
			match.teamScoreboard[track].ballsPlayed) *
		6
	).toFixed(2);
	if (match.teamScoreboard[track].ballsPlayed == 0) {
		crr = "0.00";
	}
	let socreRateOverShow = `<b>Score:</b> <span class="text-primary">${match.teamScoreboard[track].totalRunScored} / ${match.teamScoreboard[track].wicketFall}</span> <span class="text-success">|</span> `;

	if (match.teams[track] != match.fielding && match.runningInnings == 1) {
		// second innings is running & this team is fielding
		socreRateOverShow += `Target: ${
			match.teamScoreboard[1 - track].totalRunScored + 1
		} <span class="text-success">|</span> `;
	}

	socreRateOverShow += `Over: ${parseInt(
		match.teamScoreboard[track].ballsPlayed / 6
	)}.${match.teamScoreboard[track].ballsPlayed % 6}(${
		match.noOfOvers
	}) <span class="text-success">|</span> Run rate: ${crr}`;

	if (
		match.teams[track] == match.batting &&
		match.runningInnings == 1 &&
		match.verdictFlag < 4
	) {
		// second innings is running & this team is battin
		let runsNeeded =
			match.teamScoreboard[1 - track].totalRunScored -
			match.teamScoreboard[track].totalRunScored +
			1;
		let remBowls =
			match.noOfOvers * 6 - match.teamScoreboard[track].ballsPlayed;
		let rr = ((runsNeeded / remBowls) * 6).toFixed(2);
		socreRateOverShow += `, Req. rate: ${rr}`;
	}
	document.querySelector("#scoreRateOver").innerHTML = socreRateOverShow;

	document.querySelector("#bowlingCard").innerHTML = displayBowler;


	var player1_names = [];
	var player1_role = [];
	var player1_status = [];
	var player1_runsScored = [];
	var player1_ballfaced = [];
	var player1_ballDotted = [];
	var player1_fourHitted = [];
	var player1_sixHitted = [];
	var player1_ballsBowled = [];
	var player1_runsGiven = [];
	var player1_dotGiven = [];
	var player1_maidenGiven = [];
	var player1_fourConsidered = [];
	var player1_sixConsidered = [];
	var player1_wideGiven = [];
	var player1_noBallGiven = [];
	var player1_wicketTaken = [];

	var player2_names = [];
	var player2_role = [];
	var player2_status = [];
	var player2_runsScored = [];
	var player2_ballfaced = [];
	var player2_ballDotted = [];
	var player2_fourHitted = [];
	var player2_sixHitted = [];
	var player2_ballsBowled = [];
	var player2_runsGiven = [];
	var player2_dotGiven = [];
	var player2_maidenGiven = [];
	var player2_fourConsidered = [];
	var player2_sixConsidered = [];
	var player2_wideGiven = [];
	var player2_noBallGiven = [];
	var player2_wicketTaken = [];

	//Hidden Fields Data Bridge
	$("#savedata").click(() => {
		let match = JSON.parse(localStorage.getItem("match"));

		let realmatch = match;
		console.log(realmatch);

		var team1_arr = realmatch.teamLineUp[0];
		var team2_arr = realmatch.teamLineUp[1];
		
		for(let i = 0; i < Number(match.noOfPlayers); i++){
			player1_names.push((team1_arr[i].name));
			player1_role.push((team1_arr[i].role));
			player1_status.push((team1_arr[i].status));
			player1_runsScored.push((team1_arr[i].runScored));
			player1_ballfaced.push((team1_arr[i].ballFaced));
			player1_ballDotted.push((team1_arr[i].ballDotted));
			player1_fourHitted.push((team1_arr[i].fourHitted));
			player1_sixHitted.push((team1_arr[i].sixHitted));
			player1_ballsBowled.push((team1_arr[i].ballBowled));
			player1_runsGiven.push((team1_arr[i].runGiven));
			player1_dotGiven.push((team1_arr[i].dotGiven));
			player1_maidenGiven.push((team1_arr[i].maidenGiven));
			player1_fourConsidered.push((team1_arr[i].fourConsidered));
			player1_sixConsidered.push((team1_arr[i].sixConsidered));
			player1_wideGiven.push((team1_arr[i].wideGiven));
			player1_noBallGiven.push((team1_arr[i].noBallGiven));
			player1_wicketTaken.push((team1_arr[i].wicketTaken));
		}
		tempteam1 = [player1_names, player1_role, player1_status, player1_runsScored, player1_ballfaced, player1_ballDotted, player1_fourHitted, player1_sixHitted, player1_ballsBowled, player1_runsGiven, player1_dotGiven, player1_maidenGiven, player1_fourConsidered, player1_sixConsidered, player1_wideGiven, player1_noBallGiven, player1_wicketTaken];
		console.log(tempteam1);

		for(let i = 0; i < Number(match.noOfPlayers); i++){
			player2_names.push((team2_arr[i].name));
			player2_role.push((team2_arr[i].role));
			player2_status.push((team2_arr[i].status));
			player2_runsScored.push((team2_arr[i].runScored));
			player2_ballfaced.push((team2_arr[i].ballFaced));
			player2_ballDotted.push((team2_arr[i].ballDotted));
			player2_fourHitted.push((team2_arr[i].fourHitted));
			player2_sixHitted.push((team2_arr[i].sixHitted));
			player2_ballsBowled.push((team2_arr[i].ballBowled));
			player2_runsGiven.push((team2_arr[i].runGiven));
			player2_dotGiven.push((team2_arr[i].dotGiven));
			player2_maidenGiven.push((team2_arr[i].maidenGiven));
			player2_fourConsidered.push((team2_arr[i].fourConsidered));
			player2_sixConsidered.push((team2_arr[i].sixConsidered));
			player2_wideGiven.push((team2_arr[i].wideGiven));
			player2_noBallGiven.push((team2_arr[i].noBallGiven));
			player2_wicketTaken.push((team2_arr[i].wicketTaken));
		}

		$.ajax({
			url : "../ajax/db_ajaxcalls.php",
			type : "POST",
			data : {
				flag : "YES",
				//Match Table
				noOfPlayers : match.noOfPlayers,
				title : match.title,
				venue : match.venue,
				result : match.verdict,
				tossWon : match.tossWonBy,
				tossResult : match.tossDecision,
				maxOvers : match.noOfOvers, 

				//Team Table
				teamOneName : match.teams[0],
				teamTwoName : match.teams[1],
				teamOneRuns : match.teamScoreboard[0].totalRunScored,
				teamTwoRuns : match.teamScoreboard[1].totalRunScored,
				teamOneBalls : match.teamScoreboard[0].ballsPlayed,
				teamTwoBalls : match.teamScoreboard[1].ballsPlayed,
				teamOneWickets : match.teamScoreboard[0].wicketFall,
				teamTwoWickets : match.teamScoreboard[1].wicketFall,

				//Score Table
				team1 : [player1_names, player1_role, player1_status, player1_runsScored, player1_ballfaced, player1_ballDotted, player1_fourHitted, player1_sixHitted, player1_ballsBowled, player1_runsGiven, player1_dotGiven, player1_maidenGiven, player1_fourConsidered, player1_sixConsidered, player1_wideGiven, player1_noBallGiven, player1_wicketTaken],
				team2 : [player2_names, player2_role, player2_status, player2_runsScored, player2_ballfaced, player2_ballDotted, player2_fourHitted, player2_sixHitted, player2_ballsBowled, player2_runsGiven, player2_dotGiven, player2_maidenGiven, player2_fourConsidered, player2_sixConsidered, player2_wideGiven, player2_noBallGiven, player2_wicketTaken]
			},

			success: function (res) {
				console.log(res);
			},
			error : function (err) {
				console.log(err);
			}
		});
	})
};


let newBatsman = () => {
	let match = JSON.parse(localStorage.getItem("match"));
	let track = match.batting == match.teams[0] ? 0 : 1;

	if (match.teamScoreboard[track].wicketFall + 1 == match.noOfPlayers) {
		// all out
		localStorage.setItem("match", JSON.stringify(match));
		loadScore();
	} else {
		new bootstrap.Modal(document.querySelector("#new-batsman")).show();
		document.querySelector("#batting-modal-message").innerHTML =
			match.lastWicketFallMessage;

		elevenOption = "";
		match.teamLineUp[track].forEach((e) => {
			if (
				!e.gotOut &&
				e.name != match.onStrikeBatsman &&
				e.name != match.nonStrikeBatsman
			) {
				elevenOption += `<option value="${e.name}">${e.name}</option>`;
			}
		});
		document.querySelector("#newBatsman").innerHTML = elevenOption;

		document.querySelector("#setnewBatsman").addEventListener("click", () => {
			let newPickedBatsman = document.querySelector("#newBatsman").value;
			match.onStrikeBatsman = newPickedBatsman;
			match.teamScoreboard[track].noOfBatsmanBatted++;

			let batsmanId = match.teamLineUp[track].findIndex(
				(playerObj) => playerObj.name == match.onStrikeBatsman
			);
			match.teamLineUp[track][batsmanId].hasBatted = true;
			match.teamLineUp[track][batsmanId].batPosition =
				match.teamScoreboard[track].noOfBatsmanBatted;
			match.teamLineUp[track][batsmanId].status = "not out";

			localStorage.setItem("match", JSON.stringify(match));
			loadScore();
			overCompletionCheck();
		});
	}
};

let newBowler = () => {
	let match = JSON.parse(localStorage.getItem("match"));
	let track = match.fielding == match.teams[0] ? 0 : 1;

	new bootstrap.Modal(document.querySelector("#new-bowler")).show();
	match.lastBowler = match.onStrikeBowler;

	let elevenOneOption = "";
	match.teamLineUp[track].forEach((e) => {
		if (e.name != match.lastBowler) {
			elevenOneOption += `<option value="${e.name}">${e.name}</option>`;
		}
	});

	document.querySelector("#newBowler").innerHTML = elevenOneOption;
	document.querySelector("#setNewBowler").addEventListener("click", () => {
		let newPickedBowler = document.querySelector("#newBowler").value;
		match.onStrikeBowler = newPickedBowler;
		let bowlerId = match.teamLineUp[track].findIndex(
			(playerObj) => playerObj.name == newPickedBowler
		);
		match.teamLineUp[track][bowlerId].hasBowled = true;
		if (match.teamLineUp[track][bowlerId].bowlPosition == 12) {
			match.teamScoreboard[track].noOfBowlerBowled++;
			match.teamLineUp[track][bowlerId].bowlPosition =
				match.teamScoreboard[track].noOfBowlerBowled;
		}
		localStorage.setItem("match", JSON.stringify(match));
		loadScore();
	});
};

let checkMaiden = () => {
	let match = JSON.parse(localStorage.getItem("match"));
	let track = match.batting == match.teams[0] ? 0 : 1;

	let curOver = match.teamScoreboard[track].curOver;
	if (curOver.length == 6) {
		for (let i of curOver) {
			if (
				i.includes("1") ||
				i.includes("2") ||
				i.includes("3") ||
				i.includes("4")
			) {
				return false;
			} else if (i.includes("5") || i.includes("6") || i.includes("7")) {
				return false;
			} else if (i.includes("wd") || i.includes("nb")) {
				return false;
			}
		}
		return true;
	}
};

let overCompletionCheck = async () => {
	let match = JSON.parse(localStorage.getItem("match"));
	let track = match.batting == match.teams[0] ? 0 : 1;

	// if over is completed
	if (
		match.teamScoreboard[track].ballsPlayed % 6 == 0 &&
		match.teamScoreboard[track].ballsPlayed > 0
	) {
		let bowlerId = match.teamLineUp[1 - track].findIndex(
			(playerObj) => playerObj.name == match.onStrikeBowler
		);
		// check maiden
		if (checkMaiden()) {
			match.teamLineUp[1 - track][bowlerId].maidenGiven++;
		}
		// rotate strike
		[match.onStrikeBatsman, match.nonStrikeBatsman] = [
			match.nonStrikeBatsman,
			match.onStrikeBatsman,
		];
		match.teamScoreboard[track].curOver = [];
		localStorage.setItem("match", JSON.stringify(match));

		console.log(match);

		// get a new bowler
		if (match.verdictFlag % 2 == 1) {
			newBowler();
		}
	}
};

