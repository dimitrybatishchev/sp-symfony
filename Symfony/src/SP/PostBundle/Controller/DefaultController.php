<?php

namespace SP\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use SP\PostBundle\Document\Post;

/**
 * City controller.
 *
 * @Route("/post")
 */
class DefaultController extends Controller
{   
    /**
     * @Route("/{urlName}", name="post_view")
     * @Template()
     */
    public function postViewAction($urlName)
    {
        $em = $this->get('doctrine_mongodb')->getManager();

        $post = $em->getRepository('PostBundle:Post')->findOneByUrlName($urlName);
        
        if (!$post) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }
        
        return array('post' => $post);
    }
}
