<?php

namespace App\Controller;

class Accountregcontroller extends AppController //Startのみしか使われない
{
    function index()
    {
    }

    function err($msg)
    {
        $this->set('error', $msg);
    }

    function create()
    {
        // メールアドレス重複チェック
        $p = $this->request->getData();
        $table = $this->getTableLocator()->get("users"); // usersテーブルを使う宣言
        $mailCnt = $table->find()->where(['email' => $p["mail"]])->count();
        if (0 < $mailCnt) {
            $msg = $p["mail"] . "は既に登録されています。";
            $this->setAction('err', $msg);
            return;
        } else {
            $new = $table->newEntity(); // 新しいレコードを作る
            $new->email = $p["mail"];
            $new->pass = password_hash($p["pass"], PASSWORD_DEFAULT);
            $new->user_name = "未設定";
            $new->pf_img = "noimage.png"; // 初期画像
            $new->pubg_flg = 0;
            $new->lol_flg = 0;
            $new->game_values = 0;
            $new->tmt_flg = 0;
            $table->save($new); //セーブ
        }

        // クッキーの作成
        $this->response = $this->response->withCookie('user', [
            'value' => $p["mail"],
            'path' => '/',
            'httpOnly' => true,
            'secure' => false,
            'expire' => strtotime('+1 month') // クッキーの有効期限（1ヶ月)
        ]);

        $this->response = $this->response->withCookie('user_id', [
            'value' => $new->id,
            'path' => '/',
            'httpOnly' => true,
            'secure' => false,
            'expire' => strtotime('+1 month') // クッキーの有効期限（1ヶ月)
        ]);

        // 名前表示
        $table = $this->getTableLocator()->get("users"); // usersテーブルを使う宣言
        $query = $table->get($new->id);
        $this->set("username", $query->user_name);

        $this->redirect(["controller" => "Accountregcomplete", "action" => "index"]);
    }
}
