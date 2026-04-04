<?php

class Product
{
    protected string $name;
    protected string $description;
    protected float $price;


    public function getPRice()

    public function setPrice()
    

}


$product1 = new Product();

// Autre exemple



class Voiture
{
    protected string $marque;
    protected float $vitesse_max;
    protected int $nombre_roues;
}

class Bateau
{   
    protected string $marque;
    protected float $vitesse_max;
    protected int $nombre_cabines;
}

// choses communes aux 2 classes, donc on va faire une classe plus générale, pour reggrouper ce qui est commun aux 2 classes.

class Véhicule
{
    protected string $marque; // les enfants (= Voiture et Bateau) y auront accès, car c'est en protected donc c'est ok pour l'héritage
    protected float $vitesse_max; // si je passe en "private", cette propriété ne sera pas accessible aux 2 autres classe enfants (= extends): pas d'héritage
}

class Voiture extends Véhicule { // extends = récupère de la classe parent // mais on pourrait faire encore des extends de la classe Véhicule, pour des voitures plus spécifiques par exemple. // si on décide que c'est le dernier, alors mettre "final" au début, et le passer en "private"
    protected int $nombre_roues;
}

class Bateau extends Véhicule {
    protected int $nombre_cabines;
}

// si j'avais mis en "public", on y aurait accès aussi en dehors de la classe ! donc attention
// le mieux c'est de mettre en protected.

// on hérite des propriétés + des méthodes, donc so on génère des getter et des setter pour la classe V2hicule, les enfants vont y avoir accès.

// l'hériage est hiérarchique, pas d'héritage multiple en PHP


/// héritage vertical
// des interfaces (comme un guide de ce qu'o ndoit faire = c'est une place qui est vide = va juste définir des méthodes obligatires à définir), on peut en implémenter plusieurs.
// exemple : définir une interface Véhicule, et l'interface V2hicule va avoir "accélérer", "freiner", etc.
// donc on va obliger Véhicule à IMPLEMENTER l'interface, donc la classe va devoir faire ces méthodes.



interface IVehicule {
    
}