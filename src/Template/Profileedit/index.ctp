<?= $this->Html->css('profile_edit') ?>
<div class="profile-wrapper">
	<h2>プロフィール編集</h2>
	<?= $this->Form->create(null, ["type" => "post", "enctype" => "multipart/form-data", "name" => "form1", "id" => "profile-form", "url" => ["action" => "confirm"]]) ?>
	<p class="desc"><span class="require-item">*</span>は入力必須の項目です</p>

	<div class="outher-row">
		<label>プロフィール画像</label>
		<img id="file-preview" src="<?= h($this->Url->image($user->pf_img)) ?>" width="80" height="80" alt="プロフィール画像">
		<div class="column">
			<label class="upbtn_label">
				ファイル選択
				<input type="file" name="thumbnail-file" id="uploadFile" class="upbtn" style="display: none" accept="image/png,image/jpeg,image/jpg">
			</label>
			<span class="warning-msg">※拡張子「.jpg」「.jpeg」「.png」のファイルを選択してください </span><br>
			<span id="ext-check" class="ext-msg"></span>
		</div>
	</div>

	<div class="outher-row">
		<label>マッチングしたい<br>ゲームタイトル<span class="require-item">*</span></label>
		<div class="inner-row column">
			<div class="row">
				<input type="checkbox" id="pubg-title" class="validate[required,minCheckbox[1]]" name="game-title[]" value="2" onclick="connectText('pubg-myName', this.checked);connectText('pubg-rank-select', this.checked)"
				<?= $user->pubg_flg === 1 ? "checked" : "" ?>>
				<span>Player Unknown's Battle Ground</span>
			</div>
			<div class="row">
				<input type="checkbox" id="lol-title" class="validate[required,minCheckbox[1]]" name="game-title[]" value="3" onclick="connectText('lol-myName', this.checked);connectText('lol-rank-select', this.checked)"
				<?= $user->lol_flg === 1 ? "checked" : "" ?>>
				<span>League Of Legends</span>
			</div>
		</div>
	</div>

	<div class="outher-row">
		<label>プレイヤー名<span class="require-item">*</span></label>
		<div class="inner-row column">
			<div class="row">
				<span class="pubg-margin">Player Unknown's Battle Ground</span>
				<input type="text" name="pubg-name" id="pubg-myName" class="validate[condRequired[pubg-title],maxSize[30]" placeholder="プレイヤー名を入力してください" <?= $user->pubg_flg === 1 ? "value=" . h($user->pubg_name) : "disabled" ?>>
			</div>
			<div class="row">
				<span class="lol-margin">League Of Legends</span>
				<input type="text" name="lol-name" id="lol-myName" class="validate[condRequired[lol-title],minSize[3],maxSize[16]]" placeholder="プレイヤー名を入力してください" <?= $user->lol_flg === 1 ? "value=" . h($user->lol_name) : "disabled" ?>>
			</div>
		</div>
	</div>

	<div class="outher-row">
		<label>目標ランク</label>
		<div class="inner-row column">
			<div class="row">
				<span class="pubg-margin">Player Unknown's Battle Ground</span>
				<select id="pubg-rank-select" name="pubg-rank-select" <?= $user->pubg_flg === 1 ? "" : "disabled" ?>>
					<option value="未設定" <?= $user->pubg_goal === "未設定" ? "selected" : "" ?>>未設定</option>
					<option value="Beginner1" <?= $user->pubg_goal === "Beginner1" ? "selected" : "" ?>>Beginner1</option>
					<option value="Beginner2" <?= $user->pubg_goal === "Beginner2" ? "selected" : "" ?>>Beginner2</option>
					<option value="Beginner3" <?= $user->pubg_goal === "Beginner3" ? "selected" : "" ?>>Beginner3</option>
					<option value="Beginner4" <?= $user->pubg_goal === "Beginner4" ? "selected" : "" ?>>Beginner4</option>
					<option value="Beginner5" <?= $user->pubg_goal === "Beginner5" ? "selected" : "" ?>>Beginner5</option>
					<option value="Novice1" <?= $user->pubg_goal === "Novice1" ? "selected" : "" ?>>Novice1</option>
					<option value="Novice2" <?= $user->pubg_goal === "Novice2" ? "selected" : "" ?>>Novice2</option>
					<option value="Novice3" <?= $user->pubg_goal === "Novice3" ? "selected" : "" ?>>Novice3</option>
					<option value="Novice4" <?= $user->pubg_goal === "Novice4" ? "selected" : "" ?>>Novice4</option>
					<option value="Novice5" <?= $user->pubg_goal === "Novice5" ? "selected" : "" ?>>Novice5</option>
					<option value="Experienced1" <?= $user->pubg_goal === "Experienced1" ? "selected" : "" ?>>Experienced1</option>
					<option value="Experienced2" <?= $user->pubg_goal === "Experienced2" ? "selected" : "" ?>>Experienced2</option>
					<option value="Experienced3" <?= $user->pubg_goal === "Experienced3" ? "selected" : "" ?>>Experienced3</option>
					<option value="Experienced4" <?= $user->pubg_goal === "Experienced4" ? "selected" : "" ?>>Experienced4</option>
					<option value="Experienced5" <?= $user->pubg_goal === "Experienced5" ? "selected" : "" ?>>Experienced5</option>
					<option value="Skilled1" <?= $user->pubg_goal === "Skilled1" ? "selected" : "" ?>>Skilled1</option>
					<option value="Skilled2" <?= $user->pubg_goal === "Skilled2" ? "selected" : "" ?>>Skilled2</option>
					<option value="Skilled3" <?= $user->pubg_goal === "Skilled3" ? "selected" : "" ?>>Skilled3</option>
					<option value="Skilled4" <?= $user->pubg_goal === "Skilled4" ? "selected" : "" ?>>Skilled4</option>
					<option value="Skilled5" <?= $user->pubg_goal === "Skilled5" ? "selected" : "" ?>>Skilled5</option>
					<option value="Specialist1" <?= $user->pubg_goal === "Specialist1" ? "selected" : "" ?>>Specialist1</option>
					<option value="Specialist2" <?= $user->pubg_goal === "Specialist2" ? "selected" : "" ?>>Specialist2</option>
					<option value="Specialist3" <?= $user->pubg_goal === "Specialist3" ? "selected" : "" ?>>Specialist3</option>
					<option value="Specialist4" <?= $user->pubg_goal === "Specialist4" ? "selected" : "" ?>>Specialist4</option>
					<option value="Specialist5" <?= $user->pubg_goal === "Specialist5" ? "selected" : "" ?>>Specialist5</option>
					<option value="Expert" <?= $user->pubg_goal === "Expert" ? "selected" : "" ?>>Expert</option>
					<option value="Survivor" <?= $user->pubg_goal === "Survivor" ? "selected" : "" ?>>Survivor</option>
					<option value="Lone Survivor" <?= $user->pubg_goal === "Lone Survivor" ? "selected" : "" ?>>Lone Survivor</option>
				</select>
			</div>
			<div class="row">
				<span class="lol-margin">League Of Legends</span>
				<select id="lol-rank-select" name="lol-rank-select" <?= $user->lol_flg === 1 ? "" : "disabled" ?>>
					<option value="未設定" <?= $user->lol_goal === "未設定" ? "selected" : "" ?>>未設定</option>
					<option value="Iron1" <?= $user->lol_goal === "Iron1" ? "selected" : "" ?>>Iron1</option>
					<option value="Iron2" <?= $user->lol_goal === "Iron2" ? "selected" : "" ?>>Iron2</option>
					<option value="Iron3" <?= $user->lol_goal === "Iron3" ? "selected" : "" ?>>Iron3</option>
					<option value="Iron4" <?= $user->lol_goal === "Iron4" ? "selected" : "" ?>>Iron4</option>
					<option value="Bronze1" <?= $user->lol_goal === "Bronze1" ? "selected" : "" ?>>Bronze1</option>
					<option value="Bronze2" <?= $user->lol_goal === "Bronze2" ? "selected" : "" ?>>Bronze2</option>
					<option value="Bronze3" <?= $user->lol_goal === "Bronze3" ? "selected" : "" ?>>Bronze3</option>
					<option value="Bronze4" <?= $user->lol_goal === "Bronze4" ? "selected" : "" ?>>Bronze4</option>
					<option value="Silver1" <?= $user->lol_goal === "Silver1" ? "selected" : "" ?>>Silver1</option>
					<option value="Silver2" <?= $user->lol_goal === "Silver2" ? "selected" : "" ?>>Silver2</option>
					<option value="Silver3" <?= $user->lol_goal === "Silver3" ? "selected" : "" ?>>Silver3</option>
					<option value="Silver4" <?= $user->lol_goal === "Silver4" ? "selected" : "" ?>>Silver4</option>
					<option value="Gold1" <?= $user->lol_goal === "Gold1" ? "selected" : "" ?>>Gold1</option>
					<option value="Gold2" <?= $user->lol_goal === "Gold2" ? "selected" : "" ?>>Gold2</option>
					<option value="Gold3" <?= $user->lol_goal === "Gold3" ? "selected" : "" ?>>Gold3</option>
					<option value="Gold4" <?= $user->lol_goal === "Gold4" ? "selected" : "" ?>>Gold4</option>
					<option value="Platinum1" <?= $user->lol_goal === "Platinum1" ? "selected" : "" ?>>Platinum1</option>
					<option value="Platinum2" <?= $user->lol_goal === "Platinum2" ? "selected" : "" ?>>Platinum2</option>
					<option value="Platinum3" <?= $user->lol_goal === "Platinum3" ? "selected" : "" ?>>Platinum3</option>
					<option value="Platinum4" <?= $user->lol_goal === "Platinum4" ? "selected" : "" ?>>Platinum4</option>
					<option value="Diamond1" <?= $user->lol_goal === "Diamond1" ? "selected" : "" ?>>Diamond1</option>
					<option value="Diamond2" <?= $user->lol_goal === "Diamond2" ? "selected" : "" ?>>Diamond2</option>
					<option value="Diamond3" <?= $user->lol_goal === "Diamond3" ? "selected" : "" ?>>Diamond3</option>
					<option value="Diamond4" <?= $user->lol_goal === "Diamond4" ? "selected" : "" ?>>Diamond4</option>
					<option value="Master" <?= $user->lol_goal === "Master" ? "selected" : "" ?>>Master</option>
					<option value="Grandmaster" <?= $user->lol_goal === "Grandmaster" ? "selected" : "" ?>>GrandMaster</option>
					<option value="Challenger" <?= $user->lol_goal === "Challenger" ? "selected" : "" ?>>Challenger</option>
				</select>
			</div>
		</div>
	</div>

	<div class="outher-row">
		<label>自己紹介</label>
		<textarea name="my-intro" rows="15" placeholder="1000字以内で入力してください" class="validate[optipnal,maxSize[1000]]"><?= h($user->intro) ?></textarea>
	</div>

	<div class="outher-row">
		<label>所属チーム</label>
		<input type="text" name="my-team" placeholder="20字以内で入力してください" class="validate[optipnal,maxSize[20]]" value="<?= h($user->team) ?>">
	</div>

	<div class="outher-row">
		<label>ゲームをプレイする<br>上での価値観<span class="require-item">*</span></label>
		<div class="inner-row">
			<div>
				<input type="radio" id="game-Values1" name="values" class="validate[required]" value="0" <?= $user->game_values === 0 ? "checked" : "" ?>><span>楽しんでゲームをしたい</span>
			</div>
			<div>
				<input type="radio" id="game-Values2" name="values" class="validate[required]" value="1" <?= $user->game_values === 1 ? "checked" : "" ?>><span>本気でゲームをしたい</span>
			</div>
		</div>

	</div>

	<div class="outher-row">
		<label>大会出場の有無<span class="require-item">*</span></label>
		<div class="inner-row">
			<div>
				<input type="radio" id="game-Tournament1" name="tournament" class="validate[required]" value="0" <?= $user->game_values === 0 ? "checked" : "" ?>><span>大会に出場したくない</span>
			</div>
			<div>
				<input type="radio" id="game-Tournament2" name="tournament" class="validate[required]" value="1" <?= $user->game_values === 1 ? "checked" : "" ?>><span>大会に出場したい</span>
			</div>
		</div>
	</div>

	<div class="outher-row">
		<label>ボイスチャット<span class="require-item">*</span></label>
		<div class="inner-row column">
			<div class="row">
				<input type="checkbox" name="" id="discord" class="validate[required,minCheckbox[1]]" value="" onclick="connectText('discord-id', this.checked)" <?= $user->discord === "" ? "" : "checked" ?>>
				<span>Discord</span>
			</div>
			<div class="row">
				<input type="checkbox" name="" id="skype" class="validate[required,minCheckbox[1]]" value="" onclick="connectText('skype-id', this.checked)" <?= $user->skype === "" ? "" : "checked" ?>>
				<span>Skype</span>
			</div>
		</div>
	</div>

	<div class="outher-row">
		<label>Discord<span class="require-item">*</span></label>
		<input type="text" id="discord-id" name="discord" class="validate[condRequired[discord],minSize[5],maxSize[40]]" placeholder="DiscordのIDを入力してください" <?= $user->discord === "" ? "disabled" : "value=" . h($user->discord) ?>>
	</div>

	<div class="outher-row">
		<label>Skype<span class="require-item">*</span></label>
		<input type="text" id="skype-id" name="skype" class="validate[condRequired[skype],minSize[6],maxSize[32]]" placeholder="SkypeのIDを入力してください" <?= $user->skype === "" ? "disabled" : "value=" . h($user->skype) ?>>
	</div>

	<div class="reg-btn-area">
		<button type="submit" class="reg-btn" name="confirm" value="confirm">確認画面へ</button>
	</div>
	</form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery.validationEngine.min.js" integrity="sha512-MKqdT8JgKftxlK6oK4S+Hh44ivKyaPncl6qN9JZEGKJGQZJMiSoPzehLcbvd/1XMieEP1Q4A3wzzhTrvBUUcUQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-ja.min.js" integrity="sha512-K8+w5u+XycAkuX4BEUoBhGt144N7Lm3tNPp+3SPnOBzkyVby/i7NDrbYjIoB4YmjwyucTElSUhJyjEVvFGv4GA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(function() {
    $("#profile-form").validationEngine();
})
</script>
<script>
	$(function(){
		// プロフィール画像変更
		document.getElementById("uploadFile").addEventListener("change", function(e) {
            const file = e.target.files[0]
            const msg = document.getElementById("ext-check")
            msg.innerHTML = ""

			if (checkExt() === false) return false;
			if (checkSize(file.size) === false) {
				msg.innerHTML = "3MB以内の画像を選択してください"
				return false;
			}

			// ファイルリーダー作成
            const fileReader = new FileReader()
            fileReader.onload = function() {
				// Data URIを取得
                const dataUri = this.result

                // img要素に表示
                const img = document.getElementById("file-preview")
                img.src = dataUri;
			};

			// ファイルをData URIとして読み込む
			fileReader.readAsDataURL(file);
		});
	})
	//チェックボックス有効/無効
	function connectText(textid, ischecked) {
		document.getElementById(textid).disabled = ischecked !== true;
	}

	// ファイル拡張子チェック
	// アップロード予定のファイル名の拡張子が許可されているか確認する関数
	function checkExt() {
        const msg = document.getElementById("ext-check")

        // ファイル名取得
        const fileInfo = document.querySelector("#uploadFile").files[0]
        const filename = fileInfo.name

        // .が何文字目にあるか?
        const pos = filename.lastIndexOf(".")
        if (pos === -1) return "";

		// .の次の文字列を抜き出す
        const target = filename.slice(pos + 1)

        //アップロードを許可する拡張子
        const allow_exts = "jpg jpeg png"

        //比較のため小文字にする
        const ext = target.toLowerCase()

        //許可する拡張子の一覧(allow_exts)から対象の拡張子があるか確認する
		if (allow_exts.indexOf(ext) === -1) {
			msg.innerHTML = "ファイルの拡張子が違います";
			return false;
		} else {
			return true;
		}
	}

		// 画像容量チェック
	function checkSize(size) {
        const maxSize = 3145728 // 3MB
		return maxSize >= size;
	}
</script>
