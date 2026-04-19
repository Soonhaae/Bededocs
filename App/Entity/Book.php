<?php

namespace App\Entity;

class Book { // comme on va faire des getter et des setter, on ne va pas mettre en public (juste en protected)
    protected ?int $id = null;  // on précise qu'il peut être null en rajoutant ? à ?int, parce que sinon null est interdit (int=que les entiers)
                                // or si ? est pas là, ça provoquerait une erreur, puisqu'au début, à la création d'un nvx livre, celui-ci n'a pas encore d'id
                                // "null" à la fin = valeur par défaut est null
                                    // il sera auto-incrémenté dans la BDD / il se mettra tt seul en BDD. 
                                    // mais qd le livre sera chargé de la BDD, on aura besoin de son id (d'où le $id)
    protected string $title;
    protected string $description;

    
                                    // rappel : sans getter/setter : mauvaise pratique (on ne fait pas $book->id = 5; par exemple / encapsulation pas bonne)
                                    // avec getter/setter, "je contrôle l'accès à la propriété" (="encapsulation")
                                        // exemple : écrire/modifier la valeur : $book->setId(5); (et je peux aussi faire $book->setId(null);)
                                        // exemple : lire la valeur   : $book->getId();

    protected string $image; // on peut aussi ajouter une image à notre livre, pour ça il suffit de rajouter une propriété $image, et de faire les getter/setter correspondants (et de l'ajouter dans la BDD aussi)
    protected int $type_id; // on peut aussi ajouter un type à notre livre, pour ça il suffit de rajouter une propriété $type, et de faire les getter/setter correspondants (et de l'ajouter dans la BDD aussi)
    protected int $author_id; // on peut aussi ajouter un auteur à notre livre, pour ça il suffit de rajouter une propriété $author, et de faire les getter/setter correspondants (et de l'ajouter dans la BDD aussi)



    /*
si j'ai besoin de vérifier, je peux entrer des données en dur dans chaque propriété, pour tester les getter/setter
(ex :
protected ?int $id = null;
protected string $title = '';
protected string $description = '';
protected string $image = '';
protected int $type_id = 0;
protected int $author_id = 0;
)
*/









// Ci-dessous, les getter/setter de chaque propriété (id, title, description, image, type_id, author_id) :

    /**
     * Get the value of id
     */
    public function getId(): ?int // il renvoie la valeur de $id (int ou null)
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(?int $id): self   // il modifie la valeur de $id
    {                                       // mais en réalité il vaudrait mieux ne pas laisser ce setter pour éviter de pouvoir le modifier car :
                                            // id est une clé primaire, auto-incrémentée (=générée automatiquement) par la BDD
                                            // risque : pbms cohérence des données si on peut le modifier
                                            // (ex : changer l'id d'un livre : est-ce que ls autres tables qui font réf à ce livre vont aussi ê MàJ ?)
                                            // ça n'a pas de sens de pouvoir le modifier (1 livre doit garder le même id tt le tps) 
                                            // peut ê utile par contre pour tests, donc juste le commenter si on l'enlève
        $this->id = $id;

        return $this;
    }
    
    
    /**
     * Get the value of title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of image
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * Set the value of image
     */
    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of type_id
     */
    public function getTypeId(): int
    {
        return $this->type_id;
    }

    /**
     * Set the value of type_id
     */
    public function setTypeId(int $type_id): self
    {
        $this->type_id = $type_id;

        return $this;
    }

    /**
     * Get the value of author_id
     */
    public function getAuthorId(): int
    {
        return $this->author_id;
    }

    /**
     * Set the value of author_id
     */
    public function setAuthorId(int $author_id): self
    {
        $this->author_id = $author_id;

        return $this;
    }
}