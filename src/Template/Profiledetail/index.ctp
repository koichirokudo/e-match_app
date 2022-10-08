<?= $this->Html->css('profile_detail'); ?>
<div class="wrapper">
	<div class="pfheader">
		<div id="bgarea" class="bgimg">
			<img id="img-preview" class="cover-img" src="<?= $this->Url->image(h($user->pf_head)) ?>" alt="カバー写真" width="1060" height="312">
		</div>
		<div class="myimg">
			<img src="<?= $this->Url->image(h($user->pf_img)) ?>" class="mypic" width="120" height="120">
		</div>
	</div>

	<p class="myName"><?= h($user->user_name) ?></p>

	<section class="gameinfo">
		<div id="r6s-section" class="r6s">
			<h3 class="r6s-label label-deco"><i class="fas fa-gamepad"></i>Rainbow Six Siege</h3>
		</div>

		<div id="pubg-section" class="pubg">
			<h3 class="pubg-label label-deco"><i class="fas fa-gamepad"></i>Player Unknown's Battle Ground</h3>
			<ul class="pubginfo">
				<li class="csrank-deco">Current Season Rank</li>
				<li class="other-deco">Name <span class="char-deco"><?= h($user->pubg_name) ?></li>
				<li class="rank-row">Solo <span id="pubg-solo-rank" class="rank-deco"><?= h($pubgPlayerInfo["soloRank"]) ?></span></li>
				<li class="rank-row">Duo <span id="pubg-duo-rank" class="rank-deco"><?= h($pubgPlayerInfo["duoRank"]) ?></span></li>
				<li class="rank-row">Squad <span id="pubg-sq-rank" class="rank-deco"><?= h($pubgPlayerInfo["sqRank"]) ?></span></li>
				<li class="other-deco">Kill/Death Rate(Solo) <span id="pubg-kd" class="char-deco"><?= h($pubgPlayerInfo["soloKd"]) ?></span></li>
				<li class="other-deco">Kill/Death Rate(Duo) <span id="pubg-kd" class="char-deco"><?= h($pubgPlayerInfo["duoKd"]) ?></span></li>
				<li class="other-deco">Kill/Death Rate(Squad) <span id="pubg-kd" class="char-deco"><?= h($pubgPlayerInfo["sqKd"]) ?></span></li>
			</ul>
		</div>

		<div id="lol-section" class="lol">
			<h3 class="lol-label label-deco"><i class="fas fa-gamepad"></i>League Of Legends</h3>
			<ul class="lolinfo">
				<li class="csrank-deco">Current Season Rank</li>
				<li class="other-deco">Name <span class="char-deco"><?= h($user->lol_name) ?></li>
				<li class="rank-row">Solo <span id="lol-solo-rank" class="rank-deco"><?= h($lolPlayerInfo["soloRank"]) ?></span></li>
				<li class="other-deco">League Points <span id="lol-points" class="char-deco"><?= h($lolPlayerInfo["leaguePoints"]) ?></span></li>
				<li class="other-deco">Win Rate <span id="lol-rate" class="char-deco"><?= h($lolPlayerInfo["winRate"]) ?>%</span></li>
				<li class="other-deco"><?php $g = (int) $lolPlayerInfo["wins"] + (int) $lolPlayerInfo["losses"];
										h($g) ?> games <span id="lol-rate" class="char-deco"><?= $lolPlayerInfo["wins"] ?></span> wins <span id="lol-rate" class="char-deco"><?= h($lolPlayerInfo["losses"]) ?></span> losses </li>
			</ul>
	</section>

	<section class="mypf">
		<div class="mygoal">
			<h3 class="myr6sgoal-label label-deco"><i class="far fa-hand-rock"></i>R6S目標ランク</h3>
			<p id="goal" class="content">サービスは終了しました。</p>
		</div>
		<div class="mygoal">
			<h3 class="mypubggoal-label label-deco"><i class="far fa-hand-rock"></i>PUBG目標ランク</h3>
			<p id="goal" class="content"><?= h($user->pubg_goal) ?></p>
		</div>
		<div class="mygoal">
			<h3 class="mylolgoal-label label-deco"><i class="far fa-hand-rock"></i>LOL目標ランク</h3>
			<p id="goal" class="content"><?= h($user->lol_goal) ?></p>
		</div>
		<div class="myintro">
			<h3 class="intro-label label-deco"><i class="far fa-id-card"></i>自己紹介</h3>
			<p id="intro" class="content"><?= nl2br(h($user->intro)) ?></p>
		</div>

		<div class="mytournament">
			<h3 class="tour-label label-deco"><i class="fas fa-trophy"></i>大会出場有無</h3>
			<p id="tournament" class="content"><?= h($tmt) ?></p>
		</div>
		<div class="myvalues">
			<h3 class="values-label label-deco"><i class="fas fa-pen-nib"></i>ゲームの価値観</h3>
			<p id="values" class="content"><?= h($values) ?></p>
		</div>
		<div class="myteam">
			<h3 class="team-label label-deco"><i class="fas fa-user-friends"></i>所属チーム</h3>
			<p id="team" class="content"><?= h($user->team) ?></p>
		</div>
		<div class="mydiscord" <?= $rq_state == 0 || $rq_state == 1 || $rq_state == 3 ? "style=display:none;" : "" ?>>
			<h3 class="discord-label label-deco"><i class="fab fa-discord"></i>Discord</h3>
			<p id="discord" class="content"><?= h($user->discord) ?></p>
		</div>
		<div class="myskype" <?= $rq_state == 0 || $rq_state == 1 || $rq_state == 3 ? "style=display:none;" : "" ?>>
			<h3 class="skype-label label-deco"><i class="fab fa-skype"></i>Skype</h3>
			<p id="skype" class="content"><?= h($user->skype) ?></p>
		</div>
	</section>
	<div class="btnarea">
		<?php echo $this->Form->create(null, ["type" => "post", "url" => ["controller" => "profiledetail", "action" => "rq"]]) ?>
		<input type="hidden" name="from" value="<?= $this->request->getCookie("user_id") ?>">
		<input type="hidden" name="to" value="<?= $user->id ?>">
		<?php switch($rq_state) :
			case 0: ?>
				<button type="submit" class="game-play-btn" >ゲームプレイ希望</button>
			<?php break;?>
			<?php case 1: ?>
				<button type="submit" class="game-play-btn pushed" disabled>ゲームプレイ希望中</button>
			<?php break;?>
			<?php case 2: ?>
				<button type="submit" class="game-play-btn pushed" disabled>マッチング済み</button>
			<?php break;?>
			<?php case 3: ?>
				<button type="submit" class="game-play-btn pushed" disabled>ゲームプレイ拒否</button>
			<?php break;?>
			<?php endswitch; ?>
		</form>
	</div>
</div>

<script>
	$(function() {
		const PUBGFLG = <?= h($pubgflg) ?>;
		const LOLFLG = <?= h($lolflg) ?>;

		const r6sRankArray = [
			// 24
			/Champion/,
			/Diamond/,
			/Platinum [1-3]/,
			/Gold [1-3]/,
			/Silver [1-5]/,
			/Bronze [1-5]/,
			/Copper [1-5]/,
			/Unranked/
		];

		const pubgRankArray = [
			// 29
			/LoneSurvivor/,
			/Survivor/,
			/Expert/,
			/Specialist [1-5]/,
			/Skilled [1-5]/,
			/Experienced [1-5]/,
			/Novice [1-5]/,
			/Beginner [1-5]/,
			/Unranked/
		];

		const lolRankArray = [
			// 28
			/Challenger/,
			/GrandMaster/,
			/Master/,
			/Diamond [1-4]/,
			/Platinum [1-4]/,
			/Gold [1-4]/,
			/Silver [1-4]/,
			/Bronze [1-4]/,
			/Iron [1-4]/,
			/Unranked/
		];

        const r6s = "r6s"
        const pubg = "pubg"
        const lol = "lol"

        infoMsg(r6s);

		if (PUBGFLG === 1) {
			pubgRankColor(0);
			pubgRankColor(1);
			pubgRankColor(2);
		} else {
			infoMsg(pubg);
		}

		if (LOLFLG === 1) {
			lolRankColor();
		} else {
			infoMsg(lol);
		}

		function pubgRankColor(type) {
			let pubgRank
            switch (type) {
				case 0:
                    pubgRank = document.getElementById("pubg-solo-rank")
                    break;
				case 1:
                    pubgRank = document.getElementById("pubg-duo-rank")
                    break;
				case 2:
                    pubgRank = document.getElementById("pubg-sq-rank")
                    break;
			}

			for (let i = 0; i < pubgRankArray.length; i++) {
				if (pubgRankArray[i].test(pubgRank.textContent)) {
                    const style = pubgRank.style
                    switch (i) {
						case 0: // LoneSurvivor
							style.color = "#c8a048";
							break;
						case 1: // Survivor
							style.color = "#c8a048";
							break;
						case 2: // Expert
							style.color = "#c8a048";
							break;
						case 3: // Specialist
							style.color = "#7E7FD6";
							break;
						case 4: // Skilled
							style.color = "#8BACC4";
							break;
						case 5: // Experienced
							style.color = "#A59358";
							break;
						case 6: // Novice
							style.color = "#A4A8AC";
							break;
						case 7: // Beginner
							style.color = "#B57F66";
							break;
						case 8: // Unranked
							style.color = "#666666";
							break;
					}
					break;
				}
			}
		}

		function infoMsg(gameTitle) {
            let section = ""
            let div = ""
            switch (gameTitle) {
				case "r6s":
					section = document.getElementById("r6s-section");
					div = `
						<h3 class="r6s-label label-deco"><i class="fas fa-gamepad"></i>Rainbow Six Siege</h3>
						<i class="fas fa-exclamation-circle"></i>
						<p class="no-reg-msg">R6Sのサービスは終了しました。</p>
						`
					section.innerHTML = "";
					section.innerHTML = section.innerHTML + div;
					break;
				case "pubg":
					section = document.getElementById("pubg-section");
					div = `
						<h3 class="pubg-label label-deco"><i class="fas fa-gamepad"></i>Player Unknown's Battle Ground</h3>
						<i class="fas fa-exclamation-circle"></i>
						<p class="no-reg-msg">登録されていません<br>登録したプレイヤー名が誤っている可能性があるため<br>プロフィール編集からご確認ください</p>
						`
					section.innerHTML = "";
					section.innerHTML = section.innerHTML + div;
					break;
				case "lol":
					section = document.getElementById("lol-section");
					div = `
						<h3 class="lol-label label-deco"><i class="fas fa-gamepad"></i>League Of Legends</h3>
						<i class="fas fa-exclamation-circle"></i>
						<p class="no-reg-msg">登録されていません<br>登録したプレイヤー名が誤っている可能性があるため<br>プロフィール編集からご確認ください</p>
						`
					section.innerHTML = "";
					section.innerHTML = section.innerHTML + div;
					break;
			}
		}

		function lolRankColor(type) {
            const lolRank = document.getElementById("lol-solo-rank")

            for (let i = 0; i < lolRankArray.length; i++) {
				if (lolRankArray[i].test(lolRank.textContent)) {
                    const style = lolRank.style
                    switch (i) {
						case 0: // Challenger
							style.color = "#5195E7";
							break;
						case 1: // GrandMaster
							style.color = "#FC6874";
							break;
						case 2: // Master
							style.color = "#E76EEB";
							break;
						case 3: // Diamond
							style.color = "#B389F1";
							break;
						case 4: // Platinum
							style.color = "#65D2BC";
							break;
						case 5: // Gold
							style.color = "#E8B85F";
							break;
						case 6: // Silver
							style.color = "#85887F";
							break;
						case 7: // Bronze
							style.color = "#A0623F";
							break;
						case 8: // Iron
							style.color = "#CCCBCB";
							break;
						case 9: // Unranked
							style.color = "#666666";
							break;
					}
					break;
				}
			}
		}
	});
</script>
