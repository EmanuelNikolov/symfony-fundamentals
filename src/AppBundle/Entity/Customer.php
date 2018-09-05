<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="customers")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Customer
{

    const YOUNG_DRIVER_DIFF = 'P2Y';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate", type="datetime", nullable=false)
     */
    private $birthDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isYoungDriver", type="boolean", nullable=false)
     */
    private $isYoungDriver;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Sale", mappedBy="customer")
     */
    private $sales;

    public function __construct()
    {
        $this->sales = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getSales()
    {
        return $this->sales;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Customer
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     *
     * @return Customer
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    /**
     * @return bool
     */
    public function isYoungDriver()
    {
        return $this->isYoungDriver;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * @return Customer
     * @throws \Exception
     */
    public function setIsYoungDriver()
    {
        $bday = clone $this->birthDate;
        $bday->add(new \DateInterval(self::YOUNG_DRIVER_DIFF));

        if ($bday >= new \DateTime('now')) {
            $this->isYoungDriver = true;
        } else {
            $this->isYoungDriver = false;
        }

        return $this;
    }
}

