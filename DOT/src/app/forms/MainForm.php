<?php
namespace app\forms;

use std, gui, framework, app;


class MainForm extends AbstractForm
{


    /**
     * @event showing 
     */
    function doShowing(UXWindowEvent $e = null)
    {    
        $this->fullScreen = true;
    }

    /**
     * @event login_button.click 
     */
    function doLogin_buttonClick(UXMouseEvent $e = null)
    {    
        $login = $this->login->text;
        $password=$this->pass->text;
        execute("rdesktop -f -u $login -p $password s1.rmstn.ru:30082");
    }
    
}
