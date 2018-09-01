<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Parts
 *
 * @ORM\Table(name="parts", indexes={@ORM\Index(name="FK__suppliers", columns={"supplier_id"})})
 * @ORM\Entity
 */
class Parts
{

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=10, scale=0,
     *   nullable=true)
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="bigint", nullable=true)
     */
    private $quantity;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Suppliers
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Suppliers", inversedBy="parts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="supplier_id", referencedColumnName="id")
     * })
     */
    private $supplier;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Cars", inversedBy="parts")
     * @ORM\JoinTable(
     *     name="parts_cars",
     *     joinColumns={
     *         @ORM\JoinColumn(name="part_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *         @ORM\JoinColumn(name="car_id", referencedColumnName="id")
     *     }
     * )
     */
    private $cars;

    public function __construct()
    {
        $this->cars = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCars()
    {
        return $this->cars;
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
     * @return Parts
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return Parts
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return Parts
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return \AppBundle\Entity\Suppliers
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * @param \AppBundle\Entity\Suppliers $supplier
     *
     * @return Parts
     */
    public function setSupplier($supplier)
    {
        $this->supplier = $supplier;
        return $this;
    }
}

