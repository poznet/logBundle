<?php
namespace poznet\LogBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use poznet\LogBundle\Entity\Log;


class LogService
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function findAll()
    {
        return $this->em->getRepository("poznetLogBundle:Log")->findAll();
    }

    public function findBy($criteria = null, $order = null, $limit = null, $offset = null)
    {
        return $this->em->getRepository("poznetLogBundle:Log")->findBy($criteria, $order, $limit, $offset);
    }

    /**
     * @return array
     * for select
     */
    public function getUniqueUsers()
    {
        return $this->em->getRepository("poznetLogBundle:Log")->findAllUser();
    }

    /**
     * @return array
     * for select
     */
    public function getUniqueObjects()
    {

        return $this->em->getRepository("poznetLogBundle:Log")->findAllObject();
    }


    /**
     * @return string
     */
    public function userSelectWidget()
    {
        $users = $this->getUniqueUsers();
        $txt = '<select name="user" style="width:100%"  class="form-control">';
        foreach ($users as $user) {
            $txt .= ' <option value="' . $user["user"] . '">' . $user["user"] . '</option>';
        }
        $txt .= '                    </select>';
        return $txt;
    }

    /**
     * @return string
     */
    public function objectSelectWidget()
    {
        $objects= $this->getUniqueObjects();
        $txt = '<select name="object" style="width:100%" class="form-control">';
        foreach ($objects as $object) {
            $txt .= ' <option value="' . $object["object"] . '">' . $object["object"] . '</option>';
        }
        $txt .= '                    </select>';
        return $txt;
    }

    /**
     * @param $what
     * @return string
     */
    public function widget($what){
        if(property_exists(Log::class,$what)){
            if($what=='user')
                return $this->userSelectWidget();
            if($what=='object')
                return $this->objectSelectWidget();

        return '<input type="text" name="'.$what.'"  class="form-control" style="width:100%">';
        }
    }

}