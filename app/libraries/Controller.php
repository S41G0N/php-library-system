<?php
    //Loads the model and the view
    class Controller {
        public function model($model) {
            //Requires model ('User.php') file
            require_once '../app/models/' . $model . '.php';
            //Instantiates the model
            return new $model();
        }

        //Loads the view (checks for the file)
        public function view($view, $data = []) {
            if (file_exists('../app/views/' . $view . '.php')) {
                require_once '../app/views/' . $view . '.php';
            } else {
                die("View does not exist.");
            }
        }
    }
