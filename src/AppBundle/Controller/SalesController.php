<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sales;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Sale controller.
 *
 * @Route("sales")
 */
class SalesController extends Controller
{

    /**
     * Lists all sale entities.
     *
     * @Route("/", name="sales_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sales = $em->getRepository(Sales::class)->findAll();

        return $this->render('sales/index.html.twig', [
          'sales' => $sales,
        ]);
    }

    /**
     * Finds and displays a sale entity.
     *
     * @Route(
     *     "/{id}",
     *     name="sales_show",
     *     methods={"GET"},
     *     requirements={"id" = "\d+"}
     * )
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(int $id)
    {
        $em = $this->getDoctrine()->getRepository(Sales::class);
        $sale = $em->getSalesFullInfo($id);

        return $this->render('sales/show.html.twig', [
          'sale' => $sale,
        ]);
    }

    /**
     * Find and display all sale entities with a discount
     *
     * @Route("/discounted", name="sales_discounted", methods={"GET"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showDiscountedAction()
    {
        $em = $this->getDoctrine()->getRepository(Sales::class);
        $sales = $em->getAllDiscountedSales();

        if (empty($sales)) {
            throw new NotFoundHttpException("No discounted sales found.");
        }

        return $this->render('sales/showDiscounted.html.twig', [
          'sales' => $sales,
        ]);
    }

    /**
     * Find and display all sale entities with a user-specified discount
     *
     * @Route(
     *     "/discounted/{percent}",
     *     name="sales_discounted_by_percent",
     *     methods={"GET"},
     *     requirements={"percent" = "\d+"}
     * )
     * @param int $percent
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showDiscountedByPercentAction(int $percent)
    {
        $percent = floatval(round($percent / 100, 2));

        $em = $this->getDoctrine()->getManager();
        $sales = $em->getRepository(Sales::class)
          ->getDiscountedSalesByPercent($percent);

        if (empty($sales)) {
            throw new NotFoundHttpException("No sales found with specified discount");
        }

        return $this->render('sales/showDiscounted.html.twig', [
          'sales' => $sales,
        ]);
    }
}
