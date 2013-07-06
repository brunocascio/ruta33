<?php
namespace Firmas\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Firmas\FirmaBundle\Entity\Persona;
use Firmas\FirmaBundle\Form\PersonaType;

use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Persona controller.
 *
 */
class PersonaController extends Controller
{

    /**
     * Lists all Persona entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
         
         $dql   = "SELECT p FROM FirmasFirmaBundle:Persona p ORDER BY p.fecha_firma DESC";
         $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
                        $query,
                        $this->get('request')->query->get('page', 1)/*page number*/,
                        20/*limit per page*/
                    );

        return $this->render('FirmasAdminBundle:Persona:index.html.twig', array(
            'pagination' => $pagination,
            'titulo'     => 'Completo',
            //'total'  => sizeof($query),
        ));
    }

    /**
     * Creates a new Persona entity.
     *
     */
    /*public function createAction(Request $request)
    {
        $entity  = new Persona();
        $form = $this->createForm(new PersonaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('persona_show', array('id' => $entity->getId())));
        }

        return $this->render('FirmasFirmaBundle:Persona:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }*/

    /**
     * Displays a form to create a new Persona entity.
     *
     */
   /* public function newAction()
    {
        $entity = new Persona();
        $form   = $this->createForm(new PersonaType(), $entity);

        return $this->render('FirmasFirmaBundle:Persona:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    } */

    /**
     * Finds and displays a Persona entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FirmasFirmaBundle:Persona')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No existe la persona.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FirmasAdminBundle:Persona:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Persona entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FirmasFirmaBundle:Persona')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No existe la persona.');
        }

        $editForm = $this->createForm(new PersonaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('FirmasAdminBundle:Persona:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Persona entity.
     *
     */
    public function updateAction(Request $request, $id){

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FirmasFirmaBundle:Persona')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No existe tal Firma.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PersonaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Actualizado');

            return $this->redirect($this->generateUrl('persona_edit', array('id'=>$id)));
        }

        return $this->render('FirmasAdminBundle:Persona:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Persona entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FirmasFirmaBundle:Persona')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Persona entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('persona'));
    }

    /**
     * Creates a form to delete a Persona entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
