<?php
namespace Bank\App\Services;
use Bank\App\DB\FileBase;
use Bank\App\DB\MariaBase;
use Bank\App\App;

class Accounts{

    private function __construct(){
        // never gets constructed
    }

    public static function getAllAccounts($sort = 'surname', $asc = true){
        $lens = [];
        if($_SESSION['use_db'] == "both"){
            $temp1 = (new FileBase('acc'))->showAll();
            $accs1 = array_map(function ($obj) {
                $obj->database = 'FILE';
                return $obj;
            }, $temp1);
            $lens[] = count($accs1);
            $temp2 = (new MariaBase('accounts'))->showAll();
            $temp22 = array_map(function ($item) {
                return (object)$item;
            }, $temp2);
            $accs2 = array_map(function ($obj) {
                $obj->database = 'MARIA';
                return $obj;
            }, $temp22);
            $lens[] = count($accs2);
            $_SESSION['lens'] = $lens;
            $accs = array_merge($accs1, $accs2);
        }
        else if($_SESSION['use_db'] == "Maria"){
            $temp = (new MariaBase('accounts'))->showAll();
            $temp2 = array_map(function ($item) {
                return (object)$item;
            }, $temp);
            $accs = array_map(function ($obj) {
                $obj->database = 'MARIA';
                return $obj;
            }, $temp2);
            $lens[] = count($accs);
            $_SESSION['lens'] = $lens;

        }
        else{
            $temp = (new FileBase('acc'))->showAll();
            $accs = array_map(function ($obj) {
                $obj->database = 'FILE';
                return $obj;
            }, $temp);
            $lens[] = count($accs);
            $_SESSION['lens'] = $lens;
        }
        if($asc){
            usort($accs, fn($a,$b) => $a->$sort <=> $b->$sort );
        }
        else{
            usort($accs, fn($a,$b) => $b->$sort <=> $a->$sort );
        }
        
        $notDeletedAccs = array_filter($accs, fn($el) => $el->deleted == 0);
        $notDeletedAccs = array_values($notDeletedAccs);
        return $notDeletedAccs;
    }

    public static function getAccount($id, $db){
        $count = null;
        if($db == "FILE"){
            $count = count((new FileBase('acc'))->showAll());
        }
        else{
            $count = count((new MariaBase('accounts'))->showAll());
        }
        if($id > $count || $id <= 0){
            return false;
        }
        $acc = null;
        if($db == "FILE"){
            $acc = (new FileBase('acc'))->show($id);
        }
        else{
            $acc = (new MariaBase('accounts'))->show($id);
            $acc = (object)$acc;
        }
        if($acc->deleted == 1){
            return false;
        }
        return $acc;
    }

    public static function updateAccount($action, $id, $db, $ammount){
        $writer = null;
        $acc = null;
        if($db == "FILE"){
            $writer = (new FileBase('acc'));
            $acc = $writer->show($id);
        }
        else{
            $writer = (new MariaBase('accounts'));
            $acc = $writer->show($id);
            $acc = (object)$acc;
        }
        $balance = $acc->balance;
        if($ammount <= 0){
            Message::set("You cannot add or take away negative ammounts." , 'error');
            return false;
        }
        if($action == 'minus' && $ammount > $balance){
            Message::set("You cannot take more than there is. Please check your numbers!" , 'error');
            return false;
        }       
        if($action == 'plus'){
            $acc->balance += $ammount;
        }
        else{
            $acc->balance -= $ammount;
        }
        $writer->update($id, $acc);
        return true;
    }

    public static function destroyAccount($id, $db){
        if($db == "FILE"){
            $writer = (new FileBase('acc'));
            $acc = $writer->show($id);
        }
        else{
            $writer = (new MariaBase('accounts'));
            $acc = $writer->show($id);
            $acc = (object)$acc;
        }
        if($acc->balance > 0){
            return false;
        }
        else{
            $acc->deleted = 1;
            $writer->update($id, $acc);
            return true;
        }
    }
    //id, name, surname, id_code, iban, db
    public static function createAccount($request){
        $writer  = null;
        $writer1 = null;
        $writer2 = null;
        $db = $request['db'];
        file_put_contents(ROOT . 'data/debug.json', json_encode($db));

        if($db == "File"){
            $writer = (new FileBase('acc'));
        }
        else if($db == "Maria"){
            $writer = (new MariaBase('accounts'));
        }
        else{
            $writer1 = (new FileBase('acc'));
            $writer2 = (new MariaBase('accounts'));
        }
        
        $idValidation = AccountInfo::validateID($request['id_code']);
        if($idValidation && strlen($request['name']) > 3 && strlen($request['surname']) > 3){
            if($db == "both"){
                $newAcc1 = (object)[
                    'id'     => (int)$request['id1'] + 1,
                    'name'   => $request['name'],
                    'surname'=> $request['surname'],
                    'id_code'=> $request['id_code'],
                    'iban'   => $request['iban'],
                    'balance'=> 0,
                    'deleted' => 0
                ];
                $newAcc2 = (object)[
                    'id'     => (int)$request['id2'] + 1,
                    'name'   => $request['name'],
                    'surname'=> $request['surname'],
                    'id_code'=> $request['id_code'],
                    'iban'   => $request['iban'],
                    'balance'=> 0,
                    'deleted' => 0
                ];
                $writer1->create($newAcc1);
                $writer2->create($newAcc2);
            }
            else{
                $newAcc = (object)[
                    'id'     => (int)$request['id1'] + 1,
                    'name'   => $request['name'],
                    'surname'=> $request['surname'],
                    'id_code'=> $request['id_code'],
                    'iban'   => $request['iban'],
                    'balance'=> 0,
                    'deleted' => 0
                ];
                $writer->create($newAcc);
            }
            Message::set("Account #$id was successfully created. ", 'success');
            return true;
        }
        if(strlen($request['name']) <= 3 && strlen($request['surname']) <= 3){
            Message::set("Your account name and surname can't be of 3 or less characters length.", 'error');
        }
        else if(strlen($request['name']) <= 3 ){
            Message::set("Your account name can't be of 3 or less characters length.", 'error');
        }
        else if(strlen($request['surname']) <= 3){
            Message::set("Your account surname can't be of 3 or less characters length.", 'error');
        }
        return false;
    }
}