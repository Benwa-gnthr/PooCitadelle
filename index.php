<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'Classe/Partie.php';
require_once 'Classe/Banque.php';
require_once 'Classe/Joueur.php';
require_once 'Classe/Pioche.php';
require_once 'Classe/Personnage.php';
require_once 'Classe/Quartier.php';

function prompt($message) {
    echo $message . ": ";
    return trim(fgets(STDIN));
}

function savePartie($partie, $filename = 'partie.save') {
    file_put_contents($filename, serialize($partie));
}

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
    $partie = new Partie();
    $nombreJoueurs = (int) prompt("Nombre de joueurs (2-8)");

    for ($i = 1; $i <= $nombreJoueurs; $i++) {
        $nom = prompt("Nom du joueur $i");
        $joueur = new Joueur($nom);
        $partie->ajouterJoueur($joueur);
    }

    $partie->demarrerPartie();
    echo "La partie a commencé!\n";

    // Exécution d'un seul tour
    $partie->tourSuivant();

    echo "Tour actuel: " . ($partie->getTourActuel()) . "\n";

    foreach ($partie->getJoueurs() as $joueur) {
        echo $joueur->getNom() . " a " . $joueur->getOr() . " pièces d'or.\n";
    }

    echo "La partie est terminée!\n";

    savePartie($partie);
} else {
    echo "Commande inconnue: $command\n";
    exit(1);
}
?>
