<?php
namespace app\forms;

use std, gui, framework, app;


class build_upgrades extends AbstractForm
{

    /**
     * @event button.action 
     */
    function doButtonAction(UXEvent $e = null)
    {
        $this->hide();
        
    }

}
