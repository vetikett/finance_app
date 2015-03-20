<?php namespace App\Controllers;

use App\Db;
use PDO;
use Core\BaseClasses\View;

class StocksController {


    // indexAction method will be triggered at
    // both example.com/users/index AND example.com/users
    // this convention is true for all controllers. So if you want
    // an action for example "example.com/posts" just name is "indexAction".

    public function indexAction() {


        $db = Db::get();
        $showStm = $db->prepare('SELECT * FROM stocks JOIN users ON (users.id = stocks.user_id)WHERE user_id = 1');
        //$showStm->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);
        $showStm->execute();

        $stocks = $showStm->fetchObject();

        return View::render('stocks/index', compact('stocks'));
    }

    public function createAction() {
        return View::render('users/create');
    }

    public function buyAction() {
        $db = Db::get();
        $buyStm = $db->prepare('INSERT INTO stocks(user_id, name, cost, info, holding) VALUES (:user_id, :name, :cost, :info, :holding)');
        $buyStm->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);
        $buyStm->bindParam(':name', $_POST["name"], PDO::PARAM_STR);
        $buyStm->bindParam(':cost', $_POST["cost"], PDO::PARAM_INT);
        $buyStm->bindParam(':info', $_POST["info"], PDO::PARAM_STR);
        $buyStm->bindParam(':holding', $_POST["holding"], PDO::PARAM_INT);

        $buyStm->execute();

        return "Saves entity";
    }

    public function showAction($id) {
        $db = Db::get();
        $stm = $db->prepare('SELECT * FROM users
                           WHERE users.id = :id');
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();

        $user = $stm->fetchObject();

        return View::render('users/show', compact('user'));

    }


    public function editAction($id) {
        return "Renders form to update entity with id: ". $id;
    }

    public function updateAction($id) {
        return "Updates entity with id: ". $id;
    }

    public function deleteAction($id) {
        return "Deletes entity with id: ". $id;
    }

}