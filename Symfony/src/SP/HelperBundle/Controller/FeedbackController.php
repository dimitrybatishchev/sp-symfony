<?php

namespace SP\HelperBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use SP\HelperBundle\Document\Feedback;

use SP\HelperBundle\Form\FeedbackType;

/**
 * City controller.
 *
 * @Route("/")
 */
class FeedbackController extends Controller
{  
    /**
     * @Route("/feedback", name="feedback")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $entity = new Feedback();
        $form   = $this->createForm(new FeedbackType(), $entity);
        
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->get('doctrine_mongodb')->getManager();
                $em->persist($entity);
                $em->flush();
                return array(
                    'sended' => True,
                );
            }
        }

        return array(
            'sended' => False,
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    
}
