<?= $this->Html->css('player_detail'); ?>
<div id="game-wrapper" class="game-wrapper">
    <h2 id="game-name"></h2>
    <div class="game-header">
        <h3>おすすめのプレイヤー</h3>
        <div class="sort">
            <span>並べ替え</span>
            <label for="sort">
                <select id="sort" class="sort">
                    <option value="0">レベルの高い順</option>
                    <option value="1">レベルの低い順</option>
                    <option value="2" selected>ソロランクの高い順</option>
                    <option value="3">ソロランクの低い順</option>
                    <option value="4" disabled>デュオランクの高い順</option>
                    <option value="5" disabled>デュオランクの低い順</option>
                </select>
            </label>
        </div>
    </div>
    <div id="playerRow" class="flex"></div>
    <div class="pagination-block">
        <span class="pageButton outline-none" id="button_prev">Prev</span>
        <span id="page_number" class="outline-none"></span>
        <span class="pageButton outline-none" id="button_next">Next</span>
    </div>
</div>

<script>
    //----------------------------
    //ページング
    //----------------------------

    const prevButton = document.getElementById("button_prev");
    const nextButton = document.getElementById("button_next");
    const clickPageNumber = document.querySelectorAll(".clickPageNumber");
    const maxPlayer = <?= h($count) ?>;
    const gameTitle = "<?= h($gameName) ?>";
    const imagePath = "/img/"

    let current_page = 1; // 現在のページ数
    let records_per_page = 24; // １ページごとのプレイヤー表示数
    let pageNum = 1; // ページ数のコントロール

    // 初期化
    let init = function () {
        initPlayerLoad(gameTitle, maxPlayer);
        changePage(1);
        pageNumbers();
        selectedPage();
        clickPage();
        hidePage();
        addEventListeners();
    };

    // プレイヤー読み込み
    let initPlayerLoad = function () {
        const array = <?= $record; ?>;
        for (let i = 0; i < maxPlayer; i++) {
            pageNum = playerLoad(gameTitle, i, records_per_page, numPages(), pageNum, array[i]);
        }
        if (gameTitle === "lol") {
            levelSortHide();
        }
        if (gameTitle === "pubg") {
            pubgSortAdd();
            levelSortHide();
        }
    };

    // 該当ページの非表示
    let hidePage = function (targetPage) {
        $(".page" + targetPage).hide();
    };

    // ページ遷移ボタン
    let addEventListeners = function () {
        prevButton.addEventListener("click", prevPage);
        nextButton.addEventListener("click", nextPage);
    };

    // ページボタン透明度
    let selectedPage = function () {
        let page_number = document
            .getElementById("page_number")
            .getElementsByClassName("clickPageNumber");
        for (let i = 0; i < page_number.length; i++) {
            if (i === current_page - 1) {
                page_number[i].style.opacity = "1.0";
            } else {
                page_number[i].style.opacity = "0.5";
            }
        }
    };

    // ページボタン透明度
    let checkButtonOpacity = function () {
        current_page === 1 ?
            prevButton.classList.add("opacity") :
            prevButton.classList.remove("opacity");
        current_page === numPages() ?
            nextButton.classList.add("opacity") :
            nextButton.classList.remove("opacity");
    };

    // ページ切替
    let changePage = function (page) {
        const playerRow = document.getElementById("playerRow");

        if (page < 1) {
            page = 1;
        }
        if (page > numPages() - 1) {
            page = numPages();
        }
        // ページ表示
        $(".page" + page).show();
        $("html,body").animate({
            scrollTop: 0,
        }, "300");
        checkButtonOpacity();
        selectedPage();
    };

    // prevボタン
    let prevPage = function () {
        if (current_page > 1) {
            hidePage(current_page);
            current_page--;
            changePage(current_page);
        }
    };

    // nextボタン
    let nextPage = function () {
        if (current_page < numPages()) {
            hidePage(current_page);
            current_page++;
            changePage(current_page);
        }
    };

    // 番号ボタン
    let clickPage = function () {
        document.addEventListener("click", function (e) {
            if (
                e.target.nodeName === "SPAN" &&
                e.target.classList.contains("clickPageNumber")
            ) {
                hidePage(current_page);
                current_page = e.target.textContent;
                changePage(current_page);
            }
        });
    };

    let pageNumbers = function () {
        let pageNumber = document.getElementById("page_number");
        pageNumber.innerHTML = "";

        for (let i = 1; i < numPages() + 1; i++) {
            pageNumber.innerHTML +=
                "<span class='clickPageNumber'>" + i + "</span>";
        }
    };

    // ページ番号の計算(最大ページ数)
    let numPages = function () {
        return Math.ceil(maxPlayer / records_per_page);
    };

    init();

    //----------------------------
    //プレイヤー読み込み
    //----------------------------
    function playerLoad(gameTitle, playerCnt, records_per_page, maxPage, pageNum, array) {
        // 変数宣言
        let playerRow = document.getElementById("playerRow");
        let div = "";
        let gameName = "";

        for (let i = 0; i < maxPage; i++) {
            if (records_per_page * (i + 1) === playerCnt) {
                pageNum++;
            }
        }

        // lolはレベルとランクを、pubgはソロランクとデュオランクを表示する
        switch (gameTitle) {
            case "lol":
                gameName = document.getElementById("game-name");
                gameName.innerHTML = "League Of Legends";
                div = `
                    <div name="player" class="player page${pageNum}">
                        <img src="${imagePath}${array["pf_img"]}">
                        <ul class="player-info">
                            <li class="player-name">Name:${array["user_name"]}</li>
                            <li class="player-rank">Rank:${array["lol_solorank"]}</li>
                            <li class="player-points">LeaguePoints:${array["lol_points"]}</li>
                        </ul>
                        <a href="<?php echo $this->Url->build(["controller" => "profiledetail", "action" => "index"]) ?>?id=${array["id"]}"></a>
                    </div>
                    `;
                break;
            case "pubg":
                gameName = document.getElementById("game-name");
                gameName.innerHTML = "Player Unknown's Battle Ground";
                div =
                    `
                    <div name="player" class="player page${pageNum}">
                    <img src="${imagePath}${array["pf_img"]}">
                    <ul class="player-info">
                        <li class="player-name">Name:${array["user_name"]}</li>
                        <li class="player-rank">Solo:${array["pubg_solorank"]}</li>
                        <li class="player-duorank">Duo:${array["pubg_duorank"]}</li>
                    </ul>
                    <a href="<?php echo $this->Url->build(["controller" => "profiledetail", "action" => "index"]) ?>?id=${array["id"]}"></a>
                    </div>
                    `;
                break;
        }

        // innerHTMLに追加
        playerRow.innerHTML = playerRow.innerHTML + div;

        // ページ
        $(".page" + pageNum).hide();

        return pageNum;
    }

    //----------------------------
    //レベルソート機能無効化
    //----------------------------
    function levelSortHide() {
        let options1 = $('select#sort option[value="0"]');
        options1.attr("disabled", "disabled");
        let options2 = $('select#sort option[value="1"]');
        options2.attr("disabled", "disabled");
    }

    //----------------------------
    //PUBGランクソート機能有効化
    //----------------------------
    function pubgSortAdd() {
        let options1 = $('select#sort option[value="4"]');
        options1.attr("disabled", false);
        let options2 = $('select#sort option[value="5"]');
        options2.attr("disabled", false);
    }

    //----------------------------
    //ソート機能
    //----------------------------
    function sort(type, gameTitle) {
        let html1, html2, tmp;
        let RankArray;

        // ゲーム毎に配列を読み込む
        switch (gameTitle) {
            case "pubg":
                RankArray = [
                    // 29
                    "Lone Survivor",
                    "Survivor",
                    "Expert",
                    "Specialist1",
                    "Specialist2",
                    "Specialist3",
                    "Specialist4",
                    "Specialist5",
                    "Skilled1",
                    "Skilled2",
                    "Skilled3",
                    "Skilled4",
                    "Skilled5",
                    "Experienced1",
                    "Experienced2",
                    "Experienced3",
                    "Experienced4",
                    "Experienced5",
                    "Novice1",
                    "Novice2",
                    "Novice3",
                    "Novice4",
                    "Novice5",
                    "Beginner1",
                    "Beginner2",
                    "Beginner3",
                    "Beginner4",
                    "Beginner5",
                    "UnRanked",
                    "no data",
                ];
                break;

            case "lol":
                RankArray = [
                    // 28
                    "Challenger",
                    "Grandmaster",
                    "Master",
                    "Diamond1",
                    "Diamond2",
                    "Diamond3",
                    "Diamond4",
                    "Platinum1",
                    "Platinum2",
                    "Platinum3",
                    "Platinum4",
                    "Gold1",
                    "Gold2",
                    "Gold3",
                    "Gold4",
                    "Silver1",
                    "Silver2",
                    "Silver3",
                    "Silver4",
                    "Bronze1",
                    "Bronze2",
                    "Bronze3",
                    "Bronze4",
                    "Iron1",
                    "Iron2",
                    "Iron3",
                    "Iron4",
                    "UnRanked",
                    "no data",
                ];
                break;
        }

        let namelist = document.getElementsByName("player");
        let playerArraylevel = document.querySelectorAll(".player-level");
        let playerArrayrank = document.querySelectorAll(".player-rank");
        let playerArrayduorank = document.querySelectorAll(".player-duorank");

        for (let i = 0; i < namelist.length - 1; i++) {
            for (let j = namelist.length - 1; j > i; j--) {
                namelist = document.getElementsByName("player");
                playerArraylevel = document.querySelectorAll(".player-level");
                playerArrayrank = document.querySelectorAll(".player-rank");
                playerArrayduorank = document.querySelectorAll(".player-duorank");

                let k
                switch (type) {
                    case 1: // レベルの高い順
                        if (parseInt(playerArraylevel[j].innerHTML.substr(6)) > parseInt(playerArraylevel[j - 1].innerHTML.substr(6))) {
                            tmp = namelist[j].innerHTML;
                            namelist[j].innerHTML = namelist[j - 1].innerHTML;
                            namelist[j - 1].innerHTML = tmp;
                        }
                        break;

                    case 2: // レベルの低い順
                        if (parseInt(playerArraylevel[j].innerHTML.substr(6)) < parseInt(playerArraylevel[j - 1].innerHTML.substr(6))) {
                            tmp = namelist[j].innerHTML;
                            namelist[j].innerHTML = namelist[j - 1].innerHTML;
                            namelist[j - 1].innerHTML = tmp;
                        }
                        break;

                    case 3: // ソロランクの高い順
                        let index1 = -1,
                            index2 = -1;
                        for (k = 0; k < RankArray.length; k++) {
                            if (playerArrayrank[i].innerHTML.substr(5) === RankArray[k]) {
                                index1 = k;
                            }
                            if (playerArrayrank[j].innerHTML.substr(5) === RankArray[k]) {
                                index2 = k;
                            }
                        }
                        if (index1 > index2) {
                            html1 = namelist[i].innerHTML;
                            html2 = namelist[j].innerHTML;
                            namelist[i].innerHTML = html2;
                            namelist[j].innerHTML = html1;
                        }
                        break;

                    case 4: // ソロランクの低い順
                        let index3 = -1,
                            index4 = -1;
                        for (k = 0; k < RankArray.length; k++) {
                            if (playerArrayrank[i].innerHTML.substr(5) === RankArray[k]) {
                                index3 = k;
                            }
                            if (playerArrayrank[j].innerHTML.substr(5) === RankArray[k]) {
                                index4 = k;
                            }
                        }
                        if (index3 < index4) {
                            html1 = namelist[i].innerHTML;
                            html2 = namelist[j].innerHTML;
                            namelist[i].innerHTML = html2;
                            namelist[j].innerHTML = html1;
                        }
                        break;
                    case 5: // デュオランクの高い順
                        let index5 = -1,
                            index6 = -1;
                        for (k = 0; k < RankArray.length; k++) {
                            if (playerArrayduorank[i].innerHTML.substr(4) === RankArray[k]) {
                                index5 = k;
                            }
                            if (playerArrayduorank[j].innerHTML.substr(4) === RankArray[k]) {
                                index6 = k;
                            }
                        }
                        if (index5 > index6) {
                            html1 = namelist[i].innerHTML;
                            html2 = namelist[j].innerHTML;
                            namelist[i].innerHTML = html2;
                            namelist[j].innerHTML = html1;
                        }
                        break;

                    case 6: // デュオランクの低い順
                        let index7 = -1,
                            index8 = -1;
                        for (k = 0; k < RankArray.length; k++) {
                            if (playerArrayduorank[i].innerHTML.substr(4) === RankArray[k]) {
                                index7 = k;
                            }
                            if (playerArrayduorank[j].innerHTML.substr(4) === RankArray[k]) {
                                index8 = k;
                            }
                        }
                        if (index7 < index8) {
                            html1 = namelist[i].innerHTML;
                            html2 = namelist[j].innerHTML;
                            namelist[i].innerHTML = html2;
                            namelist[j].innerHTML = html1;
                        }
                        break;
                }
            }
        }
    }

    //select要素の取得
    let select = document.querySelector("#sort");
    //option要素の取得（配列）
    let options = document.querySelectorAll("#sort option");

    select.addEventListener("change", function (pagination) {
        //選択されたoption番号を取得
        let index = this.selectedIndex;

        switch (index) {
            case 0:
                sort(1, gameTitle);
                break;
            case 1:
                sort(2, gameTitle);
                break;
            case 2:
                sort(3, gameTitle);
                break;
            case 3:
                sort(4, gameTitle);
                break;
            case 4:
                sort(5, gameTitle);
                break;
            case 5:
                sort(6, gameTitle);
                break;
        }
        current_page = 1;
        changePage(1); // １ページ目に戻る
    });
</script>
