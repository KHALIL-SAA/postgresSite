<?php
namespace Quantik2024;
class PlateauQuantik{
    const NBROWS = 4;
    const NBCOLS = 4;
    const NW = 0;
    const NE = 1;
    const SW = 2;
    const SE = 3;

    protected array $cases;

    public function __construct(){
        $this->cases = array();
        for($i=0;$i<4;$i++){
            $this->cases[$i] = new ArrayPieceQuantik();
            for($j=0;$j<4;$j++){
                $this->cases[$i]->addPieceQuantik(PieceQuantik::initVoid());
            }
        }
    }

    public function getPiece(int $rowNum, int $colNum) : PieceQuantik{
        return $this->cases[$rowNum]->getPieceQuantik($colNum);
    }

    public function setPiece(int $rowNum, int $colNum, PieceQuantik $piece){
        $this->cases[$rowNum]->setPieceQuantik($colNum,$piece);
    }

    public function getRow(int $numRow) : ArrayPieceQuantik{
        return $this->cases[$numRow];
    }
    public function getCol(int $numCol):ArrayPieceQuantik{
        $result = new ArrayPieceQuantik();
        for($i= 0;$i< 4;$i++){
            $result->addPieceQuantik($this->cases[$i]->getPieceQuantik($numCol));
        }
        return $result;
    }

    public function getCorner(int $dir):ArrayPieceQuantik{
        $result = new ArrayPieceQuantik();
        switch($dir){
            case self::NW :
                $result->addPieceQuantik($this->cases[0]->getPieceQuantik(0));
                $result->addPieceQuantik($this->cases[0]->getPieceQuantik(1));
                $result->addPieceQuantik($this->cases[1]->getPieceQuantik(0));
                $result->addPieceQuantik($this->cases[1]->getPieceQuantik(1));
                break;
            case self::NE :
                $result->addPieceQuantik($this->cases[0]->getPieceQuantik(2));
                $result->addPieceQuantik($this->cases[0]->getPieceQuantik(3));
                $result->addPieceQuantik($this->cases[1]->getPieceQuantik(2));
                $result->addPieceQuantik($this->cases[1]->getPieceQuantik(3));
                break;
            case self::SW :
                $result->addPieceQuantik($this->cases[2]->getPieceQuantik(0));
                $result->addPieceQuantik($this->cases[2]->getPieceQuantik(1));
                $result->addPieceQuantik($this->cases[3]->getPieceQuantik(0));
                $result->addPieceQuantik($this->cases[3]->getPieceQuantik(1));
                break;
            case self::SE :
                $result->addPieceQuantik($this->cases[2]->getPieceQuantik(2));
                $result->addPieceQuantik($this->cases[2]->getPieceQuantik(3));
                $result->addPieceQuantik($this->cases[3]->getPieceQuantik(2));
                $result->addPieceQuantik($this->cases[3]->getPieceQuantik(3));
                break;
        }
        return $result;
    }

    public function __toString():string{
        $s ="";
        for($i=0;$i<4;$i++){
            $s .= $this->cases[$i]."<br/>";
        }
        return $s;
    }

    public static function getCornerFromCoord(int $rowNum, int $colNum):int{
        if($rowNum==0 || $rowNum==1){
            if($colNum>1) return self::NE;
            else return self::NW;
        }else{
            if($colNum>1) return self::SE;
            else return self::SW;
        }
    }

    public function getJson(): string {
        $json = "[";
        $jTab = [];
        foreach ($this->cases as $apq)
            $jTab[] = $apq->getJson();
        $json .= implode(',',$jTab);
        return $json.']';
    }

    public static function initPlateauQuantik(string|array $json) : PlateauQuantik
    {
        $pq = new PlateauQuantik();
        if (is_string($json))
            $json = json_decode($json);
        $cases = [];
        foreach($json as $elem)
            $cases[] = ArrayPieceQuantik::initArrayPieceQuantik($elem);
        $pq->cases = $cases;
        return $pq;
    }

}

