<?php
namespace app\forms;

use std, gui, framework, app;


class profile extends AbstractForm
{

    /**
     * @event close 
     */
    function doClose(UXWindowEvent $e = null)
    {    
        app()->shutdown();
    }

}
