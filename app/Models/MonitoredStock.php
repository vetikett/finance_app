<?php namespace App\Models;


use App\Db;

class MonitoredStock {

    public function all() {
        $db = Db::get();
        $stm = $db->prepare('SELECT symbol FROM monitored_stocks');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_OBJ);
    }
}