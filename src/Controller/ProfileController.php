<?php

namespace App\Controller;

use Cake\Filesystem\File;

class ProfileController extends AppController
{
    function index()
    {
        if (empty($this->request->getCookie("user"))) {
            $this->redirect("/");
            return;
        }

        $table = $this->getTableLocator()->get("users"); // usersテーブルを使う宣言
        $user = $table->get($this->request->getCookie("user_id"));

        $type = 1;

        // pubg API取得
        if ($user->pubg_flg === 1) {
            $getPubgInfo = new getPubgInfo();
            $pubgPlayerInfo = $getPubgInfo->getPlayerInfo($user->pubg_name, $user->pubg_id, $user->pubg_seasonid, $type);

            if ($pubgPlayerInfo["result"] === false) {
                $this->Flash->error("PUBGの情報取得に失敗しました(Response:" . $pubgPlayerInfo['httpCode'] . ")");
                $this->set('pubgPlayerInfo', $pubgPlayerInfo);
            } else {
                $this->set('pubgPlayerInfo', $pubgPlayerInfo);
            }
        }

        // lol API取得
        if ($user->lol_flg === 1) {
            $getLolInfo = new getLolInfo();
            $lolPlayerInfo = $getLolInfo->getLolInfo($user->lol_name, $user->lol_summonerid, $type);

            if ($lolPlayerInfo["result"] === false) {
                $this->Flash->error("LOLの情報取得に失敗しました(Response:" . $lolPlayerInfo['httpCode'] . ")");
                $this->set('lolPlayerInfo', $lolPlayerInfo);
            } else {
                $this->set('lolPlayerInfo', $lolPlayerInfo);
            }
        }

        // プロフィール表示
        if ($user->game_values === 0) {
            $gameValues = '楽しんでゲームをしたい！';
        } else if ($user->game_values === 1) {
            $gameValues = "本気でゲームをしたい！";
        }

        if ($user->tmt_flg === 0) {
            $tmt = '大会に出場したくない！';
        } else if ($user->tmt_flg === 1) {
            $tmt = '大会に出場したい！';
        }

        $this->set('user', $user);
        $this->set('gameValues', $gameValues);
        $this->set('tmt', $tmt);
        $this->set("pubgflg", $user->pubg_flg);
        $this->set("lolflg", $user->lol_flg);
    }

    public function upload()
    {
        // アップロード前処理
        $p = $this->request->getData();
        $c = $this->request->getCookie("user");
        $c = $c . "_bg_" . $p["upload"]["name"];
        $path = "img/" . $c;

        // usersテーブルを使う宣言
        $table = $this->getTableLocator()->get("users");
        $data = $table->get($this->request->getCookie("user_id"));

        // アップロード処理
        if (move_uploaded_file($p["upload"]["tmp_name"], $path)) {
            //現在使用している画像を削除
            if ($c != $data->pf_head) {
                $file = new File(WWW_ROOT . "img/" . $data->pf_head);
                $file->delete();
            }
            // DBに登録
            $data->pf_head = $c;
            $table->save($data);
        } else {
            echo "失敗";
            return false;
        }
    }
}
