<?php

namespace App\Controller;

use Cake\Filesystem\File;

class ProfileeditController extends AppController //Startのみしか使われない
{
    function index()
    {
        if (empty($this->request->getCookie("user"))) {
            $this->redirect("/");
            return;
        }

        $table = $this->getTableLocator()->get("users"); // usersテーブルを使う宣言
        $user = $table->get($this->request->getCookie("user_id"));
        $this->set("user", $user);

    }

    function confirm()
    {
        // プロフィール確認画面へ表示
        $p = $this->request->getData();
        $gameTitle = $p["game-title"];

        $table = $this->getTableLocator()->get("users");
        $user = $table->get($this->request->getCookie("user_id"));

        $pubgFlg = 0;
        $lolFlg = 0;
        $titleArray = array();

        foreach ($gameTitle as $gameTitles) {
            switch ($gameTitles) {
                case "2":
                    $titleArray[] = "Player Unknown's Battle Ground";
                    $pubgFlg = 1;
                    break;
                case "3":
                    $titleArray[] = "League Of Legends";
                    $lolFlg = 1;
                    break;
            }
        }

        if ($pubgFlg === 1) {
            $this->set("pubgName", $p["pubg-name"]);
            $this->set("pubgRank", $p["pubg-rank-select"]);
        } else {
            $this->set("pubgName", "未設定");
            $this->set("pubgRank", "未設定");
        }

        if ($lolFlg === 1) {
            $this->set("lolName", $p["lol-name"]);
            $this->set("lolRank", $p["lol-rank-select"]);
        } else {
            $this->set("lolName", "未設定");
            $this->set("lolRank", "未設定");
        }

        $this->set("titleArray", $titleArray);
        $this->set("pubgFlg", $pubgFlg);
        $this->set("lolFlg", $lolFlg);
        $this->set("myIntro", $p["my-intro"]);
        $this->set("myTeam", $p["my-team"]);

        // サムネ画像はwebrootへアップロード後、表示(メールアドレス.ファイル名)
        $f = $p["thumbnail-file"];
        if (!empty($f["name"])) {
            $c = $this->request->getCookie("user");
            $c = $c . "_thumbnail_" . $f["name"];
            move_uploaded_file($f["tmp_name"], "img/" . $c);
            $this->set("file", $c);
        } else {
            $this->set("file", $user->pf_img);
        }

        if ("0" === $p["values"]) {
            $tmp = "楽しんでゲームをしたい！";
            $this->set("values", $tmp);
            $this->set("val", $p["values"]);
        } else if ("1" === $p["values"]) {
            $tmp = "本気でゲームをしたい！";
            $this->set("values", $tmp);
            $this->set("val", $p["values"]);
        }

        if ("0" === $p["tournament"]) {
            $tmp = "大会に出場したくない！";
            $this->set("tournament", $tmp);
            $this->set("tmt", $p["tournament"]);
        } else if ("1" === $p["tournament"]) {
            $tmp = "大会に出場したい！";
            $this->set("tournament", $tmp);
            $this->set("tmt", $p["tournament"]);
        }

        if (!isset($p["discord"])) {
            $this->set("discord", "未設定");
        } else {
            $this->set("discord", $p["discord"]);
        }
        if (!isset($p["skype"])) {
            $this->set("skype", "未設定");
        } else {
            $this->set("skype", $p["skype"]);
        }
    }

    function register()
    {
        // DB登録
        $table = $this->getTableLocator()->get("users"); // usersテーブルを使う宣言
        $data = $table->get($this->request->getCookie("user_id"));
        $p = $this->request->getData();
        $data->pf_img = $p["thumbnail"];
        $data->pubg_flg = $p["pubgFlg"];
        $data->lol_flg = $p["lolFlg"];
        $data->pubg_name = $p["pubgName"];
        $data->lol_name = $p["lolName"];
        $data->pubg_goal = $p["pubgGoal"];
        $data->lol_goal = $p["lolGoal"];
        $data->intro = $p["myIntro"];
        $data->team = $p["myTeam"];
        $data->game_values = $p["val"];
        $data->tmt_flg = $p["tmt"];
        $data->discord = $p["discord"];
        $data->skype = $p["skype"];

        // api取得
        $type = 0;

        if ($p["pubgFlg"] === "1") {
            // pubg api
            $accountId = "none";
            $seasonId = "none";
            $getPubgInfo = new getPubgInfo();
            $pubgPlayerInfo = $getPubgInfo->getPlayerInfo($p["pubgName"], $accountId, $seasonId, $type);
            if ($pubgPlayerInfo["result"] === false) {
                $data->pubg_flg = 0;
            }
            $this->set('pubgPlayerInfo', $pubgPlayerInfo);
            $data->pubg_id = $pubgPlayerInfo["accountId"];
            $data->pubg_seasonid = $pubgPlayerInfo["seasonId"];
            $data->pubg_solorank = $pubgPlayerInfo["soloRank"];
            $data->pubg_duorank = $pubgPlayerInfo["duoRank"];
            $data->pubg_squadrank = $pubgPlayerInfo["sqRank"];
            $data->pubg_solokd = $pubgPlayerInfo["soloKd"];
            $data->pubg_duokd = $pubgPlayerInfo["duoKd"];
            $data->pubg_squadkd = $pubgPlayerInfo["sqKd"];
            $data->pubg_solopoints = $pubgPlayerInfo["soloPoints"];
            $data->pubg_duopoints = $pubgPlayerInfo["duoPoints"];
            $data->pubg_squadpoints = $pubgPlayerInfo["sqPoints"];
        }

        if ($p["lolFlg"] === "1") {
            // lol api
            $summonerId = "none";
            $getLolInfo = new getLolInfo();
            $lolPlayerInfo = $getLolInfo->getLolInfo($p["lolName"], $summonerId, $type);
            if ($lolPlayerInfo["result"] === false) {
                $data->lol_flg = 0;
            }
            $this->set('lolPlayerInfo', $lolPlayerInfo);
            $data->lol_id = $lolPlayerInfo["accountId"];
            $data->lol_summonerid = $lolPlayerInfo["summonerId"];
            $data->lol_solorank = $lolPlayerInfo["soloRank"];
            $data->lol_points = $lolPlayerInfo["leaguePoints"];
            $data->lol_winrate = $lolPlayerInfo["winRate"];
        }

        // DB保存
        $table->save($data);

        // セッションを作成
        $user_name = $data->user_name;
        $session = $this->request->session();
        $session->write('username', $user_name);
        $this->set('username', $session->read('username'));

        // リダイレクト
        $this->redirect(["controller" => "top", "action" => "index"]);
    }
}
