<?php namespace App;

use PDO;

class Db {

    static public function get() {
        return new PDO('mysql:host=db4free.net;dbname=wiebankapp;charset=utf8', 'wiebankapp', 'wiebankapp');
    }
}