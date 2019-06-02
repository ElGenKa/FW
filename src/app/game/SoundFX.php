<?php
/**
 * Created by PhpStorm.
 * User: ElGen
 * Date: 01.06.2019
 * Time: 15:27
 */

namespace app\game;

use script\MediaPlayerScript;

class SoundFX
{
    public function play_build_sound(){
        return $this->play_sound('sound/start_buildi.mp3');
    }

    public function play_build_unit(){
        return $this->play_sound('sound/start_build_unit.mp3');
    }

    public function play_build_tank(){
        return $this->play_sound('sound/start_build_tank.mp3');
    }

    public function play_battle(){
        return $this->play_sound('sound/battle.mp3');
    }

    public function play_sound($f){
        $s = new MediaPlayerScript();
        $s->autoplay = true;
        $s->loop = false;
        $s->open($f);
        $s->on('doPlayerPlay', function($e){
            if($s->position == 100)
                $e->free();
        });
        return $s;
    }
}