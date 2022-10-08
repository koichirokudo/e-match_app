<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

class AppController extends Controller
{
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', ['enableBeforeRedirect' => false,]);
        $this->loadComponent('Flash');

        $table = $this->getTableLocator()->get("requeststats"); // requeststatsを使う
        $data = $table->find()->select(["id" => "requeststats.id", "user_id" => "requeststats.user_id", "rq_user_id" => "requeststats.rq_user_id", "username" => "users.user_name", "rq_name" => "users2.user_name", "user_stat" => "requeststats.rq_state"])->where("users.id=requeststats.user_id and users2.id=requeststats.rq_user_id")->from("requeststats, users, (select * from users) as users2")->all();
        $this->set("rq", $data);

        if (!empty($this->request->getCookie("user_id"))) {
            $table = $this->getTableLocator()->get("users"); // usersテーブルを使う宣言
            $query = $table->get($this->request->getCookie("user_id"));
            $this->set("thumbnail", $query->pf_img);
            $this->set('username', $query->user_name);
        }
    }

    function okng()
    {
        $table = $this->getTableLocator()->get("requeststats"); // usersテーブルを使う宣言
        $id = $this->request->getQuery("?id");
        $id2 = $this->request->getQuery("user_id");
        $ok = $this->request->getQuery("ok");
        $data = $table->find()->where("id=" . $id)->first();
        if ($ok == "1") {
            $data->rq_state = 2;
        } else {
            $data->rq_state = 3;
        }
        $table->save($data);
        $this->redirect(["action" => "index", "id" => $id2]);
    }
}

/* -------- PUBG API -------- */

class getPubgInfo extends AppController
{
    public function getPlayerInfo($name, $accountId, $seasonId, $type): array
    {
        $pubgPlayerInfo = ["accountId" => "", "seasonId" => "", "soloRank" => "no data", "duoRank" => "no data", "sqRank" => "no data", "soloKd" => "", "duoKd" => "", "sqKd" => "", "soloPoints" => 0, "duoPoints" => 0, "sqPoints" => 0, "httpCode" => "", "result" => true];

        if ($type === 0) { // Profile Reg
            // getAccountId
            $url = 'https://api.pubg.com/shards/steam/players?filter[playerNames]=' . $name;
            $accountInfo = $this->getPubgData(0, $url);

            if ($accountInfo["result"] === false) {
                $pubgPlayerInfo["result"] = false;
                $pubgPlayerInfo["httpCode"] = $accountInfo["httpCode"];

                return $pubgPlayerInfo;
            }

            $pubgPlayerInfo["accountId"] = $accountInfo["accountId"];

            // getSeasonId
            $url = 'https://api.pubg.com/shards/steam/seasons';
            $seasonInfo = $this->getPubgData(1, $url);

            if ($seasonInfo["result"] === false) {
                $pubgPlayerInfo["result"] = false;
                $pubgPlayerInfo["httpCode"] = $seasonInfo["httpCode"];

                return $pubgPlayerInfo;
            }

            $pubgPlayerInfo["seasonId"] = $seasonInfo["seasonId"];
            $url = 'https://api.pubg.com/shards/steam/players/' . $pubgPlayerInfo["accountId"] . '/seasons/' . $pubgPlayerInfo["seasonId"];
        } else if ($type === 1) { // Profile
            $pubgPlayerInfo["accountId"] = $accountId;
            $pubgPlayerInfo["seasonId"] = $seasonId;
            $url = 'https://api.pubg.com/shards/steam/players/' . $pubgPlayerInfo["accountId"] . '/seasons/' . $pubgPlayerInfo["seasonId"];
        } else if ($type === 2) { // My Page
            $len = count($accountId);
            $url = 'https://api.pubg.com/shards/steam/seasons/' . $seasonId . '/gameMode/solo/players?filter[playerIds]=';
            for ($i = 0; $i < $len; $i++) {
                $url .= $accountId[$i] . ',';
            }
        }

        // getSeasonData
        $seasonData = $this->getPubgData(2, $url);
        if ($seasonData["result"] === false) {
            $pubgPlayerInfo["result"] = false;
            $pubgPlayerInfo["httpCode"] = $seasonData["httpCode"];

            return $pubgPlayerInfo;
        }

        if ($type !== 2) { // profile
            $pubgPlayerInfo["soloPoints"] = (int)$seasonData["data"]["attributes"]["gameModeStats"]["solo"]["rankPoints"];
            $pubgPlayerInfo["duoPoints"] = (int)$seasonData["data"]["attributes"]["gameModeStats"]["duo"]["rankPoints"];
            $pubgPlayerInfo["sqPoints"] = (int)$seasonData["data"]["attributes"]["gameModeStats"]["squad"]["rankPoints"];
            $pubgPlayerInfo["soloRank"] = $this->rankConversion($seasonData["data"]["attributes"]["gameModeStats"]["solo"]["rankPointsTitle"]);
            $pubgPlayerInfo["duoRank"] = $this->rankConversion($seasonData["data"]["attributes"]["gameModeStats"]["duo"]["rankPointsTitle"]);
            $pubgPlayerInfo["sqRank"] = $this->rankConversion($seasonData["data"]["attributes"]["gameModeStats"]["squad"]["rankPointsTitle"]);

            if ($seasonData["data"]["attributes"]["gameModeStats"]["solo"]["roundsPlayed"] === 0) {
                $pubgPlayerInfo["soloKd"] = "0";
            } else {
                $pubgPlayerInfo["soloKd"] = round($seasonData["data"]["attributes"]["gameModeStats"]["solo"]["kills"] / ($seasonData["data"]["attributes"]["gameModeStats"]["solo"]["roundsPlayed"] - $seasonData["data"]["attributes"]["gameModeStats"]["solo"]["wins"]), 2);
            }
            if ($seasonData["data"]["attributes"]["gameModeStats"]["duo"]["roundsPlayed"] === 0) {
                $pubgPlayerInfo["duoKd"] = "0";
            } else {
                $pubgPlayerInfo["duoKd"] = round($seasonData["data"]["attributes"]["gameModeStats"]["duo"]["kills"] / ($seasonData["data"]["attributes"]["gameModeStats"]["duo"]["roundsPlayed"] - $seasonData["data"]["attributes"]["gameModeStats"]["duo"]["wins"]), 2);
            }
            if ($seasonData["data"]["attributes"]["gameModeStats"]["squad"]["roundsPlayed"] === 0) {
                $pubgPlayerInfo["sqKd"] = "0";
            } else {
                $pubgPlayerInfo["sqKd"] = round($seasonData["data"]["attributes"]["gameModeStats"]["squad"]["kills"] / ($seasonData["data"]["attributes"]["gameModeStats"]["squad"]["roundsPlayed"] - $seasonData["data"]["attributes"]["gameModeStats"]["squad"]["wins"]), 2);
            }
        } else {
            // my page
            $pubgPlayerInfo = [];
            for ($i = 0; $i < $len; $i++) {
                $pubgPlayerInfo[$i]["username"] = $name[$i];
                $pubgPlayerInfo[$i]["accountId"] = $accountId[$i];
                $pubgPlayerInfo[$i]["seasonId"] = $seasonId;
                $pubgPlayerInfo[$i]["soloRank"] = $this->rankConversion($seasonData["data"][$i]["attributes"]["gameModeStats"]["solo"]["rankPointsTitle"]);
                $pubgPlayerInfo[$i]["rankPoints"] = (int)$seasonData["data"][$i]["attributes"]["gameModeStats"]["solo"]["rankPoints"];
            }
        }
        // Http Response Code
        $pubgPlayerInfo["httpCode"] = $seasonData["httpCode"];

        return $pubgPlayerInfo;
    }

    private function getPubgData($mode, $url)
    {
        // apiKey
        $apiKey = "apikey";

        // curlセッション初期化
        $curl = curl_init();

        // curlヘッダー情報
        $curlHeader = array("Authorization: Bearer " . $apiKey, "Accept: application/vnd.api+json");

        // curl設定情報
        $options = array(CURLOPT_URL => $url, CURLOPT_RETURNTRANSFER => true, CURLOPT_CUSTOMREQUEST => 'GET', CURLOPT_HTTPHEADER => $curlHeader);

        // curl実行
        curl_setopt_array($curl, $options);
        $results = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        curl_close($curl);

        // レスポンスコード確認
        if ($httpCode >= 400) {
            return ["httpCode" => $httpCode, "result" => false,];
        }

        $array = json_decode($results, true);

        switch ($mode) {
            case 0:
                // アカウントID取得
                $accountInfo["accountId"] = $array["data"][0]["id"];
                $accountInfo["httpCode"] = $httpCode;
                $accountInfo["result"] = true;

                return $accountInfo;

            case 1:
                // 最新のシーズンID取得
                $seasonInfo["seasonId"] = [];
                foreach ($array["data"] as $data) {
                    if ($data["attributes"]["isCurrentSeason"] === true) {
                        $seasonInfo["seasonId"] = $data['id'];
                    }
                }
                $seasonInfo["httpCode"] = $httpCode;
                $seasonInfo["result"] = true;

                return $seasonInfo;

            case 2:
                // プレイヤーステータス情報取得
                $array["httpCode"] = $httpCode;
                $array["result"] = true;

                return $array;
        }
    }

    private function rankConversion($rankPointsTitle)
    {
        switch ($rankPointsTitle) {
            case 0:
                return "UnRanked";
            case "1-5":
                return "Beginner 5";
            case "1-4":
                return "Beginner 4";
            case "1-3":
                return "Beginner 3";
            case "1-2":
                return "Beginner 2";
            case "1-1":
                return "Beginner 1";
            case "2-5":
                return "Novice 5";
            case "2-4":
                return "Novice 4";
            case "2-3":
                return "Novice 3";
            case "2-2":
                return "Novice 2";
            case "2-1":
                return "Novice 1";
            case "3-5":
                return "Experienced 5";
            case "3-4":
                return "Experienced 4";
            case "3-3":
                return "Experienced 3";
            case "3-2":
                return "Experienced 2";
            case "3-1":
                return "Experienced 1";
            case "4-5":
                return "Skilled 5";
            case "4-4":
                return "Skilled 4";
            case "4-3":
                return "Skilled 3";
            case "4-2":
                return "Skilled 2";
            case "4-1":
                return "Skilled 1";
            case "5-5":
                return "Specialist 5";
            case "5-4":
                return "Specialist 4";
            case "5-3":
                return "Specialist 3";
            case "5-2":
                return "Specialist 2";
            case "5-1":
                return "Specialist 1";
            case "6-0":
                return "Survivor";
            case "7-0":
                return "Lone Survivor";
        }
    }
}

class getLolInfo extends AppController
{
    public function getLolInfo($name, $summonerId, $type): array
    {
        $lolPlayerInfo = ["summonerId" => 0, "accountId" => 0, "soloRank" => "no data", "leaguePoints" => "no data", "winRate" => 0, "wins" => 0, "losses" => 0, "httpCode" => "", "result" => "true",];

        if (empty($name)) {
            return $lolPlayerInfo;
        }

        $apiKey = 'apikey'; // ApiKey

        if ($type === 0) {
            // getSummonerId and getLevel
            $url = 'https://jp1.api.riotgames.com/lol/summoner/v4/summoners/by-name/' . $name . '?api_key=' . $apiKey;
            $summonerInfo = $this->getLolData(0, $url);
            if ($summonerInfo["result"] === false) {
                $lolPlayerInfo["result"] = false;
                $lolPlayerInfo["httpCode"] = $summonerInfo["httpCode"];

                return $lolPlayerInfo;
            }

            $lolPlayerInfo["summonerId"] = $summonerInfo["summonerId"];
            $lolPlayerInfo["accountId"] = $summonerInfo["accountId"];
        } else {
            $summonerInfo["summonerId"] = $summonerId;
        }

        // getLolData
        $url = 'https://jp1.api.riotgames.com/lol/league/v4/entries/by-summoner/' . $summonerInfo["summonerId"] . '?api_key=' . $apiKey;
        $lolData = $this->getLolData(1, $url);
        if ($lolData["result"] === false) {
            $lolPlayerInfo["result"] = false;
            $lolPlayerInfo["httpCode"] = $lolData["httpCode"];

            return $lolPlayerInfo;
        }

        // solo
        $lolPlayerInfo["soloRank"] = strtolower($lolData[0]["tier"]);
        $lolPlayerInfo["soloRank"] = ucfirst($lolPlayerInfo["soloRank"]);
        if (($lolData[0]["tier"] != "CHALLENGER") and ($lolData[0]["tier"] != "GRANDMASTER") and ($lolData[0]["tier"] != "MASTER")) {
            $num = $this->rankConversion($lolData[0]["rank"]);
            $lolPlayerInfo["soloRank"] = $lolPlayerInfo["soloRank"] . " " . $num;
        }
        // league point
        $lolPlayerInfo["leaguePoints"] = $lolData[0]["leaguePoints"];

        // WinRate
        if ($lolData[0]["wins"] != 0) {
            $all = $lolData[0]["wins"] + $lolData[0]["losses"];
            $lolPlayerInfo["winRate"] = round($lolData[0]["wins"] / $all, 2) * 100;
        } else {
            $lolPlayerInfo["winRate"] = 0;
        }
        // wins
        $lolPlayerInfo["wins"] = $lolData[0]["wins"];
        // losses
        $lolPlayerInfo["losses"] = $lolData[0]["losses"];

        // Http Response Code
        $lolPlayerInfo["httpCode"] = $lolData["httpCode"];

        return $lolPlayerInfo;
    }

    private function getLolData($mode, $url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        curl_close($curl);

        if ($httpCode >= 400) {
            $curlResult = ["httpCode" => $httpCode, "result" => false,];
            return $curlResult;
        }

        $lolData = json_decode($result, true);

        switch ($mode) {
            case 0:
                // サモナーIDを取り出す
                $summonerInfo["summonerId"] = $lolData["id"];
                $summonerInfo["accountId"] = $lolData["accountId"];
                $summonerInfo["summonerLevel"] = $lolData["summonerLevel"];
                $summonerInfo["httpCode"] = $httpCode;
                $summonerInfo["result"] = true;

                return $summonerInfo;

            case 1:
                // ステータス情報を取り出す
                $lolData["httpCode"] = $httpCode;
                $lolData["result"] = true;

                return $lolData;
        }
    }

    private function rankConversion($rank)
    {
        switch ($rank) {
            case 'I':
                return 1;
            case 'II':
                return 2;
            case 'III':
                return 3;
            case 'IV':
                return 4;
            case 'V':
                return 5;
        }
    }
}
