<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sale
 *
 * @ORM\Table(name="sales", indexes={@ORM\Index(name="FK_sales_customers", columns={"customer_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SaleRepository")
 */
class Sale
{

    /**
     * @var float
     *
     * @ORM\Column(name="discount", type="float", precision=10, scale=0,
     *   nullable=true)
     */
    private $discount;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Car
     *
     * @ORM\ManyToOne(targetEntity="Car")
     * @ORM\JoinColumn(name="car_id", referencedColumnName="id")
     */
    private $car;

    /**
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="sales")
     * @ORM\JoinColumns({
     *     @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * })
     */
    private $customer;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param float $discount
     *
     * @return Sale
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return \AppBundle\Entity\Car
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * @param \AppBundle\Entity\Car $car
     *
     * @return Sale
     */
    public function setCar($car)
    {
        $this->car = $car;
        return $this;
    }

    /**
     * @return \AppBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return Sale
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
    }
}

