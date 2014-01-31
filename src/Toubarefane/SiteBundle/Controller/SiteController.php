<?php

// src/Toubarefane/SiteBundle/Controller/SiteController.php

namespace Toubarefane\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Toubarefane\SiteBundle\Entity\Article;
use Toubarefane\SiteBundle\Form\ImageType;
use Toubarefane\SiteBundle\Form\ArticleType;
use Toubarefane\SiteBundle\Form\ArticleEditType;
use Toubarefane\SiteBundle\Form\CategorieType;
class SiteController extends Controller
{
  public function indexAction($page)
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
  $articles = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Article')
                     ->getArticles(3,$page);
  

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

  // Ou null si aucun article n'a été trouvé avec l'id $id
  if($articles === null)
  {
    throw $this->createNotFoundException('Article inexistant.');
  }
    
    // Mais pour l'instant, on ne fait qu'appeler le template
    return $this->render('ToubarefaneSiteBundle:Site:index.html.twig', array(
    'articles' => $articles,
      'page'       => $page,
      'nombrePage' => ceil(count($articles)/3)

  ));

  }
  
  public function menuAction($nombre) // Ici, nouvel argument $nombre, on l'a transmis via le render() depuis la vue
  {
    // On fixe en dur une liste ici, bien entendu par la suite on la récupérera depuis la BDD !
    // On pourra récupérer $nombre articles depuis la BDD,
    // avec $nombre un paramètre qu'on peut changer lorsqu'on appelle cette action
    $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Article');

  // On récupère l'entité correspondant à l'id $id
  $liste = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

  // Ou null si aucun article n'a été trouvé avec l'id $id
  if($liste === null)
  {
    throw $this->createNotFoundException('Article[id='.$id.'] inexistant.');
  }
    
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
     $article = new Article;

    // On crée le formulaire grâce à l'ArticleType
    $form = $this->createForm(new ArticleType(), $article);

    // On récupère la requête
    $request = $this->getRequest();

    // On vérifie qu'elle est de type POST
    if ($request->getMethod() == 'POST') {
      // On fait le lien Requête <-> Formulaire
      $form->bind($request);

      // On vérifie que les valeurs entrées sont correctes
      // (Nous verrons la validation des objets en détail dans le prochain chapitre)
      if ($form->isValid()) {
        // On enregistre notre objet $article dans la base de données
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', 'Article bien ajouté');

        // On redirige vers la page de visualisation de l'article nouvellement créé
        return $this->redirect($this->generateUrl('toubarefanesite_voir', array('id' => $article->getId())));
      }
    }
    return $this->render('ToubarefaneSiteBundle:Site:ajouter.html.twig',array('form' => $form->createView()));
  }
  
 public function modifierAction(Article $article)
  {
    // On utiliser le ArticleEditType
    $form = $this->createForm(new ArticleEditType(), $article);

    $request = $this->getRequest();

    if ($request->getMethod() == 'POST') {
      $form->bind($request);

      if ($form->isValid()) {
        // On enregistre l'article
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', 'Article bien modifié');

        return $this->redirect($this->generateUrl('toubarefanesite_voir', array('id' => $article->getId())));
      }
    }

    return $this->render('ToubarefaneSiteBundle:Site:modifier.html.twig', array(
      'form'    => $form->createView(),
      
    ));
  }

  public function supprimerAction(Article $article)
  {
    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'article contre cette faille
    $form = $this->createFormBuilder()->getForm();

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
      'form'    => $form->createView()
    ));
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
  
public function headAction()
  {
    
   $image=array('url'=>'http://uploads.siteduzero.com/icones/478001_479000/478657.png');
  return $this->render('::layout.html.twig', array(
    'image' => $image
  ));
    
  
  }
public function footAction()
  {
    
    
  return $this->render('ToubarefaneSiteBundle:Site:index.html.twig', array(
    'image' => $image
  ));
    
  
  }
}