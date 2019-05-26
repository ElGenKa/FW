<?php
namespace app\forms;

use facade\Json;
use std, gui, framework, app;


class MainForm extends AbstractForm
{

    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {    
        
    }

    /**
     * @event button.action 
     */
    function doButtonAction(UXEvent $e = null)
    {    
        
    }

    /**
     * @event buttonAlt.action 
     */
    function doButtonAltAction(UXEvent $e = null)
    {    
        
    }

    /**
     * @event construct 
     */
    function doConstruct(UXEvent $e = null)
    {    
        Timer::setTimeout(function(){
            $this->vbox->x = ($this->form('MainForm')->width / 2) - ($this->vbox->width / 2);
            $this->vbox->y = ($this->form('MainForm')->height / 2) - ($this->vbox->height / 2);
            Timer::setInterval(function(){
                $thread = new Thread(function(){
                    $get = file_get_contents('http://185.244.42.28/gameApi/api.php?method=ping');
                    $get = Json::decode($get);
                    uiLater(function() use ($get){
                        $this->label3->text = $get['response']['msg'];
                    });
                });
                $thread->start();
            },4000);
        },300);
    }

    /**
     * @event close 
     */
    function doClose(UXWindowEvent $e = null)
    {    
        app()->shutdown();
    }

}
