<?php

// src/Toubarefane/SiteBundle/Controller/AudioController.php

namespace Toubarefane\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Toubarefane\SiteBundle\Entity\Audio;
use Toubarefane\SiteBundle\Form\AudioType;

class AudioController extends Controller
{
   
  public function ajouterAction()
  {
     

     $audio = new Audio();
     $chemin="Audio>> ajouter";
    // On crée le formulaire grâce à l'ArticleType
    $form = $this->createForm(new AudioType(), $audio);

    // On récupère la requête
    $request = $this->getRequest();

    // On vérifie qu'elle est de type POST
    if ($request->getMethod() == 'POST') {
      // On fait le lien Requête <-> Formulaire
      $form->bind($request);

      // On vérifie que les valeurs entrées sont correctes
      // (Nous verrons la validation des objets en détail dans le prochain chapitre)
      if ($form->isValid()) {
  // Ici : On traite manuellement le fichier uploadé
  $audio->upload();

  // Puis, le reste de la méthode, qu'on avait déjà fait
  $em = $this->getDoctrine()->getManager();
  $em->persist($audio);
  $em->flush();

        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', 'image bien ajouté');

        // On redirige vers la page de visualisation de l'article nouvellement créé
        return $this->redirect($this->generateUrl('toubarefaneaudio_ajouter'));
      }
    }
    return $this->render('ToubarefaneSiteBundle:Admin:audio.html.twig',array('chemin'=> $chemin,'form' => $form->createView()));
  }
 
  public function voirAction($id)
  {
    $chemin="Audio>> voir";
      // On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio');

  // On récupère l'entité correspondant à l'id $id
  $audio = $repository->find($id);

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

  // Ou null si aucun article n'a été trouvé avec l'id $id
  if($audio === null)
  {
    throw $this->createNotFoundException('Article[id='.$id.'] inexistant.');
  }
    
  return $this->render('ToubarefaneSiteBundle:Site:voirAudio.html.twig', array(
    'chemin'       => $chemin,
    'audio' => $audio
  ));
    
  
  }
  
  public function voirtousAction()
  {
    $chemin="Audio>> tous"; 
// On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio');

  // On récupère l'entité correspondant à l'id $id
  $images = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

    
  return $this->render('ToubarefaneSiteBundle:Site:tousaudio.html.twig', array(
      'chemin'       => $chemin,
    'audio' => $audios
  ));
    
  
  }
  
 public function voirkhassidaAction()
  {
    $chemin="Audio>> Kourel"; 
// On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio');

  // On récupère l'entité correspondant à l'id $id
  $audios = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

    
  return $this->render('ToubarefaneSiteBundle:Site:audiokhassida.html.twig', array(
      'chemin'       => $chemin,
    'audios' => $audios
  ));
    
  
  }
  
  public function audioradiasAction()
  {
    $chemin="Audio>> Radias"; 
// On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio');

  // On récupère l'entité correspondant à l'id $id
  $audios = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

    
  return $this->render('ToubarefaneSiteBundle:Site:audioRadias.html.twig', array(
      'chemin'       => $chemin,
    'audios' => $audios
  ));
    
  
  }
  public function audiosegnesamAction()
  {
    $chemin="Audio>> SegneSam"; 
// On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio');

  // On récupère l'entité correspondant à l'id $id
  $audios = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

    
  return $this->render('ToubarefaneSiteBundle:Site:audioSegnesam.html.twig', array(
      'chemin'       => $chemin,
    'audios' => $audios
  ));
    
  
  }
  public function audiocoranAction()
  {
    $chemin="Audio>> Coran"; 
// On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio');

  // On récupère l'entité correspondant à l'id $id
  $audios = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

    
  return $this->render('ToubarefaneSiteBundle:Site:audioCoran.html.twig', array(
      'chemin'       => $chemin,
    'audios' => $audios
  ));
    
  
  }
  public function audiowakhtaneAction()
  {
    $chemin="Audio>> Wakhtane"; 
// On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio');

  // On récupère l'entité correspondant à l'id $id
  $audios = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

    
  return $this->render('ToubarefaneSiteBundle:Site:audioWakhtane.html.twig', array(
      'chemin'       => $chemin,
    'audios' => $audios
  ));
    
  
  }
  public function supprimerAction(Article $article)
  {
    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'article contre cette faille
    $form = $this->createFormBuilder()->getForm();
    $chemin="Article>> supprimer";
    $request = $this->getRequest();
    if ($request->getMethod() == 'POST') {
      $form->bind($request);

      if ($form->isValid()) {
        // On supprime l'article
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', 'Article bien supprimé');

        // Puis on redirige vers l'accueil
        return $this->redirect($this->generateUrl('toubarefanesite_accueil'));
      }
    }

    // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
    return $this->render('ToubarefaneSiteBundle:Site:supprimer.html.twig', array(
      'article' => $article,
        'chemin'       => $chemin,
      'form'    => $form->createView()
    ));
  }

 

}