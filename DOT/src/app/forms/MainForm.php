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

    
    public function notif($title, $message){
       $this->notice = new UXTrayNotification($title, $message, 'INFORMATION');
       $this->notice->animationType = 'POPUP';
       $this->notice->location = 'TOP_RIGHT';
       $this->notice->show();
    }
    /**
     * @event login_button.click 
     */
    function doLogin_buttonClick(UXMouseEvent $e = null)
    {
        $this->progressIndicator->show();
        
        $thread = new Thread(function () {
                $login = $this->login->text;
                $password=$this->pass->text;
                $data=file_get_contents(domain.'/auth.php?'.http_build_query(['login'=>$login, 'pass'=>md5($password)]));
        
            uiLater(function() use ($data) {
               if($data=='yes'){
                    global $login, $pass, $session_time;
                    $login=$this->login->text;
                    $pass=$this->pass->text;
                    if($this->save_log->selected){
                        $this->ini->set('login',$this->login->text, 'userdata');
                        $this->ini->set('pass',$this->pass->text, 'userdata');
                    }
                    $this->loadForm('lk');
                    $this->notif('Информация','Успешная авторизация');
                }elseif($data=='incorrect_password'){
                    $this->notif('Информация','Не правильный логин или пароль!');
                }elseif($data=='user_not_found'){
                    $this->notif('Информация','Пользователь не найден!');
                }   
                $this->progressIndicator->hide();
            });
        });
        
        $thread->start();
        //execute("rdesktop -f -u $login -p $password s1.rmstn.ru:30082");
    }

    /**
     * @event show 
     */
    function doShow(UXWindowEvent $e = null)
    {    
        $ini_data=$this->ini->toArray();
        if(isset($ini_data['userdata']) and isset($ini_data['userdata']['login']) and isset($ini_data['userdata']['pass'])){
            $this->login->text=$ini_data['userdata']['login'];
            $this->pass->text=$ini_data['userdata']['pass'];
            $this->save_log->selected=true;
        }
    }

    /**
     * @event keyDown-Enter 
     */
    function doKeyDownEnter(UXKeyEvent $e = null)
    {    
        $this->progressIndicator->show();
        
        $thread = new Thread(function () {
                $login = $this->login->text;
                $password=$this->pass->text;
                $data=file_get_contents(domain.'/auth.php?'.http_build_query(['login'=>$login, 'pass'=>md5($password)]));
        
            uiLater(function() use ($data) {
               if($data=='yes'){
                    global $login, $pass, $session_time;
                    $login=$this->login->text;
                    $pass=$this->pass->text;
                    if($this->save_log->selected){
                        $this->ini->set('login',$this->login->text, 'userdata');
                        $this->ini->set('pass',$this->pass->text, 'userdata');
                    }
                    $this->loadForm('lk');
                    $this->notif('Информация','Успешная авторизация');
                }elseif($data=='incorrect_password'){
                    $this->notif('Информация','Не правильный логин или пароль!');
                }elseif($data=='user_not_found'){
                    $this->notif('Информация','Пользователь не найден!');
                }   
                $this->progressIndicator->hide();
            });
        });
        
        $thread->start();
    }

    
}
