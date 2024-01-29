<?php
error_reporting(E_ALL);ini_set('display_errors', '1');
session_start();

use Bank\App\App;
use Bank\App\Services\Auth;
use Bank\App\Services\Message;

require '../vendor/autoload.php';

define('ROOT', __DIR__.'/../');
define('URL', 'http://bank.meh:8080/');

Auth::get();

echo App::run();

