<?php
 
    define('_ROOTPATH_', __DIR__);  // __DIR__ est une constante magique qui contient le chemin absolu du dossier dans lequel se trouve le fichier index.php
                                    // donc __DIR__ ici c'est le dossier du fichier index.php
                                    // c'est la racine du projet

                                    // _ROOTPATH_ = le chemin vers le dossier où se trouve index.php

                                    // donc ici _ROOTPATH_ = C:\Users\clyri\Documents\Projets_web\Bededocs


    spl_autoload_register(); // se charge de faire tous les require de classes

    use App\Controller\Controller;  // sans ça, on aurait une erreur de classe non trouvée, parce que le fichier index.php est à la racine du projet
                                    // or la classe Controller est dans le dossier App/Controller (donc plus loin dans l'arborescence),
                                    // il faut donc dire dans index.php où se trouve classe Controller pour qu'elle puisse être chargée automatiquement (grâce à l'autoload)

    $controller = new Controller(); // création d'une instance de la classe Controller
                                    // on va pouvoir utiliser ses méthodes pour gérer les 1/ROUTES(controller=) et 2/les ACTIONS(action=) de notre app (via url -> GET)
    $controller->route(); // ici, on appelle la méthode route() de la classe Controller

    
    

