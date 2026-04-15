<?php
require_once _ROOTPATH_.'/templates/header.php';

/** @var \App\Entity\Book $book */

// ci-dessus, annotation qui dit que $book est de type Book (utilisé par IDE pour code completion)
// détection d'erreurs, meilleure lisibilité du code, etc. (mais pas interprété par PHP)
// syntaxe PHPDoc, pas de lien avec les commentaires classiques (// ou /* */)
// d'abord le type, ensuite la cible de l'annotation (ici variable $book, mais ça peut être une classe, une méthode, etc.)
// donc on dit : "book est de type Book"
?>

<h1><?=$book->getTitle() ?></h1>
<p><?=$book->getDescription() ?></p>
<p><?=$book->getId() ?></p>


<?php require_once _ROOTPATH_.'/templates/footer.php'; ?>