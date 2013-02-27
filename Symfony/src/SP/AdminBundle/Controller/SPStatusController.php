<?php

namespace SP\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use SP\AdminBundle\Form\SPStatusType;

use SP\PurchaseBundle\Document\PurchaseStatus;

/**
 * City controller.
 *
 * @Route("/entity/sp-status")
 */
class SPStatusController extends Controller
{
     /**
     * Lists all Product entities.
     *
     * @Route("/", name="admin_sp_status")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        $entities = $em->getRepository('SPBundle:SPStatus')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    
     /**
     * Creates a new Product entity.
     *
     * @Route("/", name="admin_sp_status_create")
     * @Method("POST")
     * @Template("SPBundle:SPStatus:new.html.twig")
     */
    public function createAction(Request $request)
    {   
        $entity = new SPStatus();
        $form = $this->createForm(new SPStatusType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine_mongodb')->getManager();
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_sp_status_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    
    /**
     * Displays a form to create a new Product entity.
     *
     * @Route("/new", name="admin_sp_status_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new SPStatus();
        $form   = $this->createForm(new SPStatusType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Product entity.
     *
     * @Route("/{id}", name="admin_sp_status_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {        
        $em = $this->get('doctrine_mongodb')->getManager();

        $entity = $em->getRepository('SPBundle:SPStatus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find City entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     * @Route("/{id}/edit", name="admin_sp_status_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        $entity = $em->getRepository('SPBundle:SPStatus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find City entity.');
        }

        $editForm = $this->createForm(new SPStatusType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Product entity.
     *
     * @Route("/{id}", name="admin_sp_status_update")
     * @Method("POST")
     * @Template("SPBundle:SPStatus:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        $entity = $em->getRepository('SPBundle:SPStatus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find City entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SPStatusType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_sp_status_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Product entity.
     *
     * @Route("/{id}", name="admin_sp_status_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine_mongodb')->getManager();
            $entity = $em->getRepository('SPBundle:SPStatus')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find City entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_sp_status'));
    }

    /**
     * Creates a form to delete a Product entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
}