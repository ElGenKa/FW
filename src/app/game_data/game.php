<?php

namespace app\game_data;

use behaviour\custom\DraggingBehaviour;
use php\gui\shape\UXRectangle;
use php\gui\UXButton;
use php\gui\UXCanvas;
use php\gui\UXForm;
use php\gui\UXListView;
use php\time\Timer;
use script\MediaPlayerScript;
use std, gui, framework, app;
use app\game_data\db\units;
use app\game_data\db\structures;
use app\game_data\UXCreator;

class game
{
    private $structures;
    private $units;
    public $uxcreator;

    public function __construct()
    {
        $this->structures = new structures();
        $this->units = new units();
        $this->uxcreator = new UXCreator();
    }

    public function get_structure($code)
    {
        return $this->structures->get($code);
    }

    public function get_unit($code)
    {
        return $this->units->get($code);
    }

    public function get_structures()
    {
        return $this->structures->get_all();
    }



    public function create_panel_units($e, UXForm $form){
        $target = $e->sender;
        //$target
    }

    public function create_panel($e, UXForm $form)
    {

    }
}