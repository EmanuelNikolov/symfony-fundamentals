<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customers;
use AppBundle\Form\CustomersType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/edit/{id}", name="customer_edit", requirements={"id" = "\d+"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, int $id)
    {
        $customer = $this->getDoctrine()
          ->getRepository(Customers::class)
          ->find($id);

        if (null === $customer) {
            throw new NotFoundHttpException("No user with that ID exists.");
        }

        $form = $this->createForm(CustomersType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return $this->redirectToRoute("customers_show", [
              'id' => $id
            ]);
        }

        return $this->render("customers/edit.html.twig", [
          'form' => $form->createView(),
        ]);
    }
}
