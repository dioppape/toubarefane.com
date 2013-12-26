<?php

// src/Toubarefane/SiteBundle/Controller/SiteController.php

namespace Toubarefane\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SiteController extends Controller
{
  public function indexAction()
  {
    return $this->render('ToubarefaneSiteBundle:Site:index.html.twig');
  }
}