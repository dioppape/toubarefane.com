<?php

// src/Toubarefane/SiteBundle/Controller/SiteController.php

namespace Toubarefane\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Toubarefane\SiteBundle\Entity\Article;
class SiteController extends Controller
{
  public function indexAction()
  {
     // On récupère le service
    $antispam = $this->container->get('toubarefane_site.antispam');
$text='http://tb.com refane@live.fr ';
    // Je pars du principe que $text contient le texte d'un message quelconque
    if ($antispam->isSpam($text)) {
      throw new \Exception('Votre message a été détecté comme spam !');
    }


    // Ici, on récupérera la liste des articles, puis on la passera au template
  // Les articles :
     // On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Article');

  // On récupère l'entité correspondant à l'id $id
  $articles = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

  // Ou null si aucun article n'a été trouvé avec l'id $id
  if($articles === null)
  {
    throw $this->createNotFoundException('Article[id='.$id.'] inexistant.');
  }
    
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
     // On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Article');

  // On récupère l'entité correspondant à l'id $id
  $article = $repository->find($id);

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

  // Ou null si aucun article n'a été trouvé avec l'id $id
  if($article === null)
  {
    throw $this->createNotFoundException('Article[id='.$id.'] inexistant.');
  }
    
  return $this->render('ToubarefaneSiteBundle:Site:voir.html.twig', array(
    'article' => $article
  ));
    
  
  }
  
  public function ajouterAction()
  {
    // La gestion d'un formulaire est particulière, mais l'idée est la suivante :
    // Création de l'entité
    $article = new Article();
    $article->setTitre('Mon dernier weekend');
    $article->setAuteur('Pape Diop');
    $article->setContenu("C'était vraiment super et on s'est bien amusé.");
    // On peut ne pas définir ni la date ni la publication,
    // car ces attributs sont définis automatiquement dans le constructeur

    // On récupère l'EntityManager
    $em = $this->getDoctrine()->getManager();

    // Étape 1 : On « persiste » l'entité
    $em->persist($article);

    // Étape 2 : On « flush » tout ce qui a été persisté avant
    $em->flush();
    
    // Reste de la méthode qu'on avait déjà écrit
    if ($this->getRequest()->getMethod() == 'POST') {
      $this->get('session')->getFlashBag()->add('info', 'Article bien enregistré');
      return $this->redirect( $this->generateUrl('toubarefanesite_voir', array('id' => $article->getId())) );
    }

    return $this->render('ToubarefaneSiteBundle:Site:ajouter.html.twig',array('article'=>$article));
  }
  
  public function modifierAction($id)
  {
    // Ici, on récupérera l'article correspondant à $id

    // Ici, on s'occupera de la création et de la gestion du formulaire
// On récupère l'EntityManager
    $em = $this->getDoctrine()->getManager();
 $article2 = $em->getRepository('ToubarefaneSiteBundle:Article')->find(2);
 $article2->setAuteur('Pape Diop');
  $em->flush();      
    // Puis modifiez la ligne du render comme ceci, pour prendre en compte l'article :

    return $this->render('ToubarefaneSiteBundle:Site:modifier.html.twig',array('article'=>$article2));
  }

  public function supprimerAction($id)
  {
    // Ici, on récupérera l'article correspondant à $id
//On récupère l'EntityManager
    $em = $this->getDoctrine()->getManager();
 $article = $em->getRepository('ToubarefaneSiteBundle:Article')->find($id);
 $em->remove($article);
 $em->flush();
    return $this->indexAction();
    //return $this->render('ToubarefaneSiteBundle:Site:index.html.twig',array('articles'=>$article));
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