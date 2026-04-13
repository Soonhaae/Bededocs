<?php

namespace App\Controller;

class PageController extends Controller {
      
    public function route(): void {     // ici ça vient de route Controller
        if (isset($_GET['action'])) {   // là on va voir quelle action est passée dans les params de l'url (donc en GET)
            switch ($_GET['action']) {  // selon l'action, on va appeler une méthode de notre PageController (voir ci-dessous)
                case 'about':       // ex ici, si action=about, 
                    $this->about(); // alors appeler la méthode about() définie plus bas
                    break;
                case 'home':        // idem ici ci action=home, appeler méthode home()
                    // var_dump('On appelle la méthode home'); // avant d'appeler la méthode, faire un var_dump pour vérifier que ça fonctionne bien (=affichagee qui le prouve)
                    $this->home();
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

        $params = [         // 1re manière de faire : tableau de données qu'on veut passer à la Vue. variable intermédiaire de tableau (tableau intermédiaire)
                            // tableau associatif clé => valeur (la fonction extract dans Controller va transformer les test/test2 en variables)
            'test' => 'abc', // une variable, une valeur
            'test2' => 'abc2',  // on pourrait très bien avoir aussi 'test2' => $monObjet, 
            ];
    
    
        $this->render('page/about', $params); // la fonction about appelle render, et render se charge de charger la page about
    }

    protected function home() {
                                    //1er paramètre : ma page à charger, 2e paramètre : le tableau associatif de paramètres
        $this->render('page/home', [ // donc ici, 2e manière de faire : je passe le tableau directement en 2e paramètre de ma fonction (idem mais mieux que manière de faire ci-dessus)
            'test3' => 'def',
            'test4' => 'def2', 
            ]);
    }

// NB : le tableau n'est pas nommé, c'est quand render reçoit cette structure (dans Controller.php)
// qu'il devient $params dans "protected function render(string $path, array $params = []):void"

}

