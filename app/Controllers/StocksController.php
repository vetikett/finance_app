<?php namespace App\Controllers;

use App\Db;
use PDO;
use Core\BaseClasses\View;

class StocksController {

    public $stocks = [];
    // indexAction method will be triggered at
    // both example.com/users/index AND example.com/users
    // this convention is true for all controllers. So if you want
    // an action for example "example.com/posts" just name is "indexAction".

    public function indexAction() {


        $db = Db::get();
        $showStm = $db->prepare('SELECT * FROM stocks JOIN users ON (users.id = stocks.user_id)WHERE user_id = 1');
        //$showStm->bindParam(':user_id', $_SESSION["user_id"], PDO::PARAM_INT);
        $showStm->execute();
        $stocks = $showStm->fetchAll(PDO::FETCH_OBJ);
        $stocks = $this->getStocksBySymbol($stocks);
        $data['stocks'] = $stocks;

        return View::render('stocks/index', compact('stocks'));
    }

    public function createAction() {
        return View::render('users/create');
    }

    public function buyAction() {

        $user_id = 1;
        $total = $_POST["cost"] * $_POST["quantity"];

        $db = Db::get();

        $stm = $db->prepare('SELECT * FROM stocks
                      WHERE symbol = :symbol AND user_id = :user_id');
        $stm->bindParam(':symbol', $_POST["symbol"], PDO::PARAM_STR);
        $stm->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stm->execute();
        $stmResult = $stm->fetchAll(PDO::FETCH_OBJ);
        if (count($stmResult) === 1) {

            $totalQuantity = $_POST["quantity"] + $stmResult[0]->quantity;
            $updateStm = $db->prepare('UPDATE stocks
                                       SET quantity = :quantity
                                       WHERE symbol = :symbol AND user_id = :user_id');
            $updateStm->bindParam(':quantity', $totalQuantity, PDO::PARAM_INT);
            $updateStm->bindParam(':symbol', $_POST["symbol"], PDO::PARAM_STR);
            $updateStm->bindParam(':user_id', $user_id, PDO::PARAM_INT);

            if ($updateStm->execute()) {
                $_SESSION['flash'] = 'You bought stocks for a total of $'.$total;
                header('Location: ../');
            }
        }else {
            $newQuantity = (int)$_POST["quantity"];
            $buyStm = $db->prepare('INSERT INTO stocks (user_id, symbol, quantity) VALUES (:user_id, :symbol, :quantity)');
            $buyStm->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $buyStm->bindParam(':symbol', $_POST["symbol"], PDO::PARAM_STR);
            $buyStm->bindParam(':quantity', $newQuantity, PDO::PARAM_INT);

            if ($buyStm->execute()) {
                $_SESSION['flash'] = 'You bought stocks for a total of $'.$total;
                header('Location: ../');
            }
        }

    }

    public function sellAction() {
        $user_id = 1;
        $total = $_POST["cost"] * $_POST["quantity"];

        $newQuantity = $_POST['total_quantity'] - $_POST["quantity"];
        $db = Db::get();
        if ($newQuantity <= 0) {
            $stm = $db->prepare('DELETE FROM stocks
                             WHERE symbol = :symbol AND user_id = :user_id');
            $stm->bindParam(':symbol',$_POST["symbol"], PDO::PARAM_STR);
            $stm->bindParam(':user_id',$user_id, PDO::PARAM_INT);
            if ($stm->execute()) {
                $_SESSION['flash'] = 'You sold stocks for a total of $'.$total;
                header('Location: ../stocks');
            }
        }else{
            $stm = $db->prepare('UPDATE stocks
                             SET quantity = :quantity
                             WHERE symbol = :symbol AND user_id = :user_id');
            $stm->bindParam(':quantity',$newQuantity, PDO::PARAM_INT);
            $stm->bindParam(':symbol',$_POST["symbol"], PDO::PARAM_STR);
            $stm->bindParam(':user_id',$user_id, PDO::PARAM_INT);
            if ($stm->execute()) {
                $_SESSION['flash'] = 'You sold stocks for a total of $'.$total;
                header('Location: ../stocks');
            }
        }

        

        $walletStm = $db->prepare('UPDATE users
                                   SET wallet');




    }

    public function watchAction() {

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

    private function getStocksBySymbol($stocks) {
        foreach( $stocks as $stock ) {
            if ( isset($stock->symbol) ) {
                $stock->Symbol = $stock->symbol;
                unset($stock->symbol);
            }

            $requestUrlForDetails = 'http://dev.markitondemand.com/Api/v2/Quote/json/?symbol='.$stock->Symbol;

            $stockDetails = json_decode(@file_get_contents($requestUrlForDetails));

            $stockDetails->Quantity = $stock->quantity;
            array_unshift($this->stocks, $stockDetails);


        }

        return $this->stocks;

    }

}