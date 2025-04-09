<?php

namespace Quantik2024;

// Inclure les fichiers requis
require_once 'PieceQuantik.php';
require_once 'ArrayPieceQuantik.php';
require_once 'PlateauQuantik.php';
require_once 'Player.php';
require_once 'AbstractGame.php';
require_once 'QuantikGame.php';
require_once 'AbstractUIGenerator.php';
require_once 'QuantikUIGenerator.php';

// Démarrer la session
session_start();

$game = null;

// Vérifier si un jeu est en cours dans la session
if (isset($_SESSION['game'])) {
    // Vérifier si l'utilisateur a demandé à recommencer le jeu
    if (isset($_POST['recommencer'])) {
        // Initialiser un nouveau jeu QuantikGame
        $game = new QuantikGame();
    } else {
        // Désérialiser l'objet QuantikGame depuis la session
        $game = unserialize($_SESSION['game']);
        // Vérifier si l'objet désérialisé est bien une instance de QuantikGame
        if (!$game instanceof QuantikGame) {
            // Si ce n'est pas le cas, initialiser un nouveau jeu QuantikGame
            $game = new QuantikGame();
        }
    }
} else {
    // Si aucun jeu n'est trouvé dans la session, initialiser un nouveau jeu QuantikGame
    $game = new QuantikGame();
}


// Générer la page en fonction de la sélection de pièces
$page = QuantikUIGenerator::getPageSelectionPiece($game, $game->getCurrentPlayer());

// Vérifier si l'utilisateur a soumis une action pour poser une pièce sur le plateau
if (isset($_POST['poserPlateau'])) {
    $positions = explode("-", $_POST['poserPlateau']);
    $x = (int)$positions[0];
    $y = (int)$positions[1];

    // Vérifier si la case est vide
    if ($game->getPlateau()->getPiece($x, $y) === PieceQuantik::initVoid()) {
        $position = unserialize($_SESSION['positionPiece']);


        // Récupérer la pièce en fonction du joueur actuel
        if ($game->getCurrentPlayer() == PieceQuantik::WHITE) {
            $piece = $game->getPiecesBlanches()->getPieceQuantik($position);
            $game->getPiecesBlanches()->removePieceQuantik($position);
        } else {
            $piece = $game->getPiecesNoires()->getPieceQuantik($position);
            $game->getPiecesNoires()->removePieceQuantik($position);
        }

        // Placer la pièce sur le plateau
        $game->getPlateau()->setPiece($x, $y, $piece);

        // Vérifier s'il y a une victoire
        $actions = new ActionQuantik($game->getPlateau());
        if ($actions->isColWin($y) || $actions->isRowWin($x) || $actions->isCornerWin($game->getPlateau()->getCornerFromCoord($x, $y))) {
            $_SESSION['game'] = serialize($game);
            header("Location: victoire.php");
            exit();
        } else {
            // Passer au joueur suivant
            $game->switchPlayer();
        }

        // Mettre à jour la page avec la sélection des pièces du joueur suivant
        $page = QuantikUIGenerator::getPageSelectionPiece($game, $game->getCurrentPlayer());
    } else {
        // Si la case n'est pas vide, afficher un message d'erreur
        $page = QuantikUIGenerator::getPageErreur("Position non autorisée !");
    }
}

// Sérialiser et enregistrer l'état du jeu dans la session
$_SESSION['game'] = serialize($game);

// Afficher la page générée
echo $page;
