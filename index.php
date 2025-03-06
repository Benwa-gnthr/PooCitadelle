<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'Classe/Partie.php';
require 'Classe/Banque.php';
require 'Classe/Joueur.php';
require 'Classe/Pioche.php';
require 'Classe/Personnage.php';
require 'Classe/Quartier.php';

function prompt($message) {
    echo $message . ": ";
    return trim(fgets(STDIN));
}

if (!isset($argv[1])) {
    echo "Usage: php index.php [start|next_turn]\n";
    exit(1);
}

$command = $argv[1];

if ($command === 'start') {
    $_SESSION['partie'] = new Partie();
    $nombreJoueurs = (int) prompt("Nombre de joueurs (2-8)");

    for ($i = 1; $i <= $nombreJoueurs; $i++) {
        $nom = prompt("Nom du joueur $i");
        $joueur = new Joueur($nom);
        $_SESSION['partie']->ajouterJoueur($joueur);
    }

    $_SESSION['partie']->demarrerPartie();
    echo "La partie a commencé!\n";
} elseif ($command === 'next_turn') {
    if (!isset($_SESSION['partie'])) {
        echo "Aucune partie en cours. Veuillez démarrer une nouvelle partie.\n";
        exit(1);
    }

    $_SESSION['partie']->tourSuivant();
    echo "Tour suivant!\n";
} else {
    echo "Commande inconnue: $command\n";
    exit(1);
}

$partie = $_SESSION['partie'];
echo "Tour actuel: " . ($partie->tourActuel + 1) . "\n";

foreach ($partie->getJoueurs() as $joueur) {
    echo $joueur->getNom() . " a " . $joueur->getOr() . " pièces d'or.\n";
}
?>