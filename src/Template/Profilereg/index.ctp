<?= $this->Html->css('profile_reg'); ?>
<div class="profile-wrapper">
	<h2>プロフィール登録</h2>
	<?= $this->Form->create(null, ["type" => "post", "enctype" => "multipart/form-data", "name" => "form1", "id" => "profile-form", "url" => ["action" => "confirm"]]) ?>
	<p class="desc"><span class="require-item">*</span>は入力必須の項目です</p>
	<div class="outher-row">
		<label>名前<span class="require-item">*</span></label>
		<input type="text" id="name" name="name" class="validate[required,minSize[6],maxSize[30],custom[onlyLetterNumber]]" placeholder="半角英数字 6桁~30桁以内で入力してください">
	</div>

	<div class="outher-row">
		<label>プロフィール画像</label>
		<img name="profile-img" id="file-preview" src="/img/noimage.png" width="80" height="80" alt="プロフィール画像">
		<div class="column">
			<label class="upbtn_label">
				ファイル選択
				<input type="file" name="thumbnail-file" id="uploadFile" class="upbtn" style="display: none" accept="image/png,image/jpeg,image/jpg">
			</label>
			<span class="warning-msg">※拡張子「.jpg」「.jpeg」「.png」のファイルを選択してください</span><br>
			<span id="ext-check" class="ext-msg"></span>
		</div>
	</div>

	<div class="outher-row">
		<label>マッチングしたい<br>ゲームタイトル<span class="require-item">*</span></label>
		<div class="inner-row column">
			<div class="row">
				<input type="checkbox" name="game-title[]" id="pubg-title" class="validate[required,minCheckbox[1]]" value="2" onclick="connectText('pubg-title', 'pubg-myName');connectText('pubg-title', 'pubg-rank-select')">
				<span>Player Unknown's Battle Ground</span>
			</div>
			<div class="row">
				<input type="checkbox" name="game-title[]" id="lol-title" class="validate[required,minCheckbox[1]]" value="3" onclick="connectText('lol-title', 'lol-myName');connectText('lol-title', 'lol-rank-select')">
				<span>League Of Legends</span>
			</div>
		</div>
	</div>

	<div class="outher-row">
		<label>プレイヤー名<span class="require-item">*</span></label>
		<div class="inner-row column">
			<div class="row">
				<span class="pubg-margin">Player Unknown's Battle Ground</span>
				<input type="text" name="pubg-name" id="pubg-myName" class="validate[condRequired[pubg-title],maxSize[30],custom[onlyLetterNumber]]" placeholder="プレイヤー名を入力してください" disabled>
			</div>
			<div class="row">
				<span class="lol-margin">League Of Legends</span>
				<input type="text" name="lol-name" id="lol-myName" class="validate[condRequired[lol-title],minSize[2],maxSize[16],custom[lolCheck]]" placeholder="プレイヤー名を入力してください" disabled>
			</div>
			<p id="lolmsg" class="ext-msg"></p>
		</div>
	</div>

	<div class="outher-row">
		<label>目標ランク</label>
		<div class="inner-row column">
			<div class="row">
				<span class="pubg-margin">Player Unknow's Battle Ground</span>
				<select id="pubg-rank-select" name="pubg-rank-select" disabled>
					<option value="未設定">未設定</option>
					<option value="Beginner1">Beginner1</option>
					<option value="Beginner2">Beginner2</option>
					<option value="Beginner3">Beginner3</option>
					<option value="Beginner4">Beginner4</option>
					<option value="Beginner5">Beginner5</option>
					<option value="Novice1">Novice1</option>
					<option value="Novice2">Novice2</option>
					<option value="Novice3">Novice3</option>
					<option value="Novice4">Novice4</option>
					<option value="Novice5">Novice5</option>
					<option value="Experienced1">Experienced1</option>
					<option value="Experienced2">Experienced2</option>
					<option value="Experienced3">Experienced3</option>
					<option value="Experienced4">Experienced4</option>
					<option value="Experienced5">Experienced5</option>
					<option value="Skilled1">Skilled1</option>
					<option value="Skilled2">Skilled2</option>
					<option value="Skilled3">Skilled3</option>
					<option value="Skilled4">Skilled4</option>
					<option value="Skilled5">Skilled5</option>
					<option value="Specialist1">Specialist1</option>
					<option value="Specialist2">Specialist2</option>
					<option value="Specialist3">Specialist3</option>
					<option value="Specialist4">Specialist4</option>
					<option value="Specialist5">Specialist5</option>
					<option value="Expert">Expert</option>
					<option value="Survivor">Survivor</option>
					<option value="Specialist1">Lone Survivor</option>
				</select>
			</div>
			<div class="row">
				<span class="lol-margin">League Of Legends</span>
				<select id="lol-rank-select" name="lol-rank-select" disabled>
					<option value="未設定">未設定</option>
					<option value="Iron1">Iron1</option>
					<option value="Iron2">Iron2</option>
					<option value="Iron3">Iron3</option>
					<option value="Iron4">Iron4</option>
					<option value="Bronze1">Bronze1</option>
					<option value="Bronze2">Bronze2</option>
					<option value="Bronze3">Bronze3</option>
					<option value="Bronze4">Bronze4</option>
					<option value="Silver1">Silver1</option>
					<option value="Silver2">Silver2</option>
					<option value="Silver3">Silver3</option>
					<option value="Silver4">Silver4</option>
					<option value="Gold1">Gold1</option>
					<option value="Gold2">Gold2</option>
					<option value="Gold3">Gold3</option>
					<option value="Gold4">Gold4</option>
					<option value="Platinum1">Platinum1</option>
					<option value="Platinum2">Platinum2</option>
					<option value="Platinum3">Platinum3</option>
					<option value="Platinum4">Platinum4</option>
					<option value="Diamond1">Diamond1</option>
					<option value="Diamond2">Diamond2</option>
					<option value="Diamond3">Diamond3</option>
					<option value="Diamond4">Diamond4</option>
					<option value="Master">Master</option>
					<option value="GrandMaster">GrandMaster</option>
					<option value="Challenger">Challenger</option>
				</select>
			</div>
		</div>
	</div>

	<div class="outher-row">
		<label>自己紹介</label>
		<textarea name="my-intro" rows="15" placeholder="1000字以内で入力してください" class="validate[optional,maxSize[1000]]"></textarea>
	</div>

	<div class="outher-row">
		<label>所属チーム</label>
		<input type="text" name="my-team" placeholder="20字以内で入力してください" class="validate[optional,maxSize[20]]">
	</div>

	<div class="outher-row">
		<label>ゲームをプレイする<br>上での価値観<span class="require-item">*</span></label>
		<div class="inner-row">
			<div>
				<input type="radio" id="game-Values1" name="values" class="validate[required]" value="0"><span>楽しんでゲームをしたい</span>
			</div>
			<div>
				<input type="radio" id="game-Values2" name="values" class="validate[required]" value="1"><span>本気でゲームをしたい</span>
			</div>
		</div>

	</div>

	<div class="outher-row">
		<label>大会出場の有無<span class="require-item">*</span></label>
		<div class="inner-row">
			<div>
				<input type="radio" id="game-Tournament1" name="tournament" class="validate[required]" value="0"><span>大会に出場したくない</span>
			</div>
			<div>
				<input type="radio" id="game-Tournament2" name="tournament" class="validate[required]" value="1"><span>大会に出場したい</span>
			</div>
		</div>
	</div>

	<div class="outher-row">
		<label>ボイスチャット<span class="require-item">*</span></label>
		<div class="inner-row column">
			<div class="row">
				<input type="checkbox" name="" id="discord" class="validate[required,minCheckbox[1]]" value="" onclick="connectText('discord', 'discord-id')">
				<span>Discord</span>
			</div>
			<div class="row">
				<input type="checkbox" name="" id="skype" class="validate[required,minCheckbox[1]]" value="" onclick="connectText('skype', 'skype-id')">
				<span>Skype</span>
			</div>
		</div>
	</div>

	<div class="outher-row">
		<label>Discord<span class="require-item">*</span></label>
		<input type="text" id="discord-id" name="discord" class="validate[condRequired[discord],minSize[5],maxSize[40]]" placeholder="DiscordのIDを入力してください" disabled>
	</div>

	<div class="outher-row">
		<label>Skype<span class="require-item">*</span></label>
		<input type="text" id="skype-id" name="skype" class="validate[condRequired[skype],minSize[6],maxSize[32]]" placeholder="SkypeのIDを入力してください" disabled>
	</div>

	<div class="reg-btn-area">
		<button type="submit" id="btn" class="reg-btn" name="confirm" value="confirm">確認画面へ</button>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/jquery.validationEngine.min.js" integrity="sha512-MKqdT8JgKftxlK6oK4S+Hh44ivKyaPncl6qN9JZEGKJGQZJMiSoPzehLcbvd/1XMieEP1Q4A3wzzhTrvBUUcUQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-Validation-Engine/2.6.4/languages/jquery.validationEngine-ja.min.js" integrity="sha512-K8+w5u+XycAkuX4BEUoBhGt144N7Lm3tNPp+3SPnOBzkyVby/i7NDrbYjIoB4YmjwyucTElSUhJyjEVvFGv4GA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(function() {
    jQuery("#profile-form").validationEngine();
})
</script>
<script>
	$(function() {
		connectText('pubg-title', 'pubg-myName');
		connectText('pubg-title', 'pubg-rank-select');
		connectText('lol-title', 'lol-myName');
		connectText('lol-title', 'lol-rank-select');
		connectText('discord', 'discord-id');
		connectText('skype', 'skype-id');

		// プロフィール画像変更
		document.getElementById("uploadFile").addEventListener("change", function(e) {
			// 1枚だけ表示する
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
	});
	//チェックボックス有効/無効
	function connectText(chkid, textid) {
        const chk = document.getElementById(chkid).checked

        if (chk === true) {
			// チェックが入っていたら有効化
			document.getElementById(textid).disabled = false;
			return false;
		} else {
			// チェックが入っていなかったら無効化
			document.getElementById(textid).disabled = true;
			return true;
		}
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
