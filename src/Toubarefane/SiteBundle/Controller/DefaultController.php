<?php

namespace Toubarefane\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ToubarefaneSiteBundle:Default:index.html.twig', array('name' => $name));
    }
}
