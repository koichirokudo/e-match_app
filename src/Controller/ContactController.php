<?php

namespace App\Controller;
use Cake\Mailer\Email;

class ContactController extends AppController
{
    function index() {
        if(empty($this->request->getCookie("user"))){
            $this->redirect("/");
        }
    }

    function send() {
        $p = $this->request->getData();
        $email = new Email();
        $email->setTo("closer0055@gmail.com")
        ->setFrom([$p['email']=>"問い合わせ"])
        ->setEmailFormat("text")
        ->setSubject("お問い合わせがありました")
        ->setViewVars(["form"=>$p])
        ->viewBuilder()
        ->setTemplate("send2")
        ->setLayout("default");
        $email->send();
        $this->redirect("/");
    }
}
