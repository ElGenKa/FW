<?php
namespace app\forms;

use Exception;
use facade\Json;
use php\gui\event\UXEvent;
use php\gui\event\UXWindowEvent;
use php\gui\framework\AbstractForm;
use php\lang\Thread;
use php\time\Timer;
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
                try {
                    $ping = microtime(true);
                    $get = file_get_contents('http://185.244.42.28/gameApi/api.php?method=ping');
                    //$get = Json::decode($get);
                        uiLater(function() use ($ping){
                            $this->label3->text = "Ping: ". floor((microtime(true) - $ping) * 1000);
                        });
                    }catch (Exception $e){
                        uiLater(function() use ($ping){
                            $this->label3->text = "Ping: not connected!";
                        });
                    }
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
