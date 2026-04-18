<?php

namespace App\Db;

class Mysql
{                               // on les définit ici parce qu'il va y en avoir besoin dans le constructeur
    private $db_name;           
    private $db_user;
    private $db_password;
    private $db_port;
    private $db_host;
    private $pdo = null;               // va contenir l'objet PDO, comme ça pas besoin de passer PDO en paramètre de fonction à chaque fois pour le récupérer
                                // juste besoin de récupérer une instance de cette classe Mysql                         
                                // c'est la variable $pdo qui va contenir l'instance de PDO
                                // donc on pourra faire des requêtes à la BDD grâce à l'objet PDO qui est stocké dans $pdo
                                
    private static $_instance = null;   // va contenir l'instance de la classe Mysql, pour le pattern singleton (=modèle de conception)
                                        // singleton : garantit qu'une seule instance de classe existe dans toute l'application (on crée l'objet 1 fois, et on réutilise tjrs le même objet)
                                        // static pour pouvoir l'appeler avant qu'il y ait l'objet de la classe Mysql, et pour pouvoir le partager entre toutes les instances de la classe Mysql (même si on en crée plusieurs, il n'y aura qu'une seule instance de Mysql qui sera créée, et elle sera partagée entre toutes les instances de la classe Mysql)
                                        // null par défaut, car pas d'instance de Mysql au départ, et on va la créer dans la méthode getInstance() si elle n'existe pas déjà

    private function __construct()  // le constructeur est private pour éviter que quelqu'un puisse faire un new Mysql() depuis l'extérieur de la classe
                                    // je ne peux pas faire une instance en dehors de la classe :
                                    // je veux que soit la classe qui va décider de faire une instance s'il y a besoin
                                    // et si pas besoin, elle va retourner l'instance qui existe déjà
                                    // on veut forcer à utiliser la méthode getInstance() pour créer une instance de Mysql
                                    // le constructeur va recevoir la configuration de la BDD, et va se connecter à la BDD
    
    {
        $config = require_once _ROOTPATH_.'/config/config.php'; // je récupère mon tableau avec toutes les config de la BDD, et je le stocke dans une variable $config
                                                                    // = je récupère tous mes paramètres de config, et je les stocke sur les propriétés de ma classe
        if (isset($config['db_name'])) {
            $this->db_name = $config['db_name'];
        }

        if (isset($config['db_user'])) {
            $this->db_user = $config['db_user'];
        }

        if (isset($config['db_password'])) {
            $this->db_password = $config['db_password'];
        }

        if (isset($config['db_port'])) {
            $this->db_port = $config['db_port'];
        }

        if (isset($config['db_host'])) {
            $this->db_host = $config['db_host'];
        }
    }

/* on aurait aussi pu écrier comme ça pour minimiser :
        if (isset)($config['db_name'], $config['db_user'], $config['db_password'], $config['db_port'], $config['db_host']) === false) {
            throw new \Exception('Missing database configuration parameters');
        }
*/
/* ou alors on aurait aussi pu écrire pour chaque ligne :
        if (isset($config['db_name']) === false) {
            throw new \Exception('Missing database name configuration parameter');
        }
        if (isset($config['db_user']) === false) {
            throw new \Exception('Missing database user configuration parameter');
        }
        if (isset($config['db_password']) === false) {
            throw new \Exception('Missing database password configuration parameter');
        }
        if (isset($config['db_port']) === false) {
            throw new \Exception('Missing database port configuration parameter');
        }
        if (isset($config['db_host']) === false) {
            throw new \Exception('Missing database host configuration parameter');
        }  
*/



// comment ça se passe pour $_instance ?
// on va faire une méthode getInstance(), qu'on va appeler pour récupérer une instance
// (par ex, dans le repository, j'ai besoin d'un instance de Mysql)
    
// on ne voudra pas créer d'objet Mysql donc on va l'appeler de manière STATIC (= cad appel qui se fait sans avoir créé d'instance)

    public static function getInstance():self    // méthode pour : soit donner une instance qui a déjà été faite, soit créer une nouvelle instance
    {
        
        if (is_null(self::$_instance)) {    // on teste si getInstance est null)
                                            // is_null() est une fonction qui teste si une variable est null
                                            // self::$_instance = la variable static $_instance de la classe Mysql (sa propore class : self)
                                            // donc si l'instance n'existe pas encore on doit créer une instance de Mysql (avec new Msql() :
        
            self::$_instance = new Mysql();     // on crée une instance de la classe Mysql, et on la stocke dans la variable static $_instance
                                                // comment stocker dans une propriété STATIC ? (donc dans $instance) ? -> avec SELF, qui fait ref à la classe en elle-même
                                                // en mettant les 2x2points, je peux accéder aux propriétés (et méthodes) qui sont static
        }
        return self::$_instance;            // si l'instance existe/une fois qu'elle existe, je la retourne (l'instance de la classe Mysql)
                                            // si on fait un 2e appel (un 2e getInstance() ailleurs, dans une autre classe, etc.) on va voir que pas null
                                            // donc on va juste retourner l'instance qui existe déjà

    }


        public function getPDO(): \PDO {        // rôle de cette méthode : faire un new de PDO et de le stocker dans $pdo
                                                // \PDO = passer le type de PDO
        if(is_null($this->pdo)) {   // si $pdo est déjà instancié, alors on retourne l'instance de PDO qui est stockée dans $pdo, sinon on crée une nouvelle instance de PDO et on la stocke dans $pdo pour la réutiliser ensuite
                                    // même mécanique que dessus : à ne faire qu'1x, puis réutiliser la même instance de PDO pour faire toutes les requêtes à la BDD (pour éviter d'ouvrir plusieurs connexions à la BDD, ce qui est coûteux en ressources)
        $this->pdo = new \PDO('mysql:dbname='.$this->db_name.';host='.$this->db_host.';port='.$this->db_port, $this->db_user, $this->db_password); // on crée une nouvelle instance de PDO avec les paramètres de connexion à la BDD (récupérés dans les propriétés de la classe Mysql)
        }
        
        // on pourrait faire $this->pdo = $pdo; ici si on ne l'avait pas fait au début de ci-dessus
        // dans ce cas on aurait commencé ci-dessus par $pdo = new \PDO(etc.)
        
        // on stocke l'instance de PDO dans la propriété $pdo de la classe Mysql pour pouvoir la réutiliser ensuite
        // je stocke donc mon new PDO dans pdo, et je le retourne :
        return $this->pdo;
    }

    /* sinon j'aurais pu faire aussi de cette manière :    
        if ($this->pdo === null) { // si la propriété $pdo de cette classe est null, alors on va créer une nouvelle connexion à la BDD, car pas de connexion existante
            try {
                $this->pdo = new \PDO("mysql:host={$this->db_host};port={$this->db_port};dbname={$this->db_name}", $this->db_user, $this->db_password); // on crée une nouvelle instance de PDO avec les paramètres de connexion à la BDD (récupérés dans les propriétés de la classe Mysql)
                $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); // on configure PDO pour qu'il lance des exceptions en cas d'erreur (pour pouvoir les gérer plus facilement)
            } catch (\PDOException $e) { // s'il y a une erreur lors de la connexion à la BDD, on attrape l'exception et on affiche un message d'erreur
                die('Database connection error: ' . $e->getMessage());
            }
        }
        return $this->pdo;
    }
    
    */    



}


// donc résumé : quand je fais un getInstance(), ça va créer un nouvel objet de cette classe (new Mysql()) et ça va le stocker dans $instance
// comme ça on a 1 instance et c'est tout

// mais si on le rappelle une 2e fois, il y aura déjà une instance, donc on va tester si ce n'est pas null
// but singleton : il n'y a qu'une seule instance de Mysql qui sera créée, peu importe combien de fois on va l'appeler :
// et elle sera partagée entre toutes les parties de l'application qui en ont besoin
// cette instance sera créée au moment où o va faire notre 1er getInstance()
// donc le 1er getInstance = null (par défaut $instance est null),
// et avec function getInstance on voit que si $instance est null, alors il faut créer $donc on crée une instance, et les suivants = pas null, on retourne l'instance qui existe déjà

/* ou alors on peut aussi faire :    
        if (self::$instance === null) {     // si l'instance n'existe pas encore (donc est null)
            self::$instance = new self();   // alors on crée une instance de la classe Mysql, et on la stocke dans la variable static $instance
        }
        return self::$instance; // idem au-dessus : si l'instance existe, on retourne l'instance de la classe Mysql
    }
*/ 

/*
    protected function connect()
    {
        $this->connection = new \PDO(
            "mysql:host={$this->config['host']};dbname={$this->config['dbname']}",
            $this->config['username'],
            $this->config['password']
        );
    }
}   

*/


// RAPPEL : il ne faut pas créer un nouvel objet à chaque fois que je l'appelle
// sinon je vais ouvrir plusieurs connexions à la BDD, ce qui est coûteux en ressources,
// dc il faut vérifier si $pdo est déjà instancié ou pas avant de faire le new PDO