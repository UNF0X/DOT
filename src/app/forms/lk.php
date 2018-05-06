<?php
namespace app\forms;

use std, gui, framework, app, php\time\Timer;


class lk extends AbstractForm
{


    /**
     * @event showing 
     */
    function doShowing(UXWindowEvent $e = null)
    {    
        $this->fullScreen = true;
        global $login,$pass;
        if($login=='unfox'){
            $this->exitButton->show();
            $this->exitButton->enabled=true;
        }
    }

    /**
     * @event join.click-Left 
     */
    function doJoinClickLeft(UXMouseEvent $e = null)
    {
    
    $directory = new File('/media/pi');
        global $disks;
        $disks = '';
        
        foreach ($directory->findFiles() as $one) {
            if ($one->isDirectory()) { // или fs::isDir($one)
                $name=explode('/',$one);
                $name=$name[count($name)-1];
                //$name=str_ireplace(' ', '\ ', $name);
                $disks.='-r disk:"'.$name.'"="'.$one.'" ';
            }
        }
        global $login,$pass, $disks;
                $command='/usr/bin/DOT/start.js '.$login.' '.$pass.' '.'s1.rmstn.ru:30082 '.$disks;
                $execute = execute('/usr/bin/nodejs '.$command);
                echo $disks;
            $thread = new Thread(function () {
                
            uiLater(function() use ($data) {
                $timer = Timer::after(5000, function () {
                  $this->progressIndicator->hide();
                  global $status;
                  $status=true;
                });
            });
            Timer::every('1s', function (Timer $timer) {
                    global $session_time;
                    $session_time+=1;
            });
        });
        $this->progressIndicator->show();
        $thread->start();
    }

    /**
     * @event mouseEnter 
     */
    function doMouseEnter(UXMouseEvent $e = null)
    {    
        global $status, $session_time, $show_session;
        //$this->notif('TEST',$status);
        if($status==true){
            if($show_session==false){
                $this->notif('TEST','Было замечено завершение сеанса! Время сессии: '.$session_time.' секунд');
            }
            $show_session=true;
        }
    }

    /**
     * @event exitButton.click 
     */
    function doExitButtonClick(UXMouseEvent $e = null)
    {    
        app()->shutdown();
    }


    
    public function notif($title, $message){
       $this->notice = new UXTrayNotification($title, $message, 'INFORMATION');
       $this->notice->animationType = 'POPUP';
       $this->notice->location = 'TOP_RIGHT';
       $this->notice->show();
    }

    
}
