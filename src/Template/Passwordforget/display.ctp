<?= $this->Html->css('password_forget'); ?>
<div class="bg"></div>
<div class="wrapper">
    <h2>パスワード再設定</h2>
    <?= $this->Form->create(null, ["type" => "post", "url" => ["controller" => "passwordforget", "action" => "request"], "onsubmit" => "return window.check();"]) ?>
    <div class="inputs">
        <p class="label">メールアドレス</p>
        <label for="mail"><input type="email" id="mail" name="mail" maxlength="100"/></label>
    </div>
    <div class="btn_area">
        <button class="login_btn" type="submit">メールを送信する</button>
    </div>
    <p id="check" class="err_msg"></p>
</div>

<script>
    function check() {
        const mail = document.getElementById("mail")
        const ck = document.getElementById("check")
        ck.innerHTML = "";

        if (mail.value === "") {
            //空欄時
            ck.innerHTML = "メールアドレスが空欄です";
            return false;
        }
        //メールアドレスチェック
        if (mail.value.indexOf("@") === -1 || mail.value.indexOf(".") === -1) {
            ck.innerHTML = "メールアドレスが正確ではありません";
            return false;
        }
    }
</script>
