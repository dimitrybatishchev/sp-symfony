<?php

namespace SP\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use SP\AdminBundle\Form\PostType;

use SP\PostBundle\Document\Post;

/**
 * City controller.
 *
 * @Route("/entity/post")
 */
class PostController extends Controller
{
     /**
     * Lists all Product entities.
     *
     * @Route("/", name="admin_post")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        $entities = $em->getRepository('PostBundle:Post')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    
     /**
     * Creates a new Product entity.
     *
     * @Route("/", name="admin_post_create")
     * @Method("POST")
     * @Template("AdminBundle:Post:new.html.twig")
     */
    public function createAction(Request $request)
    {   
        $entity = new Post();
        $form = $this->createForm(new PostType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine_mongodb')->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_post_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
    
    /**
     * Displays a form to create a new Product entity.
     *
     * @Route("/new", name="admin_post_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Post();
        $form   = $this->createForm(new PostType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Product entity.
     *
     * @Route("/{id}", name="admin_post_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {        
        $em = $this->get('doctrine_mongodb')->getManager();

        $entity = $em->getRepository('PostBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
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
     * @Route("/{id}/edit", name="admin_post_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        $entity = $em->getRepository('PostBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $editForm = $this->createForm(new PostType(), $entity);
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
     * @Route("/{id}", name="admin_post_update")
     * @Method("POST")
     * @Template("AdminBundle:Post:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        $entity = $em->getRepository('PostBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PostType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_post_edit', array('id' => $id)));
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
     * @Route("/{id}", name="admin_post_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine_mongodb')->getManager();
            $entity = $em->getRepository('PostBundle:Post')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Post entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_post'));
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
    
    
    
    
    
    
    /*
    public function indexAction()
    {
        $repository = $this->get('doctrine_mongodb')
            ->getManager()
            ->getRepository('GeoBundle:City');
        $cities = $repository->findAll();
        return $this->render('AdminBundle:City:index.html.twig', array('cities' => $cities));
    }
    public function createAction(Request $request)
    {
        $city = new City();
        
        $form  = $this->createFormBuilder($city)
                ->add('name', 'text')
                ->getForm();
        
        if ($request->getMethod() == 'POST'){
            $form->bindRequest($request);
            if ($form->isValid()) {
                
                $dm = $this->get('doctrine_mongodb')->getManager();
                $dm->persist($city);
                $dm->flush();
    
                return $this->redirect($this->generateUrl('admin_city_list'));
            }
        }
        
        return $this->render('AdminBundle:City:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    public function editAction(Request $request, $id)
    {
        $request = $this->get('request');
        if (is_null($id)){
            $postData = $request->get('testimonial');
            $id = $postData['id'];
        }
        
        $city = $this->get('doctrine_mongodb')
            ->getRepository('GeoBundle:City')
            ->find($id);
        
        $form  = $this->createFormBuilder($city)
                ->add('name', 'text')
                ->add('id', 'hidden')
                ->getForm();
        
        if ($request->getMethod() == 'POST'){
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                $dm = $this->get('doctrine_mongodb')->getManager();         
                $dm->flush();
    
                return $this->redirect($this->generateUrl('admin_city_list'));
            }
        }
        
        return $this->render('AdminBundle:City:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    public function detailsAction($id)
    {
        $city = $this->get('doctrine_mongodb')
            ->getRepository('GeoBundle:City')
            ->find($id);

        if (!$city) {
            throw $this->createNotFoundException('No city found for id '.$id);
        }

        return $this->render('AdminBundle:City:details.html.twig', array('city' => $city));
    }
} */
