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
    }

    /**
     * @event join.click-Left 
     */
    function doJoinClickLeft(UXMouseEvent $e = null)
    {
        $thread = new Thread(function () {
                global $login,$pass;
                execute("rdesktop -f -u $login -p $pass s1.rmstn.ru:30082");
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


    
    public function notif($title, $message){
       $this->notice = new UXTrayNotification($title, $message, 'INFORMATION');
       $this->notice->animationType = 'POPUP';
       $this->notice->location = 'TOP_RIGHT';
       $this->notice->show();
    }

    
}
