<?php

// src/Toubarefane/SiteBundle/Controller/SiteController.php

namespace Toubarefane\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Toubarefane\SiteBundle\Entity\Image;
use Toubarefane\SiteBundle\Form\ImageType;

class PhotoController extends Controller
{
  
  public function voirAction($id)
  {
    $chemin="Photo>> voir";
      // On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Image');

  // On récupère l'entité correspondant à l'id $id
  $image = $repository->find($id);

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

  // Ou null si aucun article n'a été trouvé avec l'id $id
  if($image === null)
  {
    throw $this->createNotFoundException('Article[id='.$id.'] inexistant.');
  }
    
  return $this->render('ToubarefaneSiteBundle:Site:voirPhoto.html.twig', array(
    'chemin'       => $chemin,
    'image' => $image
  ));
    
  
  }
  public function touslesdolAction()
  {
    $chemin="Dols>> Tous";
      // On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Album');

  // On récupère les entités correspondant 
  $album = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

  // Ou null si aucun article n'a été trouvé avec l'id $id
  if($album === null)
  {
    throw $this->createNotFoundException('Album[id='.$id.'] inexistant.');
  }
    
  return $this->render('ToubarefaneSiteBundle:Site:tousdol.html.twig', array(
    'chemin'       => $chemin,
    'album' => $album
  ));
    
  
  }
  
  public function wakanaAction()
  {
    $chemin="Dol>> Wakana"; 
// On récupère le repository
  $images = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Image')
                     ->getWakana();
  // On récupère l'entité correspondant à l'id $id
  //$images = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

    
  return $this->render('ToubarefaneSiteBundle:Site:voirdol.html.twig', array(
      'chemin'       => $chemin,
    'images' => $images
  ));
 
  }
  public function marakhibAction()
  {
    $chemin="Dol>> Marakhib"; 
// On récupère le repository
  $images = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Image')
                     ->getMarakhib();
  // On récupère l'entité correspondant à l'id $id
  //$images = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

    
  return $this->render('ToubarefaneSiteBundle:Site:voirdol.html.twig', array(
      'chemin'       => $chemin,
    'images' => $images
  ));
 
  }
  public function taysirAction()
  {
    $chemin="Dol>> Taysir"; 
// On récupère le repository
  $images = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Image')
                     ->getTaysir();
  // On récupère l'entité correspondant à l'id $id
  //$images = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

    
  return $this->render('ToubarefaneSiteBundle:Site:voirdol.html.twig', array(
      'chemin'       => $chemin,
    'images' => $images
  ));
 
  }
  public function voirtousAction()
  {
    $chemin="Photo>> tous"; 
// On récupère le repository
  $images = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Image')
                    ->getPhoto();

  // On récupère l'entité correspondant à l'id $id
  //$images = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

    
  return $this->render('ToubarefaneSiteBundle:Site:animation.html.twig', array(
      'chemin'       => $chemin,
    'images' => $images
  ));
 
  }
  
 

}