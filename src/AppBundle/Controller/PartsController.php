<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Part;
use AppBundle\Form\PartType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Parts controller.
 *
 * @Route("parts")
 */
class PartsController extends Controller
{

    /**
     * Lists all part entities.
     *
     * @Route("/", name="part_index", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $parts = $em->getRepository(Part::class)->findAll();

        return $this->render('part/index.html.twig', [
          'parts' => $parts,
        ]);
    }

    /**
     * Creates a new part entity.
     *
     * @Route("/new", name="part_new", methods={"GET", "POST"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $part = new Part();
        $form = $this->createForm('AppBundle\Form\PartType', $part);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($part);
            $em->flush();

            return $this->redirectToRoute('part_show', [
              'id' => $part->getId()
            ]);
        }

        return $this->render('part/new.html.twig', [
          'part' => $part,
          'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a part entity.
     *
     * @Route("/{id}", name="part_show", methods={"GET"})
     * @param \AppBundle\Entity\Part $part
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Part $part)
    {
        $deleteForm = $this->createDeleteForm($part);

        return $this->render('part/show.html.twig', [
          'part' => $part,
          'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing part entity.
     *
     * @Route("/{id}/edit", name="part_edit", methods={"GET", "POST"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \AppBundle\Entity\Part $part
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Part $part)
    {
        $deleteForm = $this->createDeleteForm($part);
        $editForm = $this->createForm(PartType::class, $part);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('part_show', [
              'id' => $part->getId()
            ]);
        }

        return $this->render('part/edit.html.twig', [
          'part' => $part,
          'edit_form' => $editForm->createView(),
          'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a part entity.
     *
     * @Route("/{id}", name="part_delete", methods={"DELETE"})
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \AppBundle\Entity\Part $part
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Part $part)
    {
        $form = $this->createDeleteForm($part);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($part);
            $em->flush();
        }

        return $this->redirectToRoute('part_index');
    }

    /**
     * Creates a form to delete a part entity.
     *
     * @param Part $part The part entity
     *
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Part $part)
    {
        return $this->createFormBuilder()
          ->setAction($this->generateUrl('part_delete', [
            'id' => $part->getId(),
          ]))
          ->setMethod('DELETE')
          ->add('submit', SubmitType::class, [
            'label' => 'Delete',
              'attr' => [
                'onclick' => 'return confirm("Are you sure?")'
              ]
          ])
          ->getForm();
    }
}
