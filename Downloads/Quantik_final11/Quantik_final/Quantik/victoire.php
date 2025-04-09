<?php

namespace Quantik2024;

require_once 'PieceQuantik.php';
require_once 'ArrayPieceQuantik.php';
require_once 'PlateauQuantik.php';
require_once 'Player.php';
require_once 'AbstractGame.php';
require_once 'QuantikGame.php';
require_once 'AbstractUIGenerator.php';
require_once 'QuantikUIGenerator.php';

session_start();
// Assurez-vous que $_SESSION['game'] contient bien un objet QuantikGame avant de le désérialiser
if (isset($_SESSION['game'])) {
    $game = unserialize($_SESSION['game']);
    // Vérifiez si $game est bien une instance de QuantikGame
    if ($game instanceof QuantikGame) {
        // Utilisez $game pour générer la page de victoire
        echo QuantikUIGenerator::getPageVictoire($game, $game->getCurrentPlayer());
    } else {
        // Gérez le cas où $_SESSION['game'] ne contient pas un objet QuantikGame valide
        echo "Erreur: Session game invalide.";
    }
} else {
    // Gérez le cas où $_SESSION['game'] n'est pas défini
    echo "Erreur: Session game non définie.";
}