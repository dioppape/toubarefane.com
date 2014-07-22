<?php

// src/Toubarefane/SiteBundle/Controller/VideoController.php

namespace Toubarefane\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Toubarefane\SiteBundle\Entity\Video;
use Toubarefane\SiteBundle\Form\VideoType;

class VideoController extends Controller
{
   
  public function ajouterAction()
  {
     

     $video = new Video();
     $chemin="Video>> ajouter";
    // On crée le formulaire grâce à l'ArticleType
    $form = $this->createForm(new VideoType(), $video);

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
 // $video->upload();

  // Puis, le reste de la méthode, qu'on avait déjà fait
  $em = $this->getDoctrine()->getManager();
  $em->persist($video);
  $em->flush();

        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', 'image bien ajouté');

        // On redirige vers la page de visualisation de l'article nouvellement créé
        return $this->redirect($this->generateUrl('toubarefanevideo_ajouter'));
      }
    }
    return $this->render('ToubarefaneSiteBundle:Admin:video.html.twig',array('chemin'=> $chemin,'form' => $form->createView()));
  }
 
  public function voirAction($id)
  {
    $chemin="Video>> voir";
      // On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Video');

  // On récupère l'entité correspondant à l'id $id
  $video = $repository->find($id);

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

  // Ou null si aucun article n'a été trouvé avec l'id $id
  if($video === null)
  {
    throw $this->createNotFoundException('Article[id='.$id.'] inexistant.');
  }
    
  return $this->render('ToubarefaneSiteBundle:Site:voirVideo.html.twig', array(
    'chemin'       => $chemin,
    'video' => $video
  ));
    
  
  }
  public function voirtousAction()
  {
    $chemin="Video>> tous"; 
// On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Video');

  // On récupère l'entité correspondant à l'id $id
  $videos = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

    
  return $this->render('ToubarefaneSiteBundle:Site:video.html.twig', array(
      'chemin'       => $chemin,
    'videos' => $videos
  ));
    
  
  }
  
 public function voirkhassidaAction()
  {
    $chemin="Video>> Khasssida"; 
// On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Video');

  // On récupère l'entité correspondant à l'id $id
  $videos = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

    
  return $this->render('ToubarefaneSiteBundle:Site:videokhassida.html.twig', array(
      'chemin'       => $chemin,
    'videos' => $videos
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