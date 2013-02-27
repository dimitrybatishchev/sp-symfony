<?php

namespace SP\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use SP\AdminBundle\Form\CityType;

use SP\GeoBundle\Document\City;

/**
 * City controller.
 *
 * @Route("/entity/city")
 */
class CityController extends Controller
{
     /**
     * Lists all Product entities.
     *
     * @Route("/", name="admin_city")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        $entities = $em->getRepository('GeoBundle:City')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    
    /**
     * @Route("/new", name="admin_city_create")
     * @Template()
     */
    public function createAction(Request $request)
    {
        $entity = new City();
        $form   = $this->createForm(new CityType(), $entity);
        
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->get('doctrine_mongodb')->getManager();
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('admin_city_show', array('id' => $entity->getId())));
            }
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * @Route("/{id}", name="admin_city_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {        
        $em = $this->get('doctrine_mongodb')->getManager();

        $entity = $em->getRepository('GeoBundle:City')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find City entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Edits an existing Product entity.
     *
     * @Route("/{id}/edit", name="admin_city_edit")
     * @Template("AdminBundle:City:edit.html.twig")
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        $entity = $em->getRepository('GeoBundle:City')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find City entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new CityType(), $entity);
       
        if ($request->isMethod('POST')) {
            $editForm->bind($request);
            if ($editForm->isValid()) {
                $em->persist($entity);
                $em->flush();
                return $this->redirect($this->generateUrl('admin_city_show', array('id' => $id)));
            }
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
     * @Route("/{id}", name="admin_city_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine_mongodb')->getManager();
            $entity = $em->getRepository('GeoBundle:City')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find City entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_city'));
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