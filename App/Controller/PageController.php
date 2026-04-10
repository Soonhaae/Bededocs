<?php

namespace App\Controller;

class PageController extends Controller {
      
    public function route(): void {
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'about': // appeler la méthode about()
                    $this->about();
                    break;
                case 'home': // charger contrôleur home
                    var_dump('On appelle la méthode home');
                    break;
                default:
                    // Erreur
                break;
            }
        } else {
            // On charge la page d'accueil
        }
    }

    protected function about() {
    //     /* on pourrait récupérer les données en faisant appel au modèle, mais on n'a pas de données à récupérer,
    //     donc on va juste faire le rendu / l'affichage de la page */

    $this->render('page/about');
    }
}

