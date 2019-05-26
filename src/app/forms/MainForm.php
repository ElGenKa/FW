<?php
namespace app\forms;

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
        open('http://185.244.42.28/');
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
        $this->vbox->x = ($this->width / 2) - ($this->width / 2);
        $this->vbox->y = ($this->height / 2) - ($this->height / 2);
    }

}
