<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RoleEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['AddRoleToUser', EventPriorities::POST_VALIDATE],
        ];
    }

    public function AddRoleToUser(GetResponseForControllerResultEvent $event)
    {
        $user = $event->getControllerResult();
        if (!$user instanceof User){
            return;
        }

        if(empty($user->getRoles())){
            $user->setRoles(["ROLE_USER"]);
        }
    }
}
