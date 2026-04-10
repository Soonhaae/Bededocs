<?php

namespace App\Controller; // pas besoin de faire de require ou de use : c'est grâce au namespace que $PageController est connu


class Controller {
    public function route():void {
        if (isset($_GET['controller'])) {
            switch ($_GET['controller']) {
                case 'page': // charger contrôleur page
                    $pageController = new PageController(); // new PageController, je suis au même niveau que App\Controller
                    $pageController->route();
                    break;
                case 'book': // charger contrôleur book
                    var_dump('On charge BookController');
                    break;
                default:
                    // Erreur
                break;
            }
        } else {
            // On charge la page d'accueil
        }
    }

    protected function render(string $path, array $params = []):void  // chemin + paramètres qu'on va vouloir passer à la Vue (lui passer des variables, etc)
                                                                    
    {

        $filePath = _ROOTPATH_.'/templates/'.$path.'.php'; // je rends ma méthode dynamique
        
        try {
            if (!file_exists($filePath)) {  // s'il n'y a pas le fichier (= que ça a retourné false), alors générer erreur
                throw new \Exception("Fichier non trouvé : ".$filePath); // généreration de l'erreur avec le nom du fichier non trouvé
            } else {                        // s'il y a le fichier, on veur faire le require
            require_once $filePath;
            }
        } catch(\Exception $e) {  /// le $e est une convention pour exception
            echo $e->getMessage();
        }

    }

}


// require_once _ROOTPATH_.'/templates/page/about.php';