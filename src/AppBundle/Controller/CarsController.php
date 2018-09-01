<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cars;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Car controller.
 *
 * @Route("cars")
 */
class CarsController extends Controller
{

    /**
     * Lists all car entities.
     *
     * @Route("/", name="cars_index", methods={"GET"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cars = $em->getRepository(Cars::class)->findAll();



        return $this->render('cars/index.html.twig', [
          'cars' => $cars,
        ]);
    }

    /**
     * Lists all car entities by make.
     *
     * @Route("/{make}", name="cars_make", methods={"GET"})
     * @param string $make
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showByMakeAction(string $make)
    {
        $em = $this->getDoctrine()->getManager();

        $cars = $em->getRepository(Cars::class)
          ->getAllCarsByMake($make);

        if (empty($cars)) {
            throw new NotFoundHttpException("Car make not found");
        }

        return $this->render('cars/index.html.twig', [
          'cars' => $cars,
        ]);
    }

    /**
     * Finds and displays a car entity.
     *
     * @Route("/show/{id}", name="cars_show", methods={"GET"})
     * @param \AppBundle\Entity\Cars $car
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Cars $car)
    {

        return $this->render('cars/show.html.twig', [
          'car' => $car,
        ]);
    }
}