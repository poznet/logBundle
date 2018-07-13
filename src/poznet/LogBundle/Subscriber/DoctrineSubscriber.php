<?php
/**
 * Created by PhpStorm.
 * User: pozyc
 * Date: 13.07.2018
 * Time: 12:49
 */

namespace poznet\LogBundle\Subscriber;


use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use poznet\LogBundle\Entity\Log;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class DoctrineSubscriber implements EventSubscriber
{
    private $tokenStorage;

    /**
     * DoctrineSubscriber constructor.
     * @param $tokenStorage
     */
    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getSubscribedEvents()
    {
        return [
            'postPersist',
            'postUpdate',
            'postRemove',

        ];
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $em = $args->getObjectManager();
        $entity = $args->getEntity();
        $user = $this->tokenStorage->getToken()->getUser();
        $class = get_class($entity);
        $log = new Log();
        $log->setUser($user);
        $log->setObject($class);
        $log->setObjectId($entity->getId());
        $log->setUserId($user->getId());
        $log->setAction('record edited');
        $log->setDescription("User " . $user->getUsername() . ' edited  record');
        $em->persist($log);
        $em->flush($log);

    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $em = $args->getObjectManager();
        $entity = $args->getEntity();
        if($entity instanceof Log)
            return  ;
        $user = $this->tokenStorage->getToken()->getUser();
        $class = get_class($entity);
        $log = new Log();
        $log->setUser($user);
        $log->setObject($class);
        $log->setObjectId($entity->getId());
        $log->setUserId($user->getId());
        $log->setAction('new record');
        $log->setDescription("User " . $user->getUsername() . ' created  record');
        $em->persist($log);
        $em->flush($log);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $em = $args->getObjectManager();
        $entity = $args->getEntity();
        $user = $this->tokenStorage->getToken()->getUser();
        $class = get_class($entity);
        $log = new Log();
        $log->setUser($user);
        $log->setObject($class);
        $log->setObjectId($entity->getId());
        $log->setUserId($user->getId());
        $log->setAction('deleting record');
        $log->setDescription("User " . $user->getUsername() . ' deleted  record');
        $em->persist($log);
        $em->flush($log);
    }


}