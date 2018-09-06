<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use AppBundle\Form\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Customers controller.
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

        $customers = $em->getRepository(Customer::class)->findAll();

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

        $customers = $em->getRepository(Customer::class)
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
     * @Route("/{id}",
     *     name="customers_show",
     *     methods={"GET"},
     *     requirements={"id" = "\d+"}
     * )
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showTotalSalesAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();

        $customer = $em->getRepository(Customer::class)
          ->getCustomerTotalSales($id);

        if (null === $customer) {
            throw new NotFoundHttpException("Customer not found.");
        }

        return $this->render('customers/show-total-sales.html.twig', [
          'customer' => $customer,
        ]);
    }

    /**
     * Creates a new car entity.
     *
     * @Route("/new", name="customer_new", methods={"GET", "POST"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $customer = new Customer();

        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return $this->redirectToRoute("customers_index");
        }

        return $this->render("customers/form.html.twig", [
          'form' => $form->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing car entity.
     *
     * @Route("/edit/{id}",
     *     name="customer_edit",
     *     methods={"GET", "POST"},
     *     requirements={"id" = "\d+"}
     * )
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \AppBundle\Entity\Customer $customer
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Customer $customer)
    {
        if (null === $customer) {
            throw new NotFoundHttpException("No user with that ID exists.");
        }

        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return $this->redirectToRoute("customers_show", [
              'id' => $customer->getId(),
            ]);
        }

        return $this->render("customers/form.html.twig", [
          'form' => $form->createView(),
        ]);
    }
}
