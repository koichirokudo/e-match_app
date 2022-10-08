<?= $this->Html->css('footer'); ?>
<div class="footer">
    <p>&#169; 2020 E-match All Rights Reserved.</p>
</div>


<div class="modal_container">
    <h3 class="title">ゲームプレイリクエスト</h3>
    <?php
    foreach ($rq as $i) {
        if ($i->user_id == $this->request->getCookie("user_id")) {
            switch ($i->user_stat) {
                case 1:
                    ?>
                    <div class="item">
                        <p class="before_msg">
                            <a href="<?php echo $this->Url->build(["controller" => "profiledetail", "action" => "index"]) ?>?id=<?= $i->rq_user_id ?>"><?= $i->rq_name ?></a>さんへゲームプレイリクエストを送りました。
                        </p>
                        <p class="after_msg"></p>
                        <div class="modal_btn_area">
                            <a class="btn_profile"
                               href="<?php echo $this->Url->build(["controller" => "profiledetail", "action" => "index"]) ?>?id=<?= $i->rq_user_id ?>">プロフィールを見る</a>
                        </div>
                    </div>
                    <?php break;
                case 2:
                    ?>
                    <div class="item rq_permitted">
                        <p class="before_msg">
                            <a href="<?php echo $this->Url->build(["controller" => "profiledetail", "action" => "index"]) ?>?id=<?= $i->rq_user_id ?>"><?= $i->rq_name ?></a>さんへゲームプレイリクエストを送りました。
                        </p>
                        <p class="after_msg permit_msg">
                            <?= $i->rq_name ?>さんからゲームプレイリクエストが許可されました。
                        </p>
                        <div class="modal_btn_area">
                            <a class="btn_profile"
                               href="<?php echo $this->Url->build(["controller" => "profiledetail", "action" => "index"]) ?>?id=<?= $i->rq_user_id ?>">プロフィールを見る</a>
                        </div>
                    </div>
                    <?php break;
                case 3:
                    ?>
                    <div class="item rq_rejected">
                        <p class="before_msg">
                            <a href="<?php echo $this->Url->build(["controller" => "profiledetail", "action" => "index"]) ?>?id=<?= $i->rq_user_id ?>"><?= $i->rq_name ?></a>さんへゲームプレイリクエストを送りました。
                        </p>
                        <p class="after_msg reject_msg">
                            <?= $i->rq_name ?>さんからゲームプレイリクエストを拒否されました。
                        </p>
                        <div class="modal_btn_area">
                            <a class="btn_profile"
                               href="<?php echo $this->Url->build(["controller" => "profiledetail", "action" => "index"]) ?>?id=<?= $i->rq_user_id ?>">プロフィールを見る</a>
                        </div>
                    </div>
                    <?php break;
            }
        } else if ($i->rq_user_id == $this->request->getCookie("user_id")) {
            // リクエストされた側
            switch ($i->user_stat) {
                case 1:
                    ?>
                    <div class="item">
                        <p id="before_msg" class="before_msg">
                            <a href="<?php echo $this->Url->build(["controller" => "profiledetail", "action" => "index"]) ?>?id=<?= $i->user_id ?>"><?= $i->username ?></a>さんからゲームプレイリクエストが届きました。
                        </p>
                        <p id="after_msg" class="after_msg"></p>
                        <div class="modal_btn_area">
                            <button type="button" name="?id=<?= $i->id ?>&ok=1&user_id=<?= $i->user_id ?>"
                                    class="btn_allow btn_permit">
                                許可
                            </button>
                            <button type="button" name="?id=<?= $i->id ?>&ok=0&user_id=<?= $i->user_id ?>"
                                    id="btn_reject" class="btn_reject btn_deny">
                                拒否
                            </button>
                        </div>
                    </div>
                    <?php break;
                case 2:
                    ?>
                    <div class="item rq_permitted">
                        <p class="before_msg">
                            <a href="<?php echo $this->Url->build(["controller" => "profiledetail", "action" => "index"]) ?>?id=<?= $i->user_id ?>"><?= $i->username ?></a>さんからゲームプレイリクエストが届きました。
                        </p>
                        <p class="after_msg permit_msg">
                            <?= $i->username ?>さんからのゲームプレイリクエストを許可しました。
                        </p>
                        <div class="modal_btn_area">
                            <button type="button" class="btn_allow btn_permit" disabled>
                                許可
                            </button>
                            <button type="button" id="btn_reject" class="btn_deny" disabled>
                                拒否
                            </button>
                        </div>
                    </div>
                    <?php break;
                case 3:
                    ?>
                    <div class="item rq_rejected">
                        <p class="before_msg">
                            <a href="<?php echo $this->Url->build(["controller" => "profiledetail", "action" => "index"]) ?>?id=<?= $i->user_id ?>"><?= $i->username ?></a>さんからゲームプレイリクエストが届きました。
                        </p>
                        <p class="after_msg reject_msg">
                            <?= $i->username ?>さんからのゲームプレイリクエストを拒否しました。
                        </p>
                        <div class="modal_btn_area">
                            <button type="button" class="btn_allow btn_permit" disabled>
                                許可
                            </button>
                            <button type="button" id="btn_reject" class="btn_deny" disabled>
                                拒否
                            </button>
                        </div>
                    </div>
                    <?php break;
            }
        }
    }
    ?>
    <div class="btn_close_area">
        <button type="button" class="btn_close" onclick="window.modalClose();">閉じる</button>
    </div>
</div>

<script>
    //リクエスト許可
    function request_Permit() {
        let i
        let msg = document.getElementById("after_msg");
        let name = "<?= $i->username ?? '' ?>";

        // 許可メッセージ表示
        msg.innerHTML = name + "さんからのゲームプレイリクエストを許可しました。";
        msg.classList.add("permit_msg");

        // ボタン無効化
        const btnpermit = document.getElementsByClassName("btn_permit")
        for (i = 0; i < btnpermit.length; i++) {
            btnpermit[i].disabled = "true";
        }
        const btnreject = document.getElementsByClassName("btn_reject")
        for (i = 0; i < btnreject.length; i++) {
            btnreject[i].disabled = "true";
        }
        location.href = "<?php echo $this->Url->build(["action" => "okng"])?>" + this.name;
    }

    // リクエスト拒否
    function request_Reject() {
        let i
        let msg = document.getElementById("after_msg");
        let name = "<?= $i->username ?? '' ?>";

        // 拒否メッセージ表示
        msg.innerHTML = name + "さんからのゲームプレイリクエストを拒否しました。";
        msg.classList.add("reject_msg");

        // ボタン無効化
        const btnpermit = document.getElementsByClassName("btn_permit")
        for (i = 0; i < btnpermit.length; i++) {
            btnpermit[i].disabled = "true";
        }
        const btnreject = document.getElementsByClassName("btn_reject")
        for (i = 0; i < btnreject.length; i++) {
            btnreject[i].disabled = "true";
        }
        location.href = "<?php echo $this->Url->build(["action" => "okng"])?>" + this.name;
    }

    const btnpermit = document.getElementsByClassName("btn_permit")
    for (let i = 0; i < btnpermit.length; i++) {
        btnpermit[i].addEventListener("click", request_Permit, false);
    }
    const btnreject = document.getElementsByClassName("btn_reject")
    for (let i = 0; i < btnreject.length; i++) {
        btnreject[i].addEventListener("click", request_Reject, false);
    }

    // 閉じるボタン
    function modalClose() {
        $(".modal_container").fadeOut();
    }


    function modalOpen() {
        $(".modal_container").fadeIn();
        $('.sub-navigation-wrapper').slideToggle(500);
    }
</script>
