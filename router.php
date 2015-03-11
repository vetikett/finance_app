<?php
require_once 'vendor/autoload.php';
use Core\BaseClasses\Route;

date_default_timezone_set ("Europe/Stockholm");

/* -- Define ROOT_PATH for more consistent uri handling -- */
Route::defineRootPath();
/* ------------------------------------------------------- */

/* -- Enables dynamic routing -- */
Route::dynamic();
/* ----------------------------- */





