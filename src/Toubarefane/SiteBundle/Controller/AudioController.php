<?php

// src/Toubarefane/SiteBundle/Controller/AudioController.php

namespace Toubarefane\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Toubarefane\SiteBundle\Controller\SiteController;
use Toubarefane\SiteBundle\Form\AudioType;

class AudioController extends Controller
{
   
  
  public function voiraudioAction($id)
  {
    $chemin="Audio>> Voir"; 
/* On récupère le repository*/
  $audios = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio')
                     ->getVoirAudio($id);

 
  return $this->render('ToubarefaneSiteBundle:Site:voirAudio.html.twig', array(
      'chemin'       => $chemin,
    'audios' => $audios,
   
  ));
    
  }
 public function audiomaggniAction()
  {
    $chemin="Audio>> Maggni"; 
// On récupère le repository
  $audios = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio')
                     ->getMaggni();
  return $this->render('ToubarefaneSiteBundle:Site:voirAudio.html.twig', array(
      'chemin'       => $chemin,
    'audios' => $audios,
   
  ));
    
  }
  public function audiozikrAction()
  {
    $chemin="Audio>> Zikr"; 
// On récupère le repository
  $audios = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio')
                     ->getZikr();
  return $this->render('ToubarefaneSiteBundle:Site:voirAudio.html.twig', array(
      'chemin'       => $chemin,
    'audios' => $audios,
    
  ));
    
  }
  public function audiosegnesaliouAction()
  {
    $chemin="Audio>> Segne Saliou"; 
// On récupère le repository
  $audios = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio')
                     ->getSegneSaliou();
  return $this->render('ToubarefaneSiteBundle:Site:voirAudio.html.twig', array(
      'chemin'       => $chemin,
    'audios' => $audios,
   
  ));
    
  }
  public function audiokourelAction()
  {
    $chemin="Audio>> Kourel"; 
// On récupère le repository
  $audios = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio')
                     ->getKourel();
  return $this->render('ToubarefaneSiteBundle:Site:voirAudio.html.twig', array(
      'chemin'       => $chemin,
    'audios' => $audios,
   
  ));
    
  }
  
  public function audioradiasAction()
  {
    $chemin="Audio>> Radias"; 
// On récupère le repository
  $audios  = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio')
                     ->getRadias();

  // On récupère l'entité correspondant à l'id $id
  //$audios = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

    
  return $this->render('ToubarefaneSiteBundle:Site:voirAudio.html.twig', array(
      'chemin'       => $chemin,
  
    'audios' => $audios
  ));
    
  
  }
  public function audiosegnesamAction()
  {
    $chemin="Audio>> SegneSam"; 
// On récupère le repository
  $audios  = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio')
                     ->getSegneSam();

  // On récupère l'entité correspondant à l'id $id
  //$audios = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

    
  return $this->render('ToubarefaneSiteBundle:Site:voirAudio.html.twig', array(
      'chemin'       => $chemin,
    
    'audios' => $audios
  ));
    
  
  }
  public function audiocoranAction()
  {
    $chemin="Audio>> Coran"; 
// On récupère le repository
  $audios = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio')
                       ->getCoran();

  // On récupère l'entité correspondant à l'id $id
 // $audios = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

    
  return $this->render('ToubarefaneSiteBundle:Site:voirAudio.html.twig', array(
      'chemin'       => $chemin,
    
    'audios' => $audios
    
  ));
    
  
  }
  public function audiowakhtaneAction()
  {
  $chemin="Audio>> Wakhtane"; 
// On récupère le repository
  $audios  = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio')
                     ->getWakhtane();

  // On récupère l'entité correspondant à l'id $id
  //$audios = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

    
  return $this->render('ToubarefaneSiteBundle:Site:voirAudio.html.twig', array(
      'chemin'       => $chemin,
      
    'audios' => $audios
  ));
    
  
  }
  //téré kham kham
  public function audiosikharAction()
  {
    $chemin="Audio>> Wakhtane"; 
// On récupère le repository
  $audios = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio')
                     ->getSikhar();
  return $this->render('ToubarefaneSiteBundle:Site:voirAudio.html.twig', array(
      'chemin'       => $chemin,
    'audios' => $audios,
    
  ));
    
  }
  public function audioSoubaneAction()
  {
    $chemin="Audio>> Autre"; 
// On récupère le repository
  $audios = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio')
                     ->getSoubane();
  return $this->render('ToubarefaneSiteBundle:Site:voirAudio.html.twig', array(
      'chemin'       => $chemin,
    'audios' => $audios,
  
  ));
    
  }
  public function audionahjouAction()
  {
    $chemin="Audio>> Nahjou"; 
// On récupère le repository
  $audios = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio')
                     ->getNahjou();
  return $this->render('ToubarefaneSiteBundle:Site:voirAudio.html.twig', array(
      'chemin'       => $chemin,
    'audios' => $audios,
   
  ));
    
  }
  public function audiojawharAction()
  {
    $chemin="Audio>> Jawhar"; 
// On récupère le repository
  $audios = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio')
                     ->getJawhar();
  return $this->render('ToubarefaneSiteBundle:Site:voirAudio.html.twig', array(
      'chemin'       => $chemin,
    'audios' => $audios,
   
  ));
    
  }
   public function audiomassalikAction()
  {
    $chemin="Audio>> Massalik"; 
// On récupère le repository
  $audios = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio')
                     ->getMassalik();
  return $this->render('ToubarefaneSiteBundle:Site:voirAudio.html.twig', array(
      'chemin'       => $chemin,
    'audios' => $audios,
    
  ));
    
  }
}