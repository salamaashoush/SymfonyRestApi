<?php
/**
 * Created by PhpStorm.
 * User: salamaashoush
 * Date: 5/17/17
 * Time: 11:50 PM
 */
namespace AppBundle\EventListener;
use AppBundle\Controller\Api\AttendanceController;
use mCzolko\HerokuSchedulerBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class HerokuSchedulerSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            Events::DAILY       => 'daily'
        ];
    }

    public function daily()
    {
       //logic here

    }
}