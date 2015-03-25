<?php namespace App\Controllers;

use App\Db;
use PDO;
use Core\BaseClasses\View;

class AuthController {

    public $errors;

    // indexAction method will be triggered at
    // both example.com/users/index AND example.com/users
    // this convention is true for all controllers. So if you want
    // an action for example "example.com/posts" just name is "indexAction".

    public function indexAction() {


        if(isset($_SESSION["errors"])){
            $errors = $_SESSION["errors"];
            return View::render('auth/login', compact("errors"));
        }
        return View::render('auth/login');
    }

    public function registerAction() {

        $db = Db::get();
        if($this->validator($_POST["email"], $_POST["password"], $_POST["rep_password"], $_POST["first_name"], $_POST["last_name"])) {
            $hash = password_hash($_POST["password"], PASSWORD_BCRYPT, array("cost" => 8));
            $registerStm = $db->prepare('INSERT INTO users (email, password, first_name, last_name) VALUES (:email, :password, :first_name, :last_name)');
            $registerStm->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
            $registerStm->bindParam(':password', $hash, PDO::PARAM_STR);
            $registerStm->bindParam(':first_name', $_POST['first_name'], PDO::PARAM_STR);
            $registerStm->bindParam(':last_name', $_POST['last_name'], PDO::PARAM_STR);

            $registerStm->execute();
            $this->loginAction();

        }
        else{

            $_SESSION['errors'] = $this->errors;
            header("location:../auth");
        }
    }

    public function loginAction() {

        $db = Db::get();

        $loginStm = $db->prepare('SELECT * FROM users WHERE email = :email');
        $loginStm->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        //$loginStm->bindParam(':password', $_POST['password'], PDO::PARAM_STR);
        $loginStm->execute();

        if($loginStm->rowCount() == 1){
            $row = $loginStm->fetch(PDO::FETCH_ASSOC);
            if(password_verify($_POST['password'], $row['password'])){
            $_SESSION["auth"] = "loggedIn";
            $_SESSION["user"] = $row;
            header("location:../");
            }
        }
    }

    public function logoutAction(){

        session_unset();
        session_destroy();

        header("location:../auth");
    }

    private function validator ($email, $pass1, $pass2, $first_name, $last_name){
        if( strlen($pass1) < 6  ) {
            $this->errors = " Your password has to be at least six characters long";
            return false;
        }
        if(empty($first_name) && empty($last_name) && empty($email) && empty($pass1)){
            $this->errors = "You have to fill in all fields";
            return false;
        }
        if(($pass1 != $pass2)) {
            $this->errors = "Your password need to match";
            return false;
        }
        if(! filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->errors = "Invalid email";
            return false;
        }
        else{
            return true;
        }
    }
}