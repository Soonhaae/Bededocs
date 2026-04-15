<?php


namespace App\Repository;

use App\Entity\Book; // le \ est séparateur de namespace

class BookRepository {

public function findOneById(int $id) {

    // simuler un appel BDD (tableau associatif qui simule une ligne de la table book de la BDD)
        $book = ['id' => 1, 'title' => 'titre test', 'description' => 'description test'];

        $bookEntity = new Book();
        $bookEntity->setId($book['id']); // attention à ce point, si pas de setter pour l'id (si auto-incrémenté en BDD)
        $bookEntity->setTitle($book['title']);
        $bookEntity->setDescription($book['description']);


        return $bookEntity;

    }
}
