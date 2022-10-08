<?= $this->Html->css('header'); ?>
<div class="main-header" ontouchstart="">
    <div class="header-wrapper">
        <div class="main-header-left">
            <a href="<?php echo $this->Url->build(["controller" => "top", "action" => "index"]) ?>">E-match</a>
        </div>
        <?php if (!empty($this->request->getCookie("user"))) { ?>
            <div class="main-header-center">
                <div class="top-navigation">
                    <div class="top-navigation-item">
                        <a href="<?php echo $this->Url->build(["controller" => "playerdetail", "action" => "index"]) ?>?g=pubg"
                           class="top-navi-link">PUBG</a>
                    </div>
                    <div class="top-navigation-item">
                        <a href="<?php echo $this->Url->build(["controller" => "playerdetail", "action" => "index"]) ?>?g=lol"
                           class="top-navi-link">LOL</a>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if (empty($this->request->getCookie("user"))) { ?>
            <div class="main-header-right">
                <div class="top-right-button-wrapper">
                    <div class="right-content-item">
                        <button type="button" name="login" class="login-button">
                            <a href="<?php echo $this->Url->build(["controller" => "login", "action" => "index"]) ?>">ログイン</a>
                        </button>
                    </div>
                    <div class="right-content-item">
                        <button type="button" name="register" class="register-button">
                            <a href="<?php echo $this->Url->build(["controller" => "accountreg", "action" => "index"]) ?>">登録</a>
                        </button>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if (!empty($this->request->getCookie("user"))) { ?>
            <div class="main-header-right-logged">
                <div class="top-right-content-wrapper">
                    <div class="right-content-item">
                        <img src="<?= h($this->Url->image($thumbnail)) ?>" id="sub-navigation-button"
                             class="mypicture sub-navigation">
                        <div class="sub-navigation-wrapper">
                            <ul>
                                <li class="sub-navigation-item mobile-item"><a
                                        href="<?php echo $this->Url->build(["controller" => "playerdetail", "action" => "index"]) ?>?g=pubg">PUBG</a>
                                </li>
                                <li class="sub-navigation-item mobile-item"><a
                                        href="<?php echo $this->Url->build(["controller" => "playerdetail", "action" => "index"]) ?>?g=lol">LOL</a>
                                </li>
                                <li class="sub-navigation-item"><a
                                        href="<?php echo $this->Url->build(["controller" => "profile", "action" => "index"]) ?>">プロフィール</a>
                                </li>
                                <li class="sub-navigation-item"><span style="cursor:pointer"
                                                                      onclick="window.modalOpen()">リクエスト通知</span></li>
                                <li class="sub-navigation-item"><a
                                        href="<?php echo $this->Url->build(["controller" => "mypage", "action" => "index"]) ?>">マイページ</a>
                                </li>
                                <li class="sub-navigation-item"><a
                                        href="<?php echo $this->Url->build(["controller" => "contact", "action" => "index"]) ?>">お問い合わせ</a>
                                </li>
                                <li class="sub-navigation-item"><a
                                        href="<?php echo $this->Url->build(["controller" => "login", "action" => "logout"]) ?>">ログアウト</a>
                                </li>
                            </ul>
                        </div>
                        <span class="myname"><?= h($username); ?></span>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<div class="space1"></div>
<?= $this->Flash->render() ?>


<script>
    //サブナビゲーション表示/非表示
    $('#sub-navigation-button').click(function () {
        $('.sub-navigation-wrapper').slideToggle(500);
    });

    // サブナビゲーションボタン押下時の 処理
    $('.mypicture').click(function () {
        $('.mypicture').toggleClass('toggle-push');
    });
</script>
