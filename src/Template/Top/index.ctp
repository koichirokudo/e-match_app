<?= $this->Html->css('top'); ?>
<div class="logout">ログアウトしました</div>
<div class="bg"></div>
<!-- eyecatch -->
<div class="eyecatch">
    <picture>
        <source media="(min-width: 600px)" srcset="/img/eyecatch.jpg">
        <img src="/img/eyecatch_mobile.jpg">
    </picture>
    <p id="letter">
        あなたにピッタリのゲーム仲間を見つけよう！<br/>E-matchはあなたと同じ価値観を持った<br/>プレイヤーとマッチングすることができます！
    </p>
</div>
<!-- /eyecatch -->

<!-- guide -->
<section class="guide">
    <h2>E-matchの使い方</h2>
    <div class="guide_block">
        <div class="desc desc-right">
            <h3>１．メールアドレスを登録</h3>
            <p>アカウント登録画面からメールアドレスを登録します。</p>
        </div>
        <img class="img1" src="/img/guide_img1.jpg" alt="ガイド画像1"/>
    </div>
    <div class="guide_block">
        <div class="desc desc-left">
            <h3>２．プロフィールを登録</h3>
            <p>
                自分のプロフィールを登録しましょう！<br/>具体的に書くことで同じ価値観を持ったプレイヤーと<br/>一緒にプレイできる可能性が高くなります。
            </p>
        </div>
        <img class="img2" src="/img/guide_img2.jpg" alt="ガイド画像2"/>
    </div>
    <div class="guide_block">
        <div class="desc desc-right">
            <h3>３．プレイヤーにリクエストを出す</h3>
            <p>
                希望のプレイヤーを見つけてリクエストしましょう。<br/>リクエストが許可されるとお互いのDiscord、SkypeのIDが<br/>プロフィールから閲覧できプレイヤー同士の交流が可能になります。
            </p>
        </div>
        <img class="img3" src="/img/guide_img3.jpg" alt="ガイド画像3"/>
    </div>
</section>
<!-- /guide -->

<!-- game_title -->
<section class="game_title">
    <h2>ゲームタイトル</h2>
    <ul>
        <li>Player Unknown's Battle Ground</li>
        <li>League Of Legends</li>
    </ul>
</section>
<!-- /guide -->

<!-- account_reg -->
<?php if (empty($this->request->getCookie("user"))) { ?>
    <section class="account_reg">
        <h2>アカウント登録</h2>
        <div class="btn_wrapper">
            <button type="button" class="register_btn2"
                    onclick="location.href ='<?php echo $this->Url->build(["controller" => "accountreg", "action" => "index"]) ?>'">
                アカウント登録
            </button>
        </div>
        <p>登録済みの方はこちらから<a href="<?php echo $this->Url->build(["controller" => "login", "action" => "index"]) ?>"
                              class="login_btn2">ログイン</a></p>
    </section>
<?php } ?>
<!-- /account_reg -->
<div id="page_top"><a href="#"></a></div>

<script>
    $(function () {
        let appear = false
        const pagetop = $('#page_top')
        $(window).scroll(function () {
            if ($(this).scrollTop() > 200) { //200pxスクロールしたら
                if (appear === false) {
                    appear = true;
                    pagetop.stop().animate({
                        'bottom': '50px', //下から50pxの位置に
                    }, 300); //0.3秒かけて現れる
                }
            } else {
                if (appear) {
                    appear = false;
                    pagetop.stop().animate({
                        'bottom': '-50px', //下から-50pxの位置に
                    }, 300); //0.3秒かけて隠れる
                }
            }
        });
        pagetop.click(function () {
            $('body, html').animate({
                scrollTop: 0,
            }, 500); //0.5秒かけてトップへ戻る
            return false;
        });
    });
</script>
