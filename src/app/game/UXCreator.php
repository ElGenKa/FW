<?php
/**
 * Created by PhpStorm.
 * User: ElGen
 * Date: 30.05.2019
 * Time: 22:22
 */

namespace app\game;
use gui;


class UXCreator
{
    public function label($text,$classes = 'label', $AS = true){
        $label = new UXLabel();
        $label->autosize = $AS;
        $label->text = $text;
        $label->classesString = $classes;
        return $label;
    }

    public function panel($x,$y,$size = [640,480],$front = true, $classes = 'panel_color'){
        $panel = new UXPanel();
        $panel->size = $size;
        $panel->y = $x;
        $panel->x = $y;
        if($front == true){
            $panel->on('click', function ($e) {
                $e->sender->tofront();
            });
        }
        $panel->classesString = $classes;
        $panel->borderWidth = 0;
        $panel->style = '';
        return $panel;
    }

    public function button(){

    }
}