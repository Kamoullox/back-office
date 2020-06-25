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

// chargement de l'extension Twig_Extension_Debug
$twig->addExtension(new \Twig\Extension\DebugExtension());

$articles = require __DIR__.'/articles-data.php';

$formData = [
    'name' => '',
    'description' => '',
    'price' => 0,
    'quantity' => 0,
];

// le tableau contenant la liste des erreurs
$errors = [];
// le tableau contenant les messages d'erreur
$messages = [];


if ($_POST) {
    
    //--Sauvegarde des champs du formulaire--
    if (isset($_POST['name'])) {
        $formData['name'] = $_POST['name'];
    }
    if (isset($_POST['description'])) {
        $formData['description'] = $_POST['description'];
    }
    if (isset($_POST['price'])) {
        $formData['price'] = $_POST['price'];
    }
    if (isset($_POST['quantity'])) {
        $formData['quantity'] = $_POST['quantity'];
    }
    //---------------------------------------


    // validation des données du champ name
    if (!isset($_POST['name']) || empty($_POST['name'])) {
        $errors['name'] = true;
        $messages['name'] = "merci de renseigner le nom de l'article";
    } elseif (strlen($_POST['name']) < 2 || strlen($_POST['name']) > 100) {
        $errors['form'] = true;
        $messages['form'] = 'Le champ nom doit être compris entre 2 et 100 caractères';
    } 

    // validation des données du champ description
    if (isset($_POST['description'])) {
        if(strpos($_POST['description'], '<') || strpos($_POST['description'], '>') || $_POST['description'][0] === '<' || $_POST['description'][0] === '>')
        {
            $errors['description'] = true;
            $messages['description'] = "la description contient un caractère interdit < ou >";
        }
    }

    // validation des données du champ price
    if (!isset($_POST['price']) || empty($_POST['price'])) {
        $errors['price'] = true;
        $messages['price'] = "merci de renseigner le prix de l'article";
    } elseif ((!is_numeric($_POST['price']))) {
        // la variable ne contient pas de nombre entier
        $errors['price'] = true;
        $messages['price'] = "le prix doit être exprimé avec un nombre entier ou flottant";
    } elseif($_POST['price'] < 0) {
        $errors['price'] = true;
        $messages['price'] = "le prix ne peut pas être inférieurs à 0";
    }
    
    // validation des données du champ quantity
    if (!isset($_POST['quantity']) || empty($_POST['quantity'])) {
        $errors['quantity'] = true;
        $messages['quantity'] = "merci de renseigner le quantité de l'article";
    }elseif ((!is_int(0 + $_POST['quantity']))) {
        // la variable ne contient pas de nombre entier
        $errors['quantity'] = true;
        $messages['quantity'] = "la quantité doit être exprimé avec un nombre entier";
    } elseif($_POST['quantity'] < 0) {
        $errors['quantity'] = true;
        $messages['quantity'] = "la quantité ne peut pas être inférieurs à 0";
    }

    

    // on vérifie s'il y a des erreurs
    if (!$errors) {
        // il n'y a pas d'erreurs

        // démarrage de la session
        session_start();

        // enregistrement de données dans la variable de session
        $_SESSION['name'] = $articles['name'];
        $_SESSION['description'] = $articles['description'];
        $_SESSION['price'] = $articles['price'];
        $_SESSION['quantity'] = $articles['quantity'];


        // redirection de l'utilisateur vers la page privée
        $url = 'article-twig.php';
        header("Location: {$url}", true, 302);
        exit();
    }
}


// affichage du rendu d'un template
echo $twig->render('article-new-twig.html.twig', [
    // transmission de données au template
    'formData' => $formData,
    'errors' => $errors,
    'messages' => $messages,
]);