<?php namespace App\Controllers;

use App\Db;
use PDO;
use Core\BaseClasses\View;

class AuthController {


    // indexAction method will be triggered at
    // both example.com/users/index AND example.com/users
    // this convention is true for all controllers. So if you want
    // an action for example "example.com/posts" just name is "indexAction".

    public function indexAction() {

        return View::render('auth/login');
    }

    public function registerAction() {

        $db = Db::get();

        $registerStm = $db->prepare('INSERT INTO users (email, password, first_name, last_name) VALUES (:email, :password, :first_name, :last_name)');
        $registerStm->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        $registerStm->bindParam(':password', $_POST['password'], PDO::PARAM_STR);
        $registerStm->bindParam(':first_name', $_POST['first_name'], PDO::PARAM_STR);
        $registerStm->bindParam(':last_name', $_POST['last_name'], PDO::PARAM_STR);

        if($registerStm->execute()){

            $this->loginAction();
        }

    }

    public function loginAction() {

        $db = Db::get();

        $loginStm = $db->prepare('SELECT * FROM users WHERE email = :email AND password = :password');
        $loginStm->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        $loginStm->bindParam(':password', $_POST['password'], PDO::PARAM_STR);
        $loginStm->execute();

        if($loginStm->rowCount() == 1){
            session_start();
            $_SESSION["auth"] = "loggedIn";
            $_SESSION["user"] = $loginStm->fetchObject();
        }

        header("location:../");

    }

    public function logoutAction(){

        session_unset();
        session_destroy();

        header("location:../auth");
    }

}