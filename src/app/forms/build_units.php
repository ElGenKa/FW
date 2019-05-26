<?php
namespace app\forms;

use std, gui, framework, app;


class build_units extends AbstractForm
{
    var $target;

    /**
     * @event button.action 
     */
    function doButtonAction(UXEvent $e = null)
    {
        $this->hide();
    }

    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {    
        $this->listView->items->clear();
        $player = $this->form('viewGame')->player;
        $target = $this->target;
        if($target->data('player') == $player){
            $this->label->text = 'Выбирите юнитов для производства';
        }else{
            $this->label->text = 'Данный сектор вам не принадлежит';
        }
        foreach ($target->data('structures') as $key => $data){
            if(is_array($data['product_unit'])){
                foreach ($data['product_unit'] as $id => $unit){
                    $unit_data = $this->form('viewGame')->game_data->get_unit($unit);
                    $this->listView->items->add($unit_data['name']); 
                }
            }
        }
    }

    /**
     * @event listView.action 
     */
    function doListViewAction(UXEvent $e = null)
    {    
        
    }

    /**
     * @event buttonAlt.action 
     */
    function doButtonAltAction(UXEvent $e = null)
    {    
        
    }

}
