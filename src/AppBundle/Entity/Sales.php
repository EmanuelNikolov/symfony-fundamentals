<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sales
 *
 * @ORM\Table(name="sales", indexes={@ORM\Index(name="FK_sales_customers", columns={"customer_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SalesRepository")
 */
class Sales
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
     * @var \AppBundle\Entity\Cars
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cars")
     * @ORM\JoinColumn(name="car_id", referencedColumnName="id")
     */
    private $car;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Customers", inversedBy="sales")
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
     * @return Sales
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return \AppBundle\Entity\Cars
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * @param \AppBundle\Entity\Cars $car
     *
     * @return Sales
     */
    public function setCar($car)
    {
        $this->car = $car;
        return $this;
    }

    /**
     * @return \AppBundle\Entity\Customers
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param \AppBundle\Entity\Customers $customer
     *
     * @return Sales
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
    }
}

