<?php

namespace App\Controller;

use App\Repository\BookRepository; // dans chaque controller, on appelle le repository qui nous intéresse

class BookController extends Controller {
      
    public function route(): void {     // ici ça vient de route Controller
        
        try {
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'show':
                        $this->show();
                        break;
                    case 'list':
                        $this->list();
                        break;
                    case 'edit':
                        $this->edit();
                        break;
                    case 'delete':
                        $this->delete();
                        break;
                    default:
                        throw new \Exception("Cette action n'existe pas : ".$_GET['action']);
                        break;
                }
            } else {
                throw new \Exception("Aucune action détectée");
            }

        } catch(\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    
        
    }

    protected function show() {
        try {
            if (isset($_GET['id'])) {
                
                $id = (int)$_GET['id'];

                // charger le livre par un appel au repository (class Book ne gère pas le lien avec la BDD)
                $bookRepository = new BookRepository();
                $book = $bookRepository->findOneById($id); // on récupère un objet Book (et pas un tableau associatif comme dans le repository)

                $this->render('book/show', [ // je passe à la Vue des données de ce tableau : elles s'afficheront  si elles sont exploitées dans show.php
                    'book' => $book,    //  virgule finale pas oblig mais recommandée
                ]);
            } else {
                throw new \Exception("L'id est manquant en paramètre");
            }
        } catch(\Exception $e) {
            $this->render('errors/default', [
                'error' => $e->getMessage()
            ]);
        }
    
    
        
    }                  
    protected function home() {
        $this->render('page/home', [
            'test3' => 'def',
            'test4' => 'def2', 
        ]);
    }
}

