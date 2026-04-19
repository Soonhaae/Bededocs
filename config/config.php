<?php

return // permettra de faire un require de ça depuis ma class Mysql, qui va récupérer en retour un tableau directement
// c'est pratique quand on crée une classe qui va recevoir des données, elle recevra tout
// c'est pratique, on peut faire un require de ce fichier dans la classe Mysql
// et ça va nous retourner un tableau associatif avec toutes les données de config, et on pourra les utiliser pour se connecter à la BDD
[
    'db_name' => 'bededocs',
    'db_user' => 'root',
    'db_password' => '',
    'db_port' => 3306,
    'db_host' => 'localhost', // ou alors mettre 127.0.0.1, c'est pareil
    'db_charset' => 'utf8mb4',
    'db_collation' => 'utf8mb4_unicode_ci',    // c'est pour les collations, c'est pas forcément nécessaire, mais c'est mieux de le mettre
];                                              // c'est mieux que utf8mb4_general_ci, qui est plus vieux et moins précis
