<?php

namespace SP\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use SP\AdminBundle\Form\OfferType;

use SP\PurchaseBundle\Document\Offer;

/**
 * City controller.
 *
 * @Route("/entity/spitem")
 */
class OfferController extends Controller
{
     /**
     * Lists all Category entities.
     *
     * @Route("/", name="admin_spitem")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        $entities = $em->getRepository('PurchaseBundle:Offer')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    
     /**
     * Creates a new Category entity.
     *
     * @Route("/", name="admin_spitem_create")
     * @Method("POST")
     * @Template("AdminBundle:SPItem:new.html.twig")
     */
    public function createAction(Request $request)
    {   
        $entity = new SPItem();
        $form = $this->createForm(new SPItemType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine_mongodb')->getManager();
            
            // загружаем картинку
            $entity->upload();
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_spitem_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    
    /**
     * Displays a form to create a new Category entity.
     *
     * @Route("/new", name="admin_spitem_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Offer();
        $form   = $this->createForm(new OfferType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/{id}", name="admin_spitem_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {        
        $em = $this->get('doctrine_mongodb')->getManager();

        $entity = $em->getRepository('PurchaseBundle:Offer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="admin_spitem_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        $entity = $em->getRepository('PurchaseBundle:Offer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createForm(new SPItemType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Category entity.
     *
     * @Route("/{id}", name="admin_spitem_update")
     * @Method("POST")
     * @Template("AdminBundle:SPItem:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        $entity = $em->getRepository('PurchaseBundle:Offer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SPItemType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_spitem_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}", name="admin_spitem_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine_mongodb')->getManager();
            $entity = $em->getRepository('PurchaseBundle:Offer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_spitem'));
    }

    /**
     * Creates a form to delete a Category entity by id.
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