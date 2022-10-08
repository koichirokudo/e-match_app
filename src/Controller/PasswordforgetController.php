<?php

namespace App\Controller;
use Cake\Mailer\Email;

class PasswordforgetController extends AppController
{
    function confirm() {
        $p = $this->request->getQuery("ck");
        $table = $this->getTableLocator()->get("users"); // usersテーブルを使う宣言
        $forget = $table->find()->where("passfor='".$p."'")->first();
        if($forget == null){
            $this->redirect(["action" => "index"]);
            return;
        }
        $forget->passfor = "";
        $table->save($forget);
        $this->set("id", $forget);
    }
    function display() {

    }
    function request() {
        $p = $this->request->getData();
        $m = md5(strval(rand(0,10000)));
        $table = $this->getTableLocator()->get("users"); // usersテーブルを使う宣言
        $forget = $table->find()->where("email='".$p["mail"]."'")->first();
        if($forget == null){
            $this->redirect(["action" => "display"]);
            return;
        }
        $forget->passfor = $m;
        $table->save($forget);
        $email = new Email();
        $email->setTo($p["mail"])
        ->setFrom("passfor@yodare.me","E-match")
        ->setEmailFormat("text")
        ->setSubject("パスワード再設定")
        ->setViewVars(["f"=>$m])
        ->viewBuilder()
        ->setTemplate("send")
        ->setLayout("default");
        $email->send();
    }


    function confirm2() {
        $p = $this->request->getData();
        $table = $this->getTableLocator()->get("users"); // usersテーブルを使う宣言
        $forget = $table->find()->where("email='".$p["mail"]."'")->first();
        $forget->password = password_hash($p["pass"], PASSWORD_DEFAULT);
        $table->save($forget);
        $this->redirect(["controller" => "login", "action" => "index"]);
    }
}
