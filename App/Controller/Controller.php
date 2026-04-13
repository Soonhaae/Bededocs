<?php

namespace App\Controller; // pas besoin de faire de require ou de use : c'est grâce au namespace que $PageController est connu


class Controller {
    public function route():void {          // méthode route() appelée par new Controller dans index.php
        
        try {
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
                        // on génère une nouvelle exception avec la classe Exception, dans laquelle on va mettre notre message (), 
                        throw new \Exception("Le contrôleur n'existe pas");
                        break;
                }

            // gestion du comportement par défaut :
            } else {    // charger la page d'accueil s'il n'y a pas de controller du tout qui soit passé (rien ne se chargearit s'il n'y avait pas ce else)
                $pageController = new PageController();  // nouveau contoleur car nouveau cas de figure
                $pageController->home(); // au lieu d'appeler route(), on va appeler directement la page d'accueil
            }
            
            // donc si quelque chose ne va pas ci-dessus (dans le if/else), on met en place le catch, qui va gérer une Exception définie $e
        } catch (\Exception $e) {               
                                                // pour afficher notre erreur, on appelle notre méthode render, qui est faite pour ça (affichage)
            $this->render('errors/default', [   // en 1er paramètre : chemin du fichier (à partir de /templates (donc dossier/fichier))
                                                // (par exemple si on a passé un mauvais nom de controleur)
                                                // puis en 2e paramètre, lui passer le tableau
                'error' => $e->getMessage()     // 'error' c'est le nom de variable qui est appelée dans la Vue ($error) grâce à extract(), donc dans le template default.php on aura $error
                 //clé      //valeur            // $e->getMessage() est une méthode de la classe Exception
            ]);                                  // cette méthode retourne le message d'erreur que j'ai défini avec throw
                                                // $e, c'est l'objet Exception que j'ai récupéré dans le catch
                                                // donc $e->getMessage() va retourner "Le contrôleur n'existe pas"
        };                                      // et le message d'erreur = le contenu de la variable = la valeur dans le tableau
    }


    protected function render(string $path, array $params = []):void  // chemin + paramètres qu'on va vouloir passer à la Vue (lui passer des variables, etc)
                                                                        // méthode render dans le parent : on va pouvoir l'appeler dans tous les enfants Controllers
    {

        $filePath = _ROOTPATH_.'/templates/'.$path.'.php'; // je rends ma méthode dynamique,
                                                            // je vérifie que le template existe bien :
        //systèe de gestion d'erreur :
        try {
            if (!file_exists($filePath)) {                               // s'il n'y a pas le fichier (= que ça a retourné false), alors générer erreur
                throw new \Exception("Fichier non trouvé : ".$filePath); // généreration de l'exception/de l'erreur avec le nom du fichier non trouvé (comme ça on trouvera plus facilement quel code ne fonctionne pas)
            } else {                                                     // s'il y a le fichier, on veut faire le require de ce fichier
                extract($params); // extrait chaque ligne du TABLEAU, et crée des variables pour chacun (attention, extract prend en paramètre un TABLEAU !)
                require_once $filePath;
            }

        } catch(\Exception $e) {  // le $e est une convention pour exception, et le \ c'est pour charger une classe qui n'est pas dans le namespace
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }

    }
}

// ce dernier try:catch (dans fonction render) s'affiche sans header, sans footer,
// donc il vaut mieux utiliser la manière de faire dans le try/catch au-dessus (dans fonction route) qui a un template pour afficher un message proprement

// require_once _ROOTPATH_.'/templates/page/about.php';