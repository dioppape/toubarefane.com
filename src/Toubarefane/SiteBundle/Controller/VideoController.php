<?php

// src/Toubarefane/SiteBundle/Controller/VideoController.php

namespace Toubarefane\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Toubarefane\SiteBundle\Entity\Video;
use Toubarefane\SiteBundle\Form\VideoType;

class VideoController extends Controller
{
    
  //
  
  public function voirAction($id)
  {
    $chemin="Video>> Voir";
      // On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Video');

  // On récupère l'entité correspondant à l'id $id
  $video = $repository->find($id);

  // $video est donc une instance de Toubarefane\SiteBundle\Entity\Video

  // Ou null si aucun video n'a été trouvé avec l'id $id
  if($video === null)
  {
    throw $this->createNotFoundException('Video[id='.$id.'] inexistant.');
  }
    
  return $this->render('ToubarefaneSiteBundle:Site:voirvideo.html.twig', array(
    'chemin'       => $chemin,
     'autrevideo'     => SiteController::getVideo(),
    'video' => $video
  ));
    
  }
    //recupere divers videos 
  public function autreAction()
  {
   $chemin="Video>> Divers Videos"; 
// On récupère le repository
  $videos = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Video')
                     ->getAutreVideos();

  // On récupère l'entité correspondant à l'id $id
  //$videos = $repository->findAll();

  // $video est donc une instance de Toubarefane\SiteBundle\Entity\Video

    
  return $this->render('ToubarefaneSiteBundle:Site:video.html.twig', array(
      'chemin'       => $chemin,
    'autrevideo'     => SiteController::getVideo(), 
    'videos' => $videos
  ));
    
  
  }
  
 //recupere tous les videos wakhtane
  public function wakhtaneAction()
  {
    $chemin="Video>> Wakhtane"; 
// On récupère le repository
   $videos = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Video')
                   ->getWakhtaneVideos();
  // On récupère l'entité correspondant à l'id $id
  //$videos = $repository->findAll();

  // $video est donc une instance de Toubarefane\SiteBundle\Entity\Video

    
  return $this->render('ToubarefaneSiteBundle:Site:video.html.twig', array(
      'chemin'       => $chemin,
    'autrevideo'     => SiteController::getVideo(),  
    'videos' => $videos
  ));
    
  
  }
  
 public function voirkhassidaAction()
  {
    $chemin="Video>> Khassida"; 
// On récupère le repository
  $videos = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Video')
                     ->getKhassidaVideos();

  // On récupère l'entité correspondant à l'id $id
  //$videos = $repository->findAll();

  // $video est donc une instance de Toubarefane\SiteBundle\Entity\Video

    
  return $this->render('ToubarefaneSiteBundle:Site:video.html.twig', array(
      'chemin'       => $chemin,
      'autrevideo'     => SiteController::getVideo(),
       'videos' => $videos
  ));
    
  
  }
 

 
}