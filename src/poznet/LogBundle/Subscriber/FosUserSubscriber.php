<?php
/**
 * Created by PhpStorm.
 * User: pozyc
 * Date: 19.06.2018
 * Time: 10:05
 */

namespace poznet\LogBundle\Subscriber;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\FOSUserEvents;
use poznet\LogBundle\Entity\Log;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class FosUserSubscriber implements EventSubscriberInterface
{
    private $em;
    private $tokenStorage;

    public function __construct(EntityManagerInterface $entityManager,TokenStorageInterface $storage)
    {
        $this->em=$entityManager;
        $this->tokenStorage=$storage;
    }

    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::CHANGE_PASSWORD_SUCCESS =>'onPasswordReset',

            FOSUserEvents::SECURITY_IMPLICIT_LOGIN => 'onLogin',
            FOSUserEvents::USER_CREATED => 'onNewFOSUser',
            'new.user'=>'onNewUser',
            SecurityEvents::INTERACTIVE_LOGIN =>'onLogin',
        ];
    }


    public function onPasswordReset(\FOS\UserBundle\Event\FormEvent $event){
        $user=$this->tokenStorage->getToken()->getUser();
        $log=new Log();
        $log->setUser($user);
        $log->setUserId($user->getId());
        $log->setAction('password change');
        $log->setDescription("User ".$user->getUsername(). ' changed password');
        $this->em->persist($log);
        $this->em->flush($log);
    }

    public function onLogin(InteractiveLoginEvent $event){
        $user=$event->getAuthenticationToken()->getUser();
        $log=new Log();
        $log->setUser($user);
        $log->setUserId($user->getId());
        $log->setAction('login');
        $log->setDescription("User ".$user->getUsername(). ' logged in');
        $this->em->persist($log);
        $this->em->flush($log);
    }

    public function onNewFOSUser(\FOS\UserBundle\Event\FormEvent $event){
        $data=$event->getForm()->getData();
        //TODO
}

    /**
     * @param $event
     * For custom events
     * event should have form (with  registration form content, and user entity should be based  on baseuser (username field)
     */
    public function onNewUser($event){
        $user=$event->getForm()->getData();
        $user2=$this->tokenStorage->getToken()->getUser();
        $log=new Log();
        $log->setUser($user);
        $log->setUserId($user->getId());
        $log->setAction('new account');
        $log->setDescription("User ".$user->getUsername(). 'account created by '.$user2->getUsername().' ');
        $this->em->persist($log);
        $this->em->flush($log);
    }


}