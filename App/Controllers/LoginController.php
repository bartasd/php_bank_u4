<?php
namespace Bank\App\Controllers;
use Bank\App\App;
use Bank\App\Services\Auth;

class LoginController{

    public function index(){
        return App::view('LoginView');
    }

    public function login($request){
        $user = $request['name'] ?? '';
        $pass = $request['pass'] ?? '';

        if(Auth::get()->tryLogin($user, $pass)){
            return App::redirect('acc');
        }
        return App::redirect('');
    }

}