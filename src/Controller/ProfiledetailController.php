<?php

namespace App\Controller;

class ProfiledetailController extends AppController //Startのみしか使われない
{
    function index()
    {
        $r = $this->request->getQuery("?id");
        $table = $this->getTableLocator()->get("users");
        $user = $table->find()->where("id=" . $r)->first();
        $this->set("user", $user);

        // リクエスト状態の読み込み
        $data = $table->find()
            ->select(["id" => "requeststats.id", "user_id" => "requeststats.user_id", "rq_user_id" => "requeststats.rq_user_id", "username" => "users.user_name", "rq_name" => "users2.user_name", "user_stat" => "requeststats.rq_state"])
            ->where("users.id=requeststats.user_id and users2.id=requeststats.rq_user_id")
            ->from("requeststats, users, (select * from users) as users2")->all();
        $this->set("rq", $data);

        $requested = 0;
        foreach($data as $d) {
            if($d->user_id == $this->request->getCookie("user_id") && $r == $d->rq_user_id){
                $requested = $d->user_stat;
                break;
            } else if($d->rq_user_id == $this->request->getCookie("user_id") && $r == $d->user_id){
                $requested = $d->user_stat;
                break;
            }
        }

        $this->set("rq_state", $requested);

        $type = 1;

        if ($user->pubg_flg === 1) {
            // pubg api
            $pubgName = $user->pubg_name;
            $accountId = $user->pubg_id;
            $seasonId = $user->pubg_seasonid;

            $getPubgInfo = new getPubgInfo();
            $pubgPlayerInfo = $getPubgInfo->getPlayerInfo($pubgName, $accountId, $seasonId, $type);
            if ($pubgPlayerInfo["result"] === false) {
                $this->Flash->error("PUBGの情報取得に失敗しました(Response:" . $pubgPlayerInfo['httpCode'] . ")");
                $this->set('pubgPlayerInfo', $pubgPlayerInfo);
            } else {
                $this->set('pubgPlayerInfo', $pubgPlayerInfo);
            }
        }

        if ($user->lol_flg === 1) {
            // lol api
            $lolName = $user->lol_name;
            $summonerId = $user->lol_summonerid;

            $getLolInfo = new getLolInfo();
            $lolPlayerInfo = $getLolInfo->getLolInfo($lolName, $summonerId, $type);
            if ($lolPlayerInfo["result"] === false) {
                $this->Flash->error("LOLの情報取得に失敗しました(Response:" . $lolPlayerInfo['httpCode'] . ")");
                $this->set('lolPlayerInfo', $lolPlayerInfo);
            } else {
                $this->set('lolPlayerInfo', $lolPlayerInfo);
            }
        }

        if ($user->game_values === 0) {
            $values = "楽しんでゲームをしたい！";
        } else if ($user->game_values === 1) {
            $values = "本気でゲームをしたい！";
        }
        if ($user->tmt_flg === 0) {
            $tmt = "大会に出場したくない！";
        } else if ($user->tmt_flg === 1) {
            $tmt = "大会に出場したい！";
        }
        $this->set("values", $values);
        $this->set("tmt", $tmt);
        $this->set("pubgflg", $user->pubg_flg);
        $this->set("lolflg", $user->lol_flg);
    }
    // リクエスト処理
    function rq()
    {
        $p = $this->request->getData();
        $table = $this->getTableLocator()->get("requeststats");
        $new = $table->newEntity();
        $new->user_id = $p["from"];
        $new->rq_user_id = $p["to"];
        $new->rq_username = "test";
        $new->is_matched = 0;
        $new->rq_state = 1;
        date_default_timezone_set("Asia/Tokyo");
        $new->rq_date = date("Y/m/d H:i:s");
        $table->save($new); //セーブ
        $this->redirect(["controller" => "profiledetail", "action" => "index", "id" => $p["to"]]);
    }
}
