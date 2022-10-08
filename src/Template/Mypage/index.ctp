<?= $this->Html->css('mypage') ?>
<div class="game_wrapper">
    <div class="wrapper">
        <h2 class="pubg_title"><i class="fas fa-gamepad"></i>Player Unknown's Battle Ground</h2>
        <h3 id="pubg_h3">おすすめのプレイヤー</h3>
        <div id="pubg_row" class="row"></div>
        <div id="pubg_more" class="more">
            <a href="<?php echo $this->Url->build(["controller" => "playerdetail", "action" => "index"]) ?>?g=pubg">もっと見る</a>
        </div>
    </div>
    <div class="wrapper">
        <h2 class="lol_title"><i class="fas fa-gamepad"></i>League Of Legends</h2>
        <h3 id="lol_h3">おすすめのプレイヤー</h3>
        <div id="lol_row" class="row"></div>
        <div id="lol_more" class="more">
            <a href="<?php echo $this->Url->build(["controller" => "playerdetail", "action" => "index"]) ?>?g=lol">もっと見る</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
    //プレイヤー表示数
    const PUBGPLAYER_COUNT = <?= h($pubgCnt) ?>;
    const LOLPLAYER_COUNT = <?= h($lolCnt) ?>;
    const IMAGEPATH = "/img/";
    const PUBGFLG = <?= h($pubgFlg) ?>;
    const LOLFLG = <?= h($lolFlg) ?>;

    // プレイヤーカウント
    let currentCnt = 0;

    // ---------------- PUBGプレイヤーの表示 ------------------
    function pubgPlayerDisp(playerCnt, flg) {
        let pubg
        if (flg === 1 && playerCnt !== 0) {
            let row = document.getElementById("pubg_row");
            let pubgData = JSON.parse('<?= $pubgPlayerInfo ?>');
            for (let i = 0; i < playerCnt; i++) {
                cnt = i + 1;
                if (pubgData[i]['result'] === false) {
                    div = `
                <div class="player" id="pubg_player${cnt}">
                    <p class="data-failure">データの取得に失敗</p>
                </div>
                `
                } else {
                    div = `
                <div class="player" id="pubg_player${cnt}">
                    <img src="${IMAGEPATH + pubgData[i]['thumbnail']}" alt="プロフィール画像">
                    <ul>
                    <li>${pubgData[i]['username']}</li>
                    <li>SoloRank: ${pubgData[i]['soloRank']}</li>
                    <li>RankPoints: ${pubgData[i]['rankPoints']}</li>
                    </ul>
                    <a href="<?php echo $this->Url->build(["controller" => "profiledetail", "action" => "index"]) ?>?id=${pubgData[i]['id']}"></a>
                </div>
                `
                }
                row.innerHTML = row.innerHTML + div;
                currentCnt = i;
            }
        } else {
            pubg = "pubg";
            infoMsg(pubg);
        }
    }

    // ---------------- LOLプレイヤーの表示 ------------------
    function lolPlayerDisp(playerCnt, flg) {
        let lol
        if (flg === 1 && playerCnt !== 0) {
            // 変数宣言
            let div = "";
            let row = document.getElementById("lol_row");
            let lolData = JSON.parse('<?= $lolPlayerInfo ?>');
            for (let i = 0; i < playerCnt; i++) {
                cnt = i + 1;
                if (lolData[i]['result'] === false) {
                    div = `
                <div class="player" id="lol_player${cnt}">
                    <p class="data-failure">データの取得に失敗</p>
                </div>
                `
                } else {
                    div = `
                <div class="player" id="lol_player${cnt}">
                    <img src="${IMAGEPATH + lolData[i]['thumbnail']}" alt="プロフィール画像">
                    <ul>
                        <li>${lolData[i]['username']}</li>
                        <li>Rank: ${lolData[i]['soloRank']}</li>
                        <li>LeaguePoints: ${lolData[i]['leaguePoints']}</li>
                    </ul>
                    <a href="<?= $this->Url->build(["controller" => "profiledetail", "action" => "index"]) ?>?id=${lolData[i]['accountid']}"></a>
                </div>
                `
                }
                row.innerHTML = row.innerHTML + div;
                // currentCntに現在のiの値を保存
                currentCnt = i;
            }
        } else {
            lol = "lol";
            infoMsg(lol);
        }
    }

    function infoMsg(gameTitle) {
        let row = ""
        let more = ""
        let h3 = ""
        switch (gameTitle) {
            case "pubg":
                h3 = document.getElementById("pubg_h3");
                row = document.getElementById("pubg_row");
                more = document.getElementById("pubg_more");
                break;
            case "lol":
                h3 = document.getElementById("lol_h3");
                row = document.getElementById("lol_row");
                more = document.getElementById("lol_more");
                break;
        }
        div = `
    <p class="info-msg">登録されていません</p>
    `
        row.innerHTML = row.innerHTML + div;
        h3.innerHTML = "";
        more.innerHTML = "";
    }

    // ----------------- PUBG Player SlideShow -----------------
    function pubgPlayerSlide(flg) {
        if (flg === 1) {
            $('#pubg_row').slick({
                autoplay: true,
                infinite: true,
                arrows: true,
                autoplaySpeed: 5000,
                slidesToShow: 6,
                slidesToScroll: 2,
                responsive: [{
                    breakpoint: 960, //ブレークポイントが1000px
                    settings: {
                        slidesToShow: 4, //表示するスライドの数
                        slidesToScroll: 2, //スクロールで切り替わるスライドの数
                    },
                }, {
                    breakpoint: 600, //ブレークポイントが480px
                    settings: {
                        slidesToShow: 2, //表示するスライドの数
                        slidesToScroll: 2, //スクロールで切り替わるスライドの数
                    },
                }, {
                    breakpoint: 480, //ブレークポイントが480px
                    settings: {
                        slidesToShow: 1, //表示するスライドの数
                        slidesToScroll: 1, //スクロールで切り替わるスライドの数
                    },
                }],
            });
        }
    }

    // ----------------- LOL Player SlideShow -----------------
    function lolPlayerSlide(flg) {
        if (flg === 1) {
            $('#lol_row').slick({
                autoplay: true,
                infinite: true,
                arrows: true,
                autoplaySpeed: 5000,
                slidesToShow: 6,
                slidesToScroll: 2,
                responsive: [{
                    breakpoint: 960, //ブレークポイントが1000px
                    settings: {
                        slidesToShow: 4, //表示するスライドの数
                        slidesToScroll: 2, //スクロールで切り替わるスライドの数
                    },
                }, {
                    breakpoint: 600, //ブレークポイントが480px
                    settings: {
                        slidesToShow: 2, //表示するスライドの数
                        slidesToScroll: 2, //スクロールで切り替わるスライドの数
                    },
                }, {
                    breakpoint: 480, //ブレークポイントが480px
                    settings: {
                        slidesToShow: 1, //表示するスライドの数
                        slidesToScroll: 1, //スクロールで切り替わるスライドの数
                    },
                }],
            });
        }
    }

    // ページ読み込み時処理
    window.onload = function playerDisp() {
        pubgPlayerDisp(PUBGPLAYER_COUNT, PUBGFLG);
        lolPlayerDisp(LOLPLAYER_COUNT, LOLFLG);
        pubgPlayerSlide(PUBGFLG);
        lolPlayerSlide(LOLFLG);
    }
</script>
