<?php

// src/Toubarefane/SiteBundle/Controller/SiteController.php

namespace Toubarefane\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Toubarefane\SiteBundle\Entity\Image;
use Toubarefane\SiteBundle\Form\ImageType;

class PhotoController extends Controller
{
  public function ajouterAction()
  {
     

     $image = new Image();
     $chemin="Photo>> ajouter";
    // On crée le formulaire grâce à l'ArticleType
    $form = $this->createForm(new ImageType(), $image);

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
  $image->upload();

  // Puis, le reste de la méthode, qu'on avait déjà fait
  $em = $this->getDoctrine()->getManager();
  $em->persist($image);
  $em->flush();

        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', 'image bien ajouté');

        // On redirige vers la page de visualisation de l'article nouvellement créé
        return $this->redirect($this->generateUrl('toubarefanephoto_voir', array('id' => $image->getId())));
      }
    }
    return $this->render('ToubarefaneSiteBundle:Admin:photo.html.twig',array('chemin'=> $chemin,'form' => $form->createView()));
  }
  
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
  public function voirtousAction()
  {
    $chemin="Photo>> tous"; 
// On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Image');

  // On récupère l'entité correspondant à l'id $id
  $images = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

    
  return $this->render('ToubarefaneSiteBundle:Site:tousphoto.html.twig', array(
      'chemin'       => $chemin,
    'images' => $images
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
    return $this->render('ToubarefaneSiteBundle:Admin:supprimer.html.twig', array(
      'article' => $article,
        'chemin'       => $chemin,
      'form'    => $form->createView()
    ));
  }

 

}