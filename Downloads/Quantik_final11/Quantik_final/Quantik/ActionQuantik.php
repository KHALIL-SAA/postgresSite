<?php
namespace Quantik2024;
class ActionQuantik{
    protected PlateauQuantik $plateau;
    public function __construct(PlateauQuantik $plateau){
        $this->plateau = $plateau;
    }

    public function getPlateau():PlateauQuantik{
        return $this->plateau;
    }
    public function isRowWin(int $numRow):bool{
        return $this::isComboWin($this->plateau->getRow($numRow));
    }
    public function isColWin(int $numCol):bool{
        return $this::isComboWin($this->plateau->getCol($numCol));
    }
    public function isCornerWin(int $dir):bool{
        return $this::isComboWin($this->plateau->getCorner($dir));
    }

    public function isValidePose(int $rowNum, int $colNum, PieceQuantik $piece): bool {
        $corner = PlateauQuantik::getCornerFromCoord($rowNum, $colNum);
        $void = PieceQuantik::initVoid();

        if ($this->plateau->getPiece($rowNum, $colNum) === $void &&
            $this->isPieceValide($this->plateau->getCol($colNum), $piece) &&
            $this->isPieceValide($this->plateau->getRow($rowNum), $piece) &&
            $this->isPieceValide($this->plateau->getCorner($corner), $piece)) {
            return true;
        }

        return false;
    }

    public function posePiece(int $rowNum, int $colNum, PieceQuantik $piece): void
    {
        $this->plateau->setPiece($rowNum,$colNum,$piece);
    }

    public function __toString():string{
        return $this->plateau->__toString();
    }

    private static function isComboWin(ArrayPieceQuantik $pieces):bool{
        $somme=0;

        for($i=0;$i<count($pieces);$i++){
            $forme = $pieces[$i]->getForme();
            $somme = $somme+$forme;

        }
        if($somme==10){
            return true;
        }
        return false;
    }

    private static function isPieceValide(ArrayPieceQuantik $pieces, PieceQuantik $p):bool {
        for($i=0;$i<count($pieces);$i++){
            if($pieces[$i]->getForme()===$p->getForme()&&$pieces[$i]->getCouleur()!==$p->getCouleur()){
                return false;
            }
        }
        return true;
    }

}


