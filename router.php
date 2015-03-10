<?php
require_once 'vendor/autoload.php';

use Core\BaseClasses\Route;

/* -- Define ROOT_PATH for more consistent uri handling -- */
Route::defineRootPath();
var_dump(ROOT_PATH);
/* ------------------------------------------------------- */

/* -- Enables dynamic routing -- */
Route::dynamic();
/* ----------------------------- */





