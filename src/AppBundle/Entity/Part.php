<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Part
 *
 * @ORM\Table(name="parts", indexes={@ORM\Index(name="FK__suppliers", columns={"supplier_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartRepository")
 */
class Part
{

    const QUANTITY_DEFAULT = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true, unique=true)
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
     * @ORM\Column(name="quantity",
     *     type="bigint",
     *     nullable=true,
     *     options={"default":1}
     * )
     */
    private $quantity = self::QUANTITY_DEFAULT;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Supplier
     *
     * @ORM\ManyToOne(targetEntity="Supplier", inversedBy="parts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="supplier_id", referencedColumnName="id")
     * })
     */
    private $supplier;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Car", mappedBy="parts")
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
     * @return Part
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
     * @return Part
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
     * @return Part
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return \AppBundle\Entity\Supplier
     */
    public function getSupplier()
    {
        return $this->supplier;
    }

    /**
     * @param \AppBundle\Entity\Supplier $supplier
     *
     * @return Part
     */
    public function setSupplier($supplier)
    {
        $this->supplier = $supplier;
        return $this;
    }
}

