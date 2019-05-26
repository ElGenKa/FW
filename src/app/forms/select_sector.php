<?php
namespace app\forms;

use std, gui, framework, app;


class select_sector extends AbstractForm
{

    var $sector;
    /**
     * @event listView.mouseEnter 
     */
    function doListViewMouseEnter(UXMouseEvent $e = null)
    {    
        
    }

    /**
     * @event button4.action 
     */
    function doButton4Action(UXEvent $e = null)
    {
        $this->form('viewGame')->fragment->visible = false;
    }

}
