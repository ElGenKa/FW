<?php
/**
 * Created by PhpStorm.
 * User: ElGen
 * Date: 01.06.2019
 * Time: 15:42
 */

namespace app\game;

class GameProcessing
{
    /** @var array */
    var $sectors;

    public function addSector($data,$x,$y){
        $this->sectors[$x][$y] = $data;
    }

    public function setSectorPlayer($x,$y,$player){
        $this->sectors[$x][$y]['player'] = $player;
    }

    public function getPlayerSector($x,$y){
        return $this->sectors[$x][$y]['player'];
    }
}