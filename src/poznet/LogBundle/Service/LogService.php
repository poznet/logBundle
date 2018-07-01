<?php
namespace poznet\LogBundle\Service;
use Doctrine\ORM\EntityManagerInterface;


class LogService
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em=$entityManager;
    }

    public function findAll(){
        return $this->em->getRepository("poznetLogBundle:Log")->findAll();
    }

    public function findBy($criteria=null,$order=null,$limit=null,$offset=null){
        return $this->em->getRepository("poznetLogBundle:Log")->findBy($criteria,$order,$limit,$offset);
    }

}