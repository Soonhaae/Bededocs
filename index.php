<?php
 
    define('_ROOTPATH_', __DIR__);  


    spl_autoload_register(); // se charge de faire tous les require de classes

    use App\Controller\Controller;

    $controller = new Controller();
    $controller->route();
    
    

