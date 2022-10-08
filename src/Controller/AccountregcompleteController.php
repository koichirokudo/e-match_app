<?php

namespace App\Controller;

class AccountregcompleteController extends AppController //Startのみしか使われない
{
    function index() {
        if(empty($this->request->getCookie("user"))){
            $this->redirect("/");
        }
    }
}
