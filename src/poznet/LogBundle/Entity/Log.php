<?php

namespace poznet\LogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Request;

/**
 * Log
 *
 * @ORM\Table(name="poznet_logbundle_log")
 * @ORM\Entity(repositoryClass="poznet\LogBundle\Repository\LogRepository")
 */
class Log
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data", type="datetime")
     */
    private $data;

    /**
     * @var string
     *
     * @ORM\Column(name="user", type="text", length=255 , nullable=true)
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="text", length=255 , nullable=true)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="text", length=255 , nullable=true)
     */
    private $action;

    /**
     * @var string
     *
     * @ORM\Column(name="object", type="text", length=255 , nullable=true)
     */
    private $object;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text" , nullable=true  )
     */
    private $description;


    public function __construct()
    {
        $this->data=new \DateTime();
        $request=Request::createFromGlobals();
        $this->ip=$request->getClientIp();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set data
     *
     * @param \DateTime $data
     *
     * @return Log
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return Log
     */
    public function setUser($user)
    {
        $this->user = serialize($user);

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return unserialize($this->user);
    }

    /**
     * Set action
     *
     * @param string $action
     *
     * @return Log
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set object
     *
     * @param string $object
     *
     * @return Log
     */
    public function setObject($object)
    {
        $this->object = serialize($object);

        return $this;
    }

    /**
     * Get object
     *
     * @return string
     */
    public function getObject()
    {
        return unserialize($this->object);
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Log
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }


}

