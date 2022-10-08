<?= $this->Html->css('account_reg_error'); ?>
<div class="bg"></div>
<div class="account-reg">
    <h2>アカウント登録</h2>
    <?php echo $this->Form->create(null, ["type" => "post", "url" => ["controller" => "accountreg", "action" => "create"], "onsubmit" => "return window.check();"]) ?>
    <div class="input-wrapper">
        <div class="input_area">
            <p>メールアドレス</p>
            <input type="email" id="mail" name="mail" size="40" max-length="100"/><br/>
            <p>パスワード</p>
            <input type="password" id="pass1" name="pass" size="40" max-length="100"/><br/>
            <p>パスワード確認用</p>
            <input type="password" id="pass2" size="40" max-length="100"/><br/>
        </div>
        <div class="btn_area">
            <button class="login_btn" type="submit">
                アカウント登録
            </button>
        </div>
        <div class="login-msg-area">
            <p class="login-msg">
                <a href="<?= $this->Url->build(["controller" => "login", "action" => "index"]) ?>">既にアカウントをお持ちですか？</a>
            </p>
        </div>
        <div class="check-area">
            <p class="check" id="check" name="check">既に登録されたメールアドレスです</p>
        </div>
    </div>
    </form>
</div>

<script>
    function check() {
        const mail = document.getElementById("mail")
        const pass1 = document.getElementById("pass1")
        const pass2 = document.getElementById("pass2")
        const ck = document.getElementById("check")
        ck.innerHTML = "";
        if (mail.value === "") { //空欄時
            ck.innerHTML = "メールアドレスが空欄です";
            return;
        }
        //メールアドレスチェック
        if (mail.value.indexOf("@") === -1 ||
            mail.value.indexOf(".") === -1) {
            ck.innerHTML = "メールアドレスが正確ではありません";
            return;
        }
        if (pass1.value === "") {
            ck.innerHTML = "パスワードが空欄です";
            return;
        }
        if (pass2.value === "") {
            ck.innerHTML = "パスワード確認欄が空欄です";
            return;
        }
        if (pass1.value !== pass2.value) {
            ck.innerHTML = "パスワードが不一致です";
        }
    }
</script>
