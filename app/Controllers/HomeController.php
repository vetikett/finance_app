<?php namespace App\Controllers;


use Core\BaseClasses\View;

class HomeController {

    public function home() {

        // http://dev.markitondemand.com/Api/v2/lookup/json/?input=apple
        return View::render('home');
    }

}