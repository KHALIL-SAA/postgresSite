<?php

namespace Quantik2024;

require_once 'AbstractGame.php';

class QuantikGame extends AbstractGame{
    public PlateauQuantik $plateau;
    public ArrayPieceQuantik $piecesBlanches;
    public ArrayPieceQuantik $piecesNoires;
    public array $couleurPlayers;

    public function __construct() {
        $this->piecesBlanches = ArrayPieceQuantik::initPiecesBlanches();
        $this->piecesNoires = ArrayPieceQuantik::initPiecesNoires();

        $this->plateau = new PlateauQuantik();

        $this->gameID = rand(1,150);
        $joueurNoir = new Player(0,"player 1");
        $joueurBlanc = new Player(1,"player 2");
        $this->players = array();
        $this->couleurPlayers = array();

        $this->players[0]=$joueurBlanc;
        $this->players[1]=$joueurNoir;

        $this->couleurPlayers[0]=PieceQuantik::WHITE;
        $this->couleurPlayers[1]=PieceQuantik::BLACK;

        $this->currentPlayer = $this->couleurPlayers[0];
        $this->gameStatus = "choixPiece";
    }
    public function getCurrentPlayer(): int {
        return $this->currentPlayer;
    }
    // Dans la classe QuantikGame

    public function getPlateau(): PlateauQuantik {
        return $this->plateau;
    }
// Dans la classe QuantikGame

    public function getPiecesBlanches(): ArrayPieceQuantik {
        return $this->piecesBlanches;
    }
    public function switchPlayer(): void {
        $this->currentPlayer = ($this->currentPlayer === PieceQuantik::WHITE) ? PieceQuantik::BLACK : PieceQuantik::WHITE;
    }
    public function getPiecesNoires(): ArrayPieceQuantik {
        return $this->piecesNoires;
    }

    public function __toString(): string
    {
        return 'Partie n°' . $this->gameID . ' lancée par joueur ' . $this->getPlayers()[0];
    }

}
