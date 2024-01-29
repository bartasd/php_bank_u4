<?php
namespace Bank\App\Controllers;
use Bank\App\App;


class HomeController
{
    public function accounts()
    {
        return App::view('AccountsView');
    }
    public function add_account()
    {
        return App::view('CreateAccountView');
    }
    public function p404()
    {
        return App::view('404View');
    }


}
