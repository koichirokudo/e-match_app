<?= $this->Html->css('login'); ?>
<div class="bg"></div>
<div class="wrapper">
    <h2>ログイン</h2>
    <?php echo $this->Form->create(null, ["type" => "post", "url" => ["controller" => "login", "action" => "login"], "onsubmit" => "return window.check();"]) ?>
    <div class="input_area">
        <p>メールアドレス</p>
        <input type="email" id="mail" name="mail" maxlength="100"/><br/>
        <p>パスワード</p>
        <input type="password" id="pass" name="passwd" maxlength="100"/>
    </div>

    <div class="btn_area">
        <button class="login_btn" type="submit">ログイン</button>
    </div>
    <p class="passwd_fg">パスワードを忘れた方は<a
            href="<?php echo $this->Url->build(["controller" => "passwordforget", "action" => "display"]) ?>">こちら</a></p>

    <div class="check_area">
        <p id="check" class="err_msg"><?= $err ?></p>
    </div>
</div>

<script>
    function check() {
        const mail = document.getElementById("mail")
        const pass1 = document.getElementById("pass")
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
        if (pass1.value === "") {
            ck.innerHTML = "パスワードが空欄です";
            return false;
        }
    }
</script>
