<?= $this->Html->css('contact'); ?>
<!-- お問い合わせ画面 -->
<?= $this->Form->create(null, ["type" => "post", "url" => ["controller" => "contact", "action" => "send"], "onsubmit" => "return window.check();"]) ?>
<div class="bg"></div>
<div class="contact-wrapper">
    <h2>お問い合わせ</h2>
    <p class="sub_title">お問い合わせはこちらから</p>

    <div class="input_area">
        <p>名前</p>
        <input
            id="name"
            type="text"
            name="name"
            maxlength="50"
            placeholder="例）山田太郎"
            value=""
        />

        <p>メールアドレス</p>
        <input
            id="email"
            type="email"
            name="email"
            maxlength="50"
            placeholder="例）guest@example.com"
            value=""
        />

        <p>お問い合わせ内容</p>
        <textarea
            id="content"
            name="content"
            maxlength="1000"
            placeholder="お問合せ内容を入力"
        ></textarea>
    </div>
    <div class="btn_area">
        <button type="button" class="btn confirm-btn" onClick="contactModalOpen(); insertValue();">
            確認画面へ
        </button>
    </div>

    <div class="check_area">
        <p id="check"></p>
    </div>
</div>

<!-- 確認画面用モーダルウィンドウ -->
<div class="modal-blur">
    <div id="modal" class="modal-wrapper">
        <h2>お問い合わせ 内容確認</h2>
        <p class="modal-msg">
            お問い合わせ内容はこちらで宜しいでしょうか？<br/>
            よろしければ「送信する」ボタンを押して下さい。
        </p>
        <form action="#" method="#" name="#">
            <div class="input_area">
                <p>名前</p>
                <p id="modal-name" class="modal-item"></p>

                <p>メールアドレス</p>
                <p id="modal-email" class="modal-item"></p>

                <p>お問い合わせ内容</p>
                <p id="modal-content" class="modal-item-text"></p>
            </div>
            <div class="btn_area">
                <input type="button" value="内容を修正する" class="modal-close-btn" onclick="contactModalClose();"><br>
                <button type="submit" class="submit-btn" name="submit">送信する</button>
            </div>
        </form>
    </div>
</div>

<script>
    function check() {
        const name = document.getElementById("name")
        const email = document.getElementById("email")
        const content = document.getElementById("content")
        const ck = document.getElementById("check")
        ck.innerHTML = "";
        if (name.value === "") {
            ck.innerHTML = "名前が空欄です";
            return false;
        }
        if (email.value === "") {
            //空欄時
            ck.innerHTML = "メールアドレスが空欄です";
            return false;
        }
        //メールアドレスチェック
        if (email.value.indexOf("@") === -1 || email.value.indexOf(".") === -1) {
            ck.innerHTML = "メールアドレスが正確ではありません";
            return false;
        }

        if (content.value === "") {
            ck.innerHTML = "お問い合わせ内容が空欄です";
            return false;
        }

        return true;
    }

    function contactModalOpen() {
        if (check() === false) {
            return false;
        } else {
            $('.modal-blur').fadeIn();
        }
    }

    function contactModalClose() {
        $('.modal-blur').fadeOut();
    }

    function insertValue() {
        document.getElementById("modal-name").innerHTML = document.getElementById("name").value;
        document.getElementById("modal-email").innerHTML = document.getElementById("email").value;
        document.getElementById("modal-content").innerHTML = document.getElementById("content").value;
    }
</script>
