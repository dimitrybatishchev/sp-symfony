<?php

namespace SP\GeoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $repository = $this->get('doctrine_mongodb')
            ->getManager()
            ->getRepository('GeoBundle:City');
        $cities = $repository->findAll();
        return $this->render('GeoBundle:City:index.html.twig', array('cities' => $cities));
    }
}
