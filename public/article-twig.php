<?php

// activation du système d'autoloading de Composer
require __DIR__.'/../vendor/autoload.php';

// instanciation du chargeur de templates
$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/../templates');

// instanciation du moteur de template
$twig = new \Twig\Environment($loader, [
    // activation du mode debug
    'debug' => true,
    // activation du mode de variables strictes
    'strict_variables' => true,
]);

$articles = require __DIR__.'/articles-data.php';

// foreach ($articles as $article) {
//     echo $article['id'];
//     echo $article['name'];
//     echo $article['description'];
//     echo $article['price'];
//     echo $article['quantity'];   
// }


// affichage du rendu d'un template
echo $twig->render('article-twig.html.twig', [
    // transmission de données au template
    'articles' => $articles,
]);