<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Car;
use AppBundle\Entity\Part;
use AppBundle\Form\CarType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Cars controller.
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

        $cars = $em->getRepository(Car::class)->findAll();

        return $this->render('cars/index.html.twig', [
          'cars' => $cars,
        ]);
    }

    /**
     * Creates a new car entity
     *
     * @Route("/new", name="cars_new", methods={"GET", "POST"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $car = new Car();
        /*$part1 = $this->getDoctrine()
          ->getRepository(Part::class)
          ->find(rand(3, 15));

        $car->getParts()->add($part1);
        $part1->getCars()->add($car);*/

        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush();

            return $this->redirectToRoute("cars_show", [
              'id' => $car->getId(),
            ]);
        }

        return $this->render("cars/new.html.twig", [
          'form' => $form->createView(),
        ]);
    }

    /**
     * Lists all car entities by make.
     *
     * @Route("/show/{make}",
     *     name="cars_make",
     *     methods={"GET"},
     *     requirements={"make" = "\D+"}
     * )
     * @param string $make
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showByMakeAction(string $make)
    {
        $em = $this->getDoctrine()->getManager();

        $cars = $em->getRepository(Car::class)
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
     * @Route("/show/{id}",
     *    name="cars_show",
     *    methods={"GET"},
     *    requirements={"id" = "\d+"}
     * )
     *
     * @param \AppBundle\Entity\Car $car
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Car $car)
    {
        return $this->render('cars/show.html.twig', [
          'car' => $car,
        ]);
    }
}
