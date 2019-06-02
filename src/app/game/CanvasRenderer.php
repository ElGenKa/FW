<?php
/**
 * Created by PhpStorm.
 * User: ElGen
 * Date: 30.05.2019
 * Time: 22:22
 */

namespace app\game;


use app\game\Entitys\Entity;
use php\gui\UXCanvas;

class CanvasRenderer
{
    var $canvas;
    var $VisualEffects;
    var $processor;
    var $resurces;
    public function __construct(GameProcessing $processor, ResurceManager $Resurces)
    {
        $this->canvas = new UXCanvas();
        $this->processor = $processor;
        $this->resurces = $Resurces;
    }

    public function get_canvas(){
        return $this->canvas;
    }

    public function createmap($size, $map_file = NULL){
        $sector_names = file('db/sectors.txt');
        if(is_array($size)){
            $width = $size[0];
            $height = $size[1];
        }else{
            $width = $size;
            $height = $size;
        }

        for ($i = 0; $i < $height; $i++) {
            for ($j = 0; $j < $width; $j++) {
                $sector = new Entity();
                $sector->code = 'SECTOR';
                $sector->name = $sector_names[$i * 15 + $j];
                $sector->alldata['minerals_incum'] = 0.5;
                $sector->alldata['energy_incum'] = 0.5;
                $sector->alldata['supply'] = 5;
                $sector->alldata['supply_army'] = 5;
                $sector->alldata['size'] = 8;
                $sector->alldata['player'] = 0;
                $sector->alldata['build_speed'] = 1;
                $sector->alldata['structures'] = array();
                $sector->picture = $this->resurces->getTileId(0);
                $this->canvas->gc()->drawImage($sector->picture, $j*50, $i*50, 50, 50);
                $this->processor->addSector($sector,$j,$i);
            }
        }
    }

    public function reRenderSector($x,$y,$pixel = false){
        if($pixel == false){
            $ix = $x * 50;
            $iy = $y * 50;
        }else{
            $ix = $x;
            $iy = $y;
            $x = $x / 50;
            $y = $y / 50;
        }
        $this->canvas->gc()->drawImage(
            $this->resurces->getPlayerSector(
                $this->processor->getPlayerSector($x,$y)
            ), $ix, $iy, 50, 50);
    }
}