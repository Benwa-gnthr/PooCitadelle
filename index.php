<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclusion des fichiers de classe (Encapsulation)
require_once 'Classe/Partie.php';
require_once 'Classe/Banque.php';
require_once 'Classe/Joueur.php';
require_once 'Classe/Pioche.php';
require_once 'Classe/Personnage.php';
require_once 'Classe/Quartier.php';

// Fonction pour afficher un message et lire l'entrée utilisateur (Encapsulation)
function prompt($message) {
    echo $message . ": ";
    return trim(fgets(STDIN));
}

// Fonction pour sauvegarder la partie (Encapsulation)
function savePartie($partie, $filename = 'partie.save') {
    file_put_contents($filename, serialize($partie));
}

// Fonction pour charger la partie (Encapsulation)
function loadPartie($filename = 'partie.save') {
    if (file_exists($filename)) {
        return unserialize(file_get_contents($filename));
    }
    return null;
}

if (!isset($argv[1])) {
    echo "Usage: php index.php [start]\n";
    exit(1);
}

$command = $argv[1];

if ($command === 'start') {
    // Création d'un objet Partie (Instanciation)
    $partie = new Partie();
    $nombreJoueurs = (int) prompt("Nombre de joueurs (2-8)");

    for ($i = 1; $i <= $nombreJoueurs; $i++) {
        $nom = prompt("Nom du joueur $i");
        // Création d'un objet Joueur (Instanciation)
        $joueur = new Joueur($nom);
        // Appel de la méthode ajouterJoueur (Encapsulation)
        $partie->ajouterJoueur($joueur);
    }

    // Appel de la méthode demarrerPartie (Encapsulation)
    $partie->demarrerPartie();
    echo "La partie a commencé!\n";

<<<<<<< HEAD
    // Sauvegarde de la partie (Encapsulation)
    savePartie($partie);
} elseif ($command === 'next_turn') {
    // Chargement de la partie (Encapsulation)
    $partie = loadPartie();
    if (!$partie) {
        echo "Aucune partie en cours. Veuillez démarrer une nouvelle partie.\n";
        exit(1);
    }

    // Appel de la méthode tourSuivant (Encapsulation)
    $partie->tourSuivant();
    echo "Tour suivant!\n";
=======
    // Exécution d'un seul tour
    $partie->tourSuivant();

    echo "Tour actuel: " . ($partie->getTourActuel()) . "\n";

    foreach ($partie->getJoueurs() as $joueur) {
        echo $joueur->getNom() . " a " . $joueur->getOr() . " pièces d'or.\n";
    }

    echo "La partie est terminée!\n";
>>>>>>> 5a5645bc4b61581ba44997a0a1ab220e6367b926

    // Sauvegarde de la partie (Encapsulation)
    savePartie($partie);
} else {
    echo "Commande inconnue: $command\n";
    exit(1);
}
<<<<<<< HEAD

if ($partie) {
    // Appel de la méthode getTourActuel (Encapsulation)
    echo "Tour actuel: " . ($partie->getTourActuel() + 1) . "\n";

    // Boucle sur les joueurs pour afficher leurs informations (Encapsulation)
    foreach ($partie->getJoueurs() as $joueur) {
        // Appel des méthodes getNom et getOr (Encapsulation)
        echo $joueur->getNom() . " a " . $joueur->getOr() . " pièces d'or.\n";
    }
}
=======
>>>>>>> 5a5645bc4b61581ba44997a0a1ab220e6367b926
?>
