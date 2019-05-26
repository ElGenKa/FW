<?php
namespace app\forms;

use std, gui, framework, app;
use app\game_data\game;
use UXHBox;

class build_structure extends AbstractForm
{
    var $list;
    var $objects;
    var $pos;
    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {    
        $game = $this->form('viewGame')->game_data;
        $strures = $game->get_structures();
        //var_dump($strures);
        $this->listView->items->clear();
        $list = array();
        foreach ($strures as $strure){
            $UXIcon = new UXImageView();
            $UXIcon->image = $strure['icon'];
            $UXIcon->size = [16,16];
            $label = new UXLabel();
            $label->autoSize = true;
            $label->text = $strure['name'];
            $layout = new UXHBox([$UXIcon,$label]);
            $this->listView->items->add($layout);
            $this->list[] = $strure;
            
        }
    }

    /**
     * @event button.action 
     */
    function doButtonAction(UXEvent $e = null)
    {    
        $this->hide();
    }



    /**
     * @event listView.action 
     */
    function doListViewAction(UXEvent $e = null)
    {
        $structure = $this->list[$e->sender->selectedIndex];
        if(!empty($this->objects)){
            foreach ($this->objects as $oject){
                $oject->free();
            }
        }
        
        $this->image->image = $structure['picture'];
        
        $this->objects = array();
        $ux = new UXLabel();
        $ux->text = $structure['name'];
        $ux->autoSize = true;
        $this->objects[] = $ux;
        $this->form('build_structure')->vbox->add($ux);
        
        $ux = new UXLabel();
        $ux->text = "Время стротельства: ".$structure['build'];
        $ux->autoSize = true;
        $ux->classesString = 'label';
        $this->objects[] = $ux;
        $this->form('build_structure')->vbox->add($ux);
        
        $ux = new UXLabel();
        $ux->text = "Стоимость минералов: ".$structure['minerals_sale'];
        $ux->autoSize = true;
        $ux->classesString = 'label';
        $this->objects[] = $ux;
        $this->form('build_structure')->vbox->add($ux);
        
        $ux = new UXLabel();
        $ux->text = "Стоимость энергии: ".$structure['energy_sale'];
        $ux->autoSize = true;
        $ux->classesString = 'label';
        $this->objects[] = $ux;
        $this->form('build_structure')->vbox->add($ux);
        
        $ux = new UXLabel();
        $ux->text = "Стоимость минералов (ход): ".$structure['minerals_steep_sale'];
        $ux->autoSize = true;
        $ux->classesString = 'label';
        $this->objects[] = $ux;
        $this->form('build_structure')->vbox->add($ux);
        
        $ux = new UXLabel();
        $ux->text = "Стоимость энергии (ход): ".$structure['energy_steep_sale'];
        $ux->autoSize = true;
        $ux->classesString = 'label';
        $this->objects[] = $ux;
        $this->form('build_structure')->vbox->add($ux);
        
        $ux = new UXLabel();
        $ux->text = "Размер структуры: ".$structure['size'];
        $ux->autoSize = true;
        $ux->classesString = 'label';
        $this->objects[] = $ux;
        $this->form('build_structure')->vbox->add($ux);
        
        $ux = new UXLabel();
        $ux->text = "Производит припасов: ".$structure['bust_supply'];
        $ux->autoSize = true;
        $ux->classesString = 'label';
        $this->objects[] = $ux;
        $this->form('build_structure')->vbox->add($ux);
        
        $ux = new UXLabel();
        $ux->text = "Производит припасов для армии: ".$structure['bust_supply_army'];
        $ux->autoSize = true;
        $ux->classesString = 'label';
        $this->objects[] = $ux;
        $this->form('build_structure')->vbox->add($ux);
        
        $ux = new UXLabel();
        $ux->text = "Ускоряет производство: ".$structure['bust_build_speed'];
        $ux->autoSize = true;
        $ux->classesString = 'label';
        $this->objects[] = $ux;
        $this->form('build_structure')->vbox->add($ux);
        
        $ux = new UXLabel();
        $ux->text = "Описание : \r\n".$structure['description'];
        $ux->autoSize = true;
        $ux->classesString = 'label';
        $this->objects[] = $ux;
        $this->form('build_structure')->vbox->add($ux);
    }

    /**
     * @event buttonAlt.action 
     */
    function doButtonAltAction(UXEvent $e = null)
    {
        //$e->target->data('structures')[$k]
        $structure = $this->list[$this->listView->selectedIndex];
        $ux = $this->form('viewGame')->map[$this->pos[0]][$this->pos[1]];
        $player = $this->form('viewGame')->player;
        $player_data = $this->form('viewGame')->player_data[$player];
        $structures = $ux->data('structures');
        if(count($structures)<$ux->data('size')){
            if($player_data['minerals'] >= $structure['minerals_sale'] and 
               $player_data['energy'] >= $structure['energy_sale']){
                $this->form('viewGame')->player_data[$player]['minerals'] -= $structure['minerals_sale'];
                $this->form('viewGame')->player_data[$player]['energy'] -= $structure['energy_sale'];
                //$this->form('viewGame')->click_zone();
                $structure['build_max'] = $structure['build'];
                $structure['destroy'] = 0;
                $structure['destroy'] = $structure['build'] / 2;
                //var_dump($structure);
                $ux->data('structures')[] = $structure;
                $this->form('viewGame')->render_eco_info();
                $this->hide();
                $this->form('viewGame')->game_data->play_build_sound();
            }
        }
    }

}
