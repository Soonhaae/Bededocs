<?php


namespace App\Repository;

use App\Entity\Book;    // le \ est séparateur de namespace
                        // on met ce dont on a besoin dans "use"
                        // donc ici on a besoin de book pour pouvoir créer une instance de book et alimenter ses propriétés avec les données de la BDD
use App\Db\Mysql;       // on a aussi besoin de Mysql pour pouvoir faire des requêtes à la BDD (via PDO)

class BookRepository {

public function findOneById(int $id) {

        // récupérer instance de MySQL :
        $mysql = Mysql::getInstance();  // on utilise la méthode statique getInstance() pour récupérer l'instance de Mysql (singleton)
                                        // on récupère un nouve objet $mysql qui est une instance de Mysql (pour après utiliser ses méthodes pour faire requêtes à la BDD)
                                        // rappel : appel à static (ici méthode getInstance()) faite par les 2x2points
        // var_dump($mysql); // à faire après avoir créé l'instance pour vérifier qu'on a bien une instance de Mysql

        // maintenant qu'on a mysql qui fonctionne (on a vérifié juste avant avec var_dump), on va vouloir récupérer pdo pour faire des requêtes à la BDD
        
        $pdo = $mysql->getPDO();    // on utilise la méthode getPdo() de l'instance de Mysql pour récupérer l'objet PDO (qui est stocké dans la propriété $pdo de Mysql)
                                    // on récupère un nouvel objet $pdo qui est une instance de PDO (pour faire des requêtes à la BDD)
                                    // on pourra faire toute nos requêtes avec notre objet pdo (qui est connecté à la BDD grâce à Mysql)
                                    // pdo ne va être instancé qu'une seule fois par cette classe getPDO(), et il sera partagé entre toutes les instances de Mysql (grâce au pattern singleton), donc on peut faire des requêtes à la BDD depuis n'importe quelle instance de Mysql, et on aura toujours le même objet PDO qui est utilisé pour faire les requêtes à la BDD
        // on fait singleton avec pdo car créer 1 connexion à la BDD c'est coûteux, donc on peut pas ouvrir 10 connexions dans 1 même page : on préfère 1 seule connexion partagée par tous
        // en fait : getPDO() = "si la connexion existe, je te la donne, sinon je la crée"

        // du coup ici si je fais $pdo->ça doit me proposer des trucs (sinon c'est que j'ai oublié :self dans getInstance() dans Mysql.php)
        // et/ou alors 'ai oublié :\PDO dans getPDO() (aussi dans Mysql.php)

        $query = $pdo->prepare('SELECT * FROM book WHERE id = :id');    // on prépare une requête ("requête préparée", c'est mieux niveau sécurité)
                                                                        // requête SQL pour récupérer un livre de la table book de la BDD en fonction de son id
                                                                        // le :id est un paramètre nommé (un placeholder), ce n'est pas encore une vraie valeur
                                                                        // c'est juste un emplacement vide dans la requête
                                                                        // :id sera remplacé par la vraie valeur de $id dans le execute() ci-dessous)

        $query->bindValue(':id', $id, \PDO::PARAM_INT); // on bind la valeur de $id au paramètre :id de la requête SQL, en précisant que c'est un entier (PDO::PARAM_INT)
                                                        // si j'écris \PDO, alors PDO=la classe PDO elle-même (PDO=classe native de PHP)
                                                        // le \ devant PDO = pour dire que c'est la classe PDO qui est dans le namespace global (et pas une classe PDO qui serait dans un namespace de mon appli)
                                                        // PARAM_INT = une constante de cette classe PDO, qui indique que c'est un entier (type de la donnée = un entier)
                                                        // bindValue() = méthode de PDO qui permet de lier une valeur à un param
                                                        // donc attention, dans un bindValue(), $pdo n'est pas censé être null (même si par défaut il est null) !
                                                        // si je fais $query = $pdo->prepare(...), ça veut dire que $pdo est déjà une instance de PDO, donc il est déjà connecté à la BDD, donc je peux faire un bindValue() sans problème (car $pdo n'est pas null)
                                                        // si je fais un bindValue() avant d'avoir fait $pdo->prepare(), alors $pdo est encore null (car il n'est pas encore instancié), donc ça va me faire une erreur (car je ne peux pas faire un bindValue() sur un objet null)
                                                        // du coup, l'ordre des opérations est important : d'abord je prépare la requête (pour que $pdo soit instancié), puis je fais le bindValue() (pour lier la valeur de $id au paramètre :id de la requête SQL)    
        $query->execute();    // on exécute la requête       
        // $query->setFetchMode(\PDO::FETCH_ASSOC);    // on définit le mode de récupération des données (ici, on veut un tableau associatif)
                                                    // logique POO reposirory+entity = je récupère un tableu , je le transforme en objet métier (entité/book)
                                                    // et je retourne cet objet (et pas un tableau)
        $book = $query->fetch(); // on récupère le résultat de la requête
        
        // \PDO::PARAM_INT = je vais diretcement à la source (la classe)
        // $pdo::PARAM_INT = je passe par un objet our accéder à uen constante de classe (ça marche aussi, mais c'est moins direct que de passer par la classe elle-même)
        
        
        
        // avant de faire tout ce qu'il y a au début de cette méthode (ele début qui est en rapport avec Mysql.php), on peut pour test faire en dur :
        // simuler un appel à  la BDD (tableau associatif ci-dessous qui simule une ligne de la table book de la BDD)
        // $book = ['id' => 1, 'title' => 'titre test', 'description' => 'description test'];


        $bookEntity = new Book();
        $bookEntity->setId($book['id']); // attention à ce point, si pas de setter pour l'id (si auto-incrémenté en BDD)
        $bookEntity->setTitle($book['title']);
        $bookEntity->setDescription($book['description']);
        // tout ça = hydrater une entité manuellement (= on alimente les propriétés de l'entité avec les données de la BDD)

        return $bookEntity;

    }
}

/*
autre manière de faire :

foreach($book as $key => $value) {
    // $key = 'id' / 'title' / 'description'
    // $value = 1 / 'titre test' / 'description test'
    // setter : setId / setTitle / setDescription

    $setter = 'set'.ucfirst($key); // ucfirst : met la 1ère lettre en majuscule
    if (method_exists($bookEntity, $setter)) { // vérifier que le setter existe dans la classe Book avant de l'appeler
        $bookEntity->$setter($value); // appel dynamique du setter (ex : $bookEntity->setTitle('titre test'))
    }   

but : alimenter automatiquement notre livre, sans devoir faire les set de tout

*/


/* on pourrait aussi faire :

    $query->execute(['id' => $id]);    // on exécute la requête en passant l'id en paramètre (pour remplacer :id dans la requête SQL)       

*/