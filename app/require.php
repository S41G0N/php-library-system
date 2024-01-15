<?php
    //Require libraries from folder libraries
    // require_once 'libraries/Core.php';
    // require_once 'libraries/Controller.php';
    // require_once 'libraries/Database.php';
    // require_once 'libraries/Redirect.php';

    spl_autoload_register(function($class){ require_once APPROOT. '/libraries/' .$class. '.php'; });

    require_once 'helpers/session_helper.php';
    require_once 'helpers/Redirect.php';
    require_once 'config/config.php';

    //Instantiate core class
    $init = new Core();
