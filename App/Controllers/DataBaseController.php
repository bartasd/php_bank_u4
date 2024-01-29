<?php
namespace Bank\App\Controllers;
use Bank\App\App;
use Bank\App\Services\Message;

class DataBaseController{
    public function useDB($request, $view)
    {
        if(count($request['db_use']) == 2){
            $_SESSION['use_db'] = 'both';
            Message::set("You choosed to work with both databases.", 'success');
        }
        else{
            $name = $request['db_use'][0];
            $_SESSION['use_db'] = $name;
            Message::set("You choosed to work with $name database.", 'success');
        }
        return App::redirect($view);
    }
}