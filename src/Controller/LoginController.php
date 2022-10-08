<?php

namespace App\Controller;

class LoginController extends AppController //Startのみしか使われない
{
    function index()
    {
        $this->set("err", "");
    }
    function login()
    {
        $p = $this->request->getData();
        $table = $this->getTableLocator()->get("users"); // usersテーブルを使う宣言
        $result = $table->find()->where(["email" => $p["mail"]])->first();

        if ($result && password_verify($p["passwd"], $result->pass)) {
            // クッキーの作成
            $this->response = $this->response->withCookie('user', [
                'value' => $p["mail"],
                'path' => '/',
                'httpOnly' => true,
                'secure' => false,
                'expire' => strtotime('+1 month') // クッキーの有効期限（1ヶ月)
            ]);
            $this->response = $this->response->withCookie('user_id', [
                'value' => $result->id,
                'path' => '/',
                'httpOnly' => true,
                'secure' => false,
                'expire' => strtotime('+1 month') // クッキーの有効期限（1ヶ月)
            ]);

            $this->redirect(["controller" => "mypage", "action" => "index"]);
        } else {
            $this->set("err", "メールアドレスかパスワードが間違っています");
            $this->render("index"); // indexを呼び出す
        }
    }
    function logout()
    {
        $this->response = $this->response->withExpiredCookie("user"); // 有効期限にして自動的に消える
        $this->redirect(["controller" => "top", "action" => "index"]);
    }
}
