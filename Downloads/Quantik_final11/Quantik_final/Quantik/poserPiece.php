<?php

use Quantik2024\QuantikUIGenerator;

require_once 'PieceQuantik.php';
require_once 'ArrayPieceQuantik.php';
require_once 'PlateauQuantik.php';
require_once 'Player.php';
require_once 'AbstractGame.php';
require_once 'QuantikGame.php';
require_once 'AbstractUIGenerator.php';
require_once 'QuantikUIGenerator.php';

session_start();
$game = '';
$page = '';
$position = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['game'])) {
        $game = unserialize($_SESSION['game']);
        if (isset($_POST['position_piece'])) {
            $position = $_POST['position_piece'];
            $page = QuantikUIGenerator::getPagePosePiece($game,$game->currentPlayer,$position);
        }else{
            $page = QuantikUIGenerator::getPageErreur("Pas de pièce selectionnée");
        }
    }else{
        $page = QuantikUIGenerator::getPageErreur("Pas de session existante");
    }
}
$_SESSION['positionPiece'] = serialize($position);
$_SESSION['game'] = serialize($game);

echo $page;


