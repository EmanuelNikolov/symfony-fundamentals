<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Supplier
 *
 * @ORM\Table(name="suppliers")
 * @ORM\Entity
 */
class Supplier
{

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isImporter", type="boolean", nullable=false)
     */
    private $isImporter;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Part", mappedBy="supplier")
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Supplier
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function isImporter()
    {
        return $this->isImporter;
    }

    /**
     * @param bool $isImporter
     *
     * @return Supplier
     */
    public function setIsImporter($isImporter)
    {
        $this->isImporter = $isImporter;
        return $this;
    }
}

