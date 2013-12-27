<?php

// src/Toubarefane/SiteBundle/Controller/SiteController.php

namespace Toubarefane\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SiteController extends Controller
{
  public function indexAction()
  {
    

    // Ici, on récupérera la liste des articles, puis on la passera au template
  // Les articles :
  $articles = array(
    array(
      'titre'   => 'Mon weekend a Phi Phi Island !',
      'id'      => 1,
      'auteur'  => 'winzou',
      'contenu' => 'Ce weekend était trop bien. Blabla…',
      'date'    => new \Datetime()),
    array(
      'titre'   => 'Repetition du National Day de Singapour',
      'id'      => 2,
      'auteur' => 'winzou',
      'contenu' => 'Bientôt prêt pour le jour J. Blabla…',
      'date'    => new \Datetime()),
    array(
      'titre'   => 'Chiffre d\'affaire en hausse',
      'id'      => 3, 
      'auteur' => 'M@teo21',
      'contenu' => '+500% sur 1 an, fabuleux. Blabla…',
      'date'    => new \Datetime())
  );
    // Mais pour l'instant, on ne fait qu'appeler le template
    return $this->render('ToubarefaneSiteBundle:Site:index.html.twig', array(
    'articles' => $articles
  ));

  }
  
  public function menuAction($nombre) // Ici, nouvel argument $nombre, on l'a transmis via le render() depuis la vue
  {
    // On fixe en dur une liste ici, bien entendu par la suite on la récupérera depuis la BDD !
    // On pourra récupérer $nombre articles depuis la BDD,
    // avec $nombre un paramètre qu'on peut changer lorsqu'on appelle cette action
    $liste = array(
      array('id' => 2, 'titre' => 'Mon dernier weekend !'),
      array('id' => 5, 'titre' => 'Sortie de Symfony2.1'),
      array('id' => 9, 'titre' => 'Petit test')
    );
    
    return $this->render('ToubarefaneSiteBundle:Site:menu.html.twig', array(
      'liste_articles' => $liste // C'est ici tout l'intérêt : le contrôleur passe les variables nécessaires au template !
    ));
  }
  public function voirAction($id)
  {
    $article = array(
    'id'      => 1,
    'titre'   => 'Mon weekend a Phi Phi Island !',
    'auteur'  => 'winzou',
    'contenu' => 'Ce weekend était trop bien. Blabla…',
    'date'    => new \Datetime()
  );
    
  // Puis modifiez la ligne du render comme ceci, pour prendre en compte l'article :
  
    return $this->render('ToubarefaneSiteBundle:Site:voir.html.twig', array(
      'article' => $article
    ));
  }
  
  public function ajouterAction()
  {
    // La gestion d'un formulaire est particulière, mais l'idée est la suivante :
    
    if( $this->get('request')->getMethod() == 'POST' )
    {
      // Ici, on s'occupera de la création et de la gestion du formulaire
      
      $this->get('session')->getFlashBag()->add('notice', 'Article bien enregistré');
    
      // Puis on redirige vers la page de visualisation de cet article
      return $this->redirect( $this->generateUrl('sdzblog_voir', array('id' => 5)) );
    }

    // Si on n'est pas en POST, alors on affiche le formulaire
    return $this->render('ToubarefaneSiteBundle:Site:ajouter.html.twig');
  }
  
  public function modifierAction($id)
  {
    // Ici, on récupérera l'article correspondant à $id

    // Ici, on s'occupera de la création et de la gestion du formulaire

    $article = array(
      'id'      => 1,
      'titre'   => 'Mon weekend a Phi Phi Island !',
      'auteur'  => 'winzou',
      'contenu' => 'Ce weekend était trop bien. Blabla…',
      'date'    => new \Datetime()
    );
        
    // Puis modifiez la ligne du render comme ceci, pour prendre en compte l'article :

    return $this->render('ToubarefaneSiteBundle:Site:modifier.html.twig',array('article'=>$article));
  }

  public function supprimerAction($id)
  {
    // Ici, on récupérera l'article correspondant à $id

    // Ici, on gérera la suppression de l'article en question

    return $this->render('ToubarefaneSiteBundle:Site:supprimer.html.twig');
  }

  // On modifie voirAction, car elle existe déjà
  public function sendMailAction($pseudo){
    $mailer = $this->get('mailer');
$contenu = $this->renderView('ToubarefaneSiteBundle:Site:email.txt.twig', array(
  'pseudo' => $pseudo
));

// Puis on envoie l'e-mail, par exemple :
//mail('refane@live.fr', 'Inscription OK', $contenu);
    // Création de l'e-mail : le service mailer utilise SwiftMailer, donc nous créons une instance de Swift_Message
    $message = \Swift_Message::newInstance()
      ->setSubject('Inscription')
      ->setFrom('toubarefane@gmail.com')
      ->setTo('refane@live.fr')
      ->setBody($contenu);

    // Retour au service mailer, nous utilisons sa méthode « send() » pour envoyer notre $message
    $mailer->send($message);

    // N'oublions pas de retourner une réponse, par exemple une page qui afficherait « L'e-mail a bien été envoyé »
    return new Response('Email bien envoyé');
  }

// Ajoutez cette méthode ajouterAction :
  


}