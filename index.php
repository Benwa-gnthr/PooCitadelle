<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Jeu Citadelles</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: auto; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Jeu Citadelles</h1>
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['start_game'])) {
                // Initialiser une nouvelle partie
                $_SESSION['partie'] = new Partie();
                $nombreJoueurs = $_POST['nombreJoueurs'];

                for ($i = 1; $i <= $nombreJoueurs; $i++) {
                    $nom = $_POST['joueur' . $i];
                    $joueur = new Joueur($nom);
                    $_SESSION['partie']->ajouterJoueur($joueur);
                }

                $_SESSION['partie']->demarrerPartie();
                header("Location: index.php");
                exit();
            }

            if (isset($_POST['next_turn'])) {
                // Passer au tour suivant
                $_SESSION['partie']->tourSuivant();
                header("Location: index.php");
                exit();
            }
        }

        if (!isset($_SESSION['partie'])) {
            // Afficher le formulaire pour démarrer une nouvelle partie
        ?>
            <form method="post" action="index.php">
                <label for="nombreJoueurs">Nombre de joueurs (2-8):</label>
                <input type="number" id="nombreJoueurs" name="nombreJoueurs" min="2" max="8" required><br><br>

                <div id="joueurInputs">
                    <!-- Les champs pour les noms des joueurs seront ajoutés ici par JavaScript -->
                </div>

                <button type="button" onclick="generatePlayerFields()">Générer les champs des joueurs</button>
                <button type="submit" name="start_game">Commencer la partie</button>
            </form>

            <script>
                function generatePlayerFields() {
                    const nombreJoueurs = document.getElementById('nombreJoueurs').value;
                    const joueurInputs = document.getElementById('joueurInputs');
                    joueurInputs.innerHTML = '';
                    for (let i = 1; i <= nombreJoueurs; i++) {
                        const label = document.createElement('label');
                        label.innerText = `Nom du joueur ${i} :`;
                        const input = document.createElement('input');
                        input.type = 'text';
                        input.name = `joueur${i}`;
                        input.required = true;
                        joueurInputs.appendChild(label);
                        joueurInputs.appendChild(input);
                        joueurInputs.appendChild(document.createElement('br'));
                    }
                }
            </script>
        <?php
        } else {
            // Afficher l'état actuel de la partie
            $partie = $_SESSION['partie'];
            echo "<h2>Partie en cours</h2>";
            echo "<p>Tour actuel: " . ($partie->tourActuel + 1) . "</p>";

            foreach ($partie->getJoueurs() as $joueur) {
                echo "<p>" . $joueur->getNom() . " a " . $joueur->getOr() . " pièces d'or.</p>";
            }

            echo '<form method="post" action="index.php">';
            echo '<button type="submit" name="next_turn">Tour suivant</button>';
            echo '</form>';
        }
        ?>
    </div>
</body>
</html>
