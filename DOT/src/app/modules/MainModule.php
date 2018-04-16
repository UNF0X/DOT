<?php
namespace app\modules;

use std, gui, framework, app;


class MainModule extends AbstractModule
{

    /**
     * @event hotkey.action 
     */
    function doHotkeyAction(ScriptEvent $e = null)
    {    
        app()->shutdown();
    }

    /**
     * @event action 
     */
    function doAction(ScriptEvent $e = null)
    {    
       define('domain', 'https://dot.unfox.ru');
    }



}
