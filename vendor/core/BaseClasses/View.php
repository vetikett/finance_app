<?php namespace Core\BaseClasses;

class View {

    static public function render($template, $data = NULL) {
        if ($data != null) {
            $paramName = array_keys($data)[0];

            $$paramName = $data[$paramName];
        }


        require_once 'resources/views/'. $template .".php";
    }
}