<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 *
 * @ORM\Table(name="cars")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CarRepository")
 */
class Car
{

    /**
     * @var string
     *
     * @ORM\Column(name="make", type="string", length=255, nullable=false)
     */
    private $make;

    /**
     *
     * @ORM\Column(name="model", type="string", length=255, nullable=false)
     */
    private $model;

    /**
     * @var integer
     *
     * @ORM\Column(name="travelledDistance", type="bigint", nullable=false)
     */
    private $travelledDistance;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity="Part", mappedBy="cars")
     */
    private $parts;

    public function __construct()
    {
        $this->parts = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getParts()
    {
        return $this->parts;
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
    public function getMake()
    {
        return $this->make;
    }

    /**
     * @param string $make
     *
     * @return Car
     */
    public function setMake($make)
    {
        $this->make = $make;
        return $this;
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param string $model
     *
     * @return Car
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return int
     */
    public function getTravelledDistance()
    {
        return $this->travelledDistance;
    }

    /**
     * @param int $travelledDistance
     *
     * @return Car
     */
    public function setTravelledDistance($travelledDistance)
    {
        $this->travelledDistance = $travelledDistance;
        return $this;
    }

    public function __toString()
    {
        return $this->model;
    }
}

