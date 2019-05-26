<?php
namespace app\game_data;

use gui;

class UXCreator 
{
    public function label($text,$classes, $AS = true){
        $label = new UXLabel();
        $label->autosize = $AS;
        $label->text = $text;
        $label->classesString = $classes;
        return $label;
    }
}