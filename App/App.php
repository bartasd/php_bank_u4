<?php

namespace Bank\App;
use Bank\App\Controllers\AccountsController;
use Bank\App\Controllers\HomeController;
use Bank\App\Controllers\LoginController;
use Bank\App\Controllers\DataBaseController;
use Bank\App\Services\Auth;
use Bank\App\Services\Message;

class App{

    public static function run(){
        $server = $_SERVER['REQUEST_URI'];
        $url = explode('/', $server);
        array_shift($url);
        return self::router($url);
    }

    public static function router($url){
        $loginned = isset($_SESSION['login']) ? true : false;
        $method = $_SERVER['REQUEST_METHOD'];

        // UNLOGINED ROUTING
        if(!$loginned){
            if($method == 'POST' && count($url) == 1 && $url[0] == 'login'){
                return (new LoginController)->login($_POST);
            }
            return (new LoginController)->index();
        }
        // LOGINED ROUTING
        else{
            // HOME ROUTING
            if(count($url) == 1 ){
                if($method == 'GET' && ($url[0] == 'acc' || $url[0] == '')){
                    return (new HomeController)->accounts();
                }
                if($method == 'GET' && $url[0] == 'create'){
                    return (new HomeController)->add_account();
                }
                if($method == 'POST' && $url[0] == 'create'){
                    return (new AccountsController)->getCreated($_POST);
                }
                // DATABASE CHOOSE
                if($method == 'POST' && $url[0] == 'Acc'){
                    return (new DataBaseController)->useDB($_POST, "acc");
                }
                if($method == 'POST' && $url[0] == 'Create'){
                    return (new DataBaseController)->useDB($_POST, "create");
                }
                if($method == 'GET' && count($url) == 1 && $url[0] == 'logout'){
                    Message::set('You have successfully logged out!', 'success');
                    Auth::get()->logout();
                    return (new LoginController)->index();
                }
            }
            // SORTING
            if($method == 'GET' && count($url) == 3 && $url[0] == 'acc' && $url[1] == 'sort'){
                $SORTINGBY = strtolower($url[2]);
                $isItSame = $SORTINGBY == $url[2] ? true : false;
                $modeName = $isItSame ? "ascending" : "descending";
                Message::set("You have sorted a list of account by $SORTINGBY, in $modeName mode", 'success');
                $possibleSorts = ['id', 'name', 'surname', 'id_code', 'iban', 'balance', 'database'];
                if(in_array($SORTINGBY, $possibleSorts)){
                    return (new AccountsController)->getSorted($SORTINGBY, $isItSame);
                }
            }
            // EDITING ACCOUNTS
            if(count($url) == 4 && $url[0] == 'acc' && ($url[1] == 'plus' || $url[1] == 'minus') && ($url[3] == 'MARIA' || $url[3] == 'FILE')){
                // EDITING VIEW
                if($method == 'GET'){
                    $possibleToEdit = (new AccountsController)->getEdited($url[1], $url[2], $url[3]);
                    if($possibleToEdit){
                        return $possibleToEdit;
                    }
                }
                // EDITING ACTION
                if($method == 'POST'){
                    (new AccountsController)->getUpdated($url[1], $url[2], $url[3], $_POST['ammount']);
                }
            }
            // DELETING ACCOUNTS
            if(count($url) == 4 && $url[0] == 'acc' && $url[1] == 'delete' && ($url[3] == 'MARIA' || $url[3] == 'FILE')){
                // DELETING VIEW
                if($method == 'GET'){
                    $possibleToDelete = (new AccountsController)->getDeleted($url[2], $url[3]);
                    if($possibleToDelete){
                        return $possibleToDelete;
                    }
                }
                // DELETING ACTION
                if($method == 'POST'){
                    (new AccountsController)->getDestroyed($_POST['id'], $url[3]);
                }
            }


            return (new HomeController)->p404();
        }
    }

    public static function view($page, $data = [])
    {
        extract($data);
        $auth = Auth::get()->getStatus();
        ob_start();
        if($page != 'LoginView' && $page != '404View'){
            require ROOT . "views/_partials/_partialTop.php";
        }
        require ROOT . "views/$page.php";
        return ob_get_clean();  
    }

    public static function redirect($url){
        header('Location: '.URL.$url);
        return null;
    }

}