<?php

namespace App\Controller; // pas besoin de faire de require ou de use : c'est grâce au namespace que $PageController est connu


class Controller {
    public function route():void {          // méthode route() appelée par new Controller dans index.php
        if (isset($_GET['controller'])) {   // je regarde si on a passé un nom de controller dans les paramètres de l'URL (donc en GET)
            switch ($_GET['controller']) {  // switch pour identifier quel controller je dois charger
                case 'page':  // donc si j'ai le controller page en paramètre d'url, je suis dans le case page -> charger contrôleur page
                    $pageController = new PageController(); // si case page, alors je faire faire un new PageController (je suis au même niveau que App\Controller)
                    $pageController->route(); // ensuite, l'action sera dans le controller page (donc voir PageController.php -> méthode route, voir quelle sera l'action)
                    break;
                case 'book':                // idem dessus, si case book, alors charger contrôleur book
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
                                                                        // méthode render dans le parent : on va pouvoir l'appeler dans tous les enfants Controllers
    {

        $filePath = _ROOTPATH_.'/templates/'.$path.'.php'; // je rends ma méthode dynamique
        
        try {
            if (!file_exists($filePath)) {                               // s'il n'y a pas le fichier (= que ça a retourné false), alors générer erreur
                throw new \Exception("Fichier non trouvé : ".$filePath); // gestion d'erreur : généreration de l'erreur avec le nom du fichier non trouvé (comme ça on trouvera plus facilement quel code ne fonctionne pas)
            } else {                                                     // par contre s'il y a le fichier, on veut faire le require
            extract($params); // extrait chaque ligne du TABLEAU, et crée des variables pour chacun (attention, extract prend en paramètre un TABLEAU !)
            require_once $filePath;
            }
        } catch(\Exception $e) {  // le $e est une convention pour exception, et le \ c'est pour charger une classe qui n'est pas dans le namespace
            echo $e->getMessage();  // méthode de la classe Exception
        }

    }

}


// require_once _ROOTPATH_.'/templates/page/about.php';