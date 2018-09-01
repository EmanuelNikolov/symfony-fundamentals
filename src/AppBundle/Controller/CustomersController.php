<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customers;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Customer controller.
 *
 * @Route("customers")
 */
class CustomersController extends Controller
{

    /**
     * Lists all customer entities.
     *
     * @Route("/all", name="customers_index", methods={"GET"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $customers = $em->getRepository(Customers::class)->findAll();

        return $this->render('customers/index.html.twig', [
          'customers' => $customers,
        ]);
    }

    /**
     * Lists all customer entities by order.
     *
     * @Route("/all/{order}", name="customers_order", methods={"GET"})
     *
     * @param $order
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAllByOrder($order)
    {
        $em = $this->getDoctrine()->getManager();

        $customers = $em->getRepository(Customers::class)
          ->getAllCustomersByGivenOrder($order);

        if (empty($customers)) {
            throw new NotFoundHttpException("No customers with such an order found.");
        }

        return $this->render('customers/index.html.twig', [
          'customers' => $customers,
        ]);
    }

    /**
     * Finds and displays a customer entity with total sales.
     *
     * @Route("/{id}", name="customers_show", methods={"GET"})
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showTotalSalesAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();

        $customer = $em->getRepository(Customers::class)
          ->getCustomerTotalSales($id);

        if (null === $customer) {
            throw new NotFoundHttpException("Customer not found.");
        }


        return $this->render('customers/show-total-sales.html.twig', [
          'customer' => $customer,
        ]);
    }
}
