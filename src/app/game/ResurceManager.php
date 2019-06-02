<?php
/**
 * Created by PhpStorm.
 * User: ElGen
 * Date: 01.06.2019
 * Time: 14:07
 */

namespace app\game;

use php\gui\UXImage;

class ResurceManager
{
    /** @var array */
    var $images;

    public function __construct()
    {
        $this->icons_player();
        $this->tiles();
        $this->interface();
        $this->other();
    }

    private function icons_player(){
        for($i=0; $i<11;$i++)
            $this->images['player'][$i] = new UXImage("UI/profile/$i.png");
    }

    private function tiles(){
        $this->images['tiles'][] = new UXImage('UI/map/0.png');
    }

    private function interface(){
        $this->images['interface']['panel']['bottom'] = 'UI/interface/panel/bottom.png';
        $this->images['interface']['panel']['left'] = 'UI/interface/panel/left.png';
        $this->images['interface']['panel']['right'] = 'UI/interface/panel/right.png';
        $this->images['interface']['panel']['top'] = 'UI/interface/panel/top.png';
        $this->images['interface']['box'] = 'UI/interface/box.png';
        $this->images['interface']['box_used'] = 'UI/interface/box_used.png';
    }

    private function other(){
        $this->images['player_sector'][0] = new UXImage('UI/icons/0.png');
        $this->images['player_sector'][1] = new UXImage('UI/icons/1.png');
        $this->images['player_sector'][2] = new UXImage('UI/icons/2.png');
        $this->images['player_sector_b'] = new UXImage('UI/icons/sector_b.png');
        $this->images['player_sector_add'] = new UXImage('UI/icons/add.png');
        $this->images['player_sector_build'] = new UXImage('UI/icons/build.png');
        $this->images['player_sector_build_wait'] = new UXImage('UI/icons/wait_build.png');
        $this->images['line_process_color'] = new UXImage('UI/icons/process_build.png');
    }

    public function getTileId($id){
        return $this->images['tiles'][$id];
    }

    public function getPlayerSector($id){
        return $this->images['player_sector'][$id];
    }

}