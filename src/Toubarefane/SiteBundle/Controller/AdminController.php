<?php

// src/Toubarefane/SiteBundle/Controller/SiteController.php

namespace Toubarefane\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RequestStack;
use Toubarefane\SiteBundle\Entity\Article;
use Toubarefane\SiteBundle\Entity\Video;
use Toubarefane\SiteBundle\Entity\Image;
use Toubarefane\SiteBundle\Entity\Audio;
use Toubarefane\SiteBundle\Entity\Review;
use Toubarefane\SiteBundle\Form\ArticleEditType;
use Toubarefane\SiteBundle\Form\YouArticleEditType;
use Toubarefane\SiteBundle\Form\ArticleType;
use Toubarefane\SiteBundle\Form\YouArticleType;
use Toubarefane\SiteBundle\Form\VideoType;
use Toubarefane\SiteBundle\Form\AudioType;
use Toubarefane\SiteBundle\Form\ImageType;
use Toubarefane\SiteBundle\Form\FormType;
use Toubarefane\SiteBundle\Services\FileUploader;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Validator\Constraints\File;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Kernel;
class AdminController extends Controller
{
    private $type="other";
    public function indexAction($page)
  {
    


    // Ici, on récupérera la liste des articles, puis on la passera au template
  // Les articles :
     // On récupère le repository
  $articles = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Article')
                     ->getArticles(3,$page);
  

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article
        // Ou null si aucun article n'a été trouvé avec l'id $id
        if ($articles === null) {
            throw $this->createNotFoundException('Article inexistant.');
        }
        $chemin = 'accueil>>';
        // Mais pour l'instant, on ne fait qu'appeler le template
        return $this->render('ToubarefaneSiteBundle:Admin:index.html.twig', array(
                    'articles' => $articles,
                    'chemin' => $chemin,
                    'page' => $page,
                    'nombrePage' => ceil(count($articles) / 3)
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
    $chemin="Article>> voir";
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
    
  return $this->render('ToubarefaneSiteBundle:Admin:voir.html.twig', array(
    'chemin'       => $chemin,
    'article' => $article
  ));
    
  
  }
  public function voirtousAction()
  {
    $chemin="Article>> voir"; 
// On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Article');

  // On récupère l'entité correspondant à l'id $id
  $article = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

    
  return $this->render('ToubarefaneSiteBundle:Admin:voirtous.html.twig', array(
      'chemin'       => $chemin,
    'articles' => $article
  ));
    
  
  }
  public function albumAction()
  {
    $chemin="Album>> voir"; 
// On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Album');

  // On récupère l'entité correspondant à l'id $id
  $album = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

    
  return $this->render('ToubarefaneSiteBundle:Admin:album.html.twig', array(
      'chemin'       => $chemin,
    'album' => $album
  ));
    
  
  }
  public function ajouterotherAction()
  {
   $this->type="other"; 
   return $this->articleAction();
  }
  public function ajouteryoutubeAction()
  {
   $this->type="youtube"; 
     return $this->articleAction();
  }
  public function modifierotherAction(Article $article)
  {
   $this->type="other"; 
   return $this->modifierAction($article);
  }
  public function modifieryoutubeAction(Article $article)
  {
   $this->type="youtube"; 
     return $this->modifierAction($article);
  }
  public function getOptionArticle()
  {
      
          return $this->type;
  }
  public function articleAction()
  {
     
    //$session=$this->getUser();
     $article = new Article();
    $chemin="Artcle>> ajouter";
    // On crée le formulaire grâce à l'ArticleType
    $form = $this->createForm( new ArticleType(), $article, array(
    'user' => $this->getUser(),'type' => $this->getOptionArticle(),
));

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
        $article->getFile()->upload();

  // Puis, le reste de la méthode, qu'on avait déjà fait
  $em = $this->getDoctrine()->getManager();
  $em->persist($article);
  $em->flush();

        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', 'Article bien ajouté');

        // On redirige vers la page de visualisation de l'article nouvellement créé
        return $this->redirect($this->generateUrl('toubarefaneadmin_voir', array('id' => $article->getId())));
      }
    }
    return $this->render('ToubarefaneSiteBundle:Admin:ajouter.html.twig',array('chemin'=> $chemin,'form' => $form->createView()));
  }
  
 public function modifierAction(Article $article)
  {
    // On utiliser le ArticleEditType
    $form = $this->createForm(new ArticleEditType(), $article,array(
    'user' => $this->getUser(),'type' => $this->getOptionArticle()));
    $chemin="Article>> modifier";
    $request = $this->getRequest();

    if ($request->getMethod() == 'POST') {
      $form->bind($request);

      if ($form->isValid()) {
        // On enregistre l'article
          $article->getFile()->upload();
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', 'Article bien modifié');

        return $this->redirect($this->generateUrl('toubarefaneadmin_voir', array('id' => $article->getId())));
      }
    }

    return $this->render('ToubarefaneSiteBundle:Admin:modifier.html.twig', array(
      'form'    => $form->createView(),
      'chemin'       => $chemin,
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
        return $this->redirect($this->generateUrl('toubarefaneadmin_voirtous'));
      }
    }

    // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
    return $this->render('ToubarefaneSiteBundle:Admin:supprimer.html.twig', array(
      'article' => $article,
        'chemin'       => $chemin,
      'form'    => $form->createView()
    ));
  }
  public function createAction()
{
    $entity = new Review();
   
     $form = $this->createForm(new FormType(),$entity);
//$form->children['file']->vars = array_replace($formView->children['file']->vars, array('full_name', 'form[file][]'));

    // On récupère la requête
    $request = $this->getRequest();
     $files=null;
     
     //EntityManager $em, RequestStack $requestStack, Validator $validator, Kernel $kernel
    
    
     $uploadFiles=null;
    // On vérifie qu'elle est de type POST
    if ($request->getMethod() == 'POST') {
      // On fait le lien Requête <-> Formulaire
      $form->bind($request);
    
    if ($form->isValid())
    {
       // Handle the uploaded images          
       $files = $form->getData()->getImages();
    }
    // If there are images uploaded           
    
        //die($files);
        $constraints = array('maxSize'=>'1M', 'mimeTypes' => array('image/*'));
        $uploadFiles = $this->container->get('toubarefane_site.fileuploader')->create($files, $constraints);
         
    if($uploadFiles->upload())
    {
        $entity->setImages($uploadFiles->getFilePaths());
    }
    // If there are file constraint validation issues
    else
    {
        // Check for errors
        foreach($uploadFiles->getErrors() as $error)
        {
            $this->get('session')->getFlashBag()->add('error', $error);
        }
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
// ... persist, flush, success message, redirect, other functionality
}
 $chemin="Photo>> ajouter";
return $this->render('ToubarefaneSiteBundle:Admin:review.html.twig',array('chemin'=> $chemin,'form' => $form->createView()));
 

}
//methode pour les photos
  public function ajouterphotoAction()
  {
     

     $image = new Image();
     $chemin="Photo>> ajouter";
    
    // On crée le formulaire grâce à l'ArticleType
    $form = $this->createForm(new ImageType(), $image);
//$form->children['file']->vars = array_replace($formView->children['file']->vars, array('full_name', 'form[file][]'));

    // On récupère la requête
    $request = $this->getRequest();

    // On vérifie qu'elle est de type POST
    if ($request->getMethod() == 'POST') {
      // On fait le lien Requête <-> Formulaire
      $form->bind($request);
   // $files = $form['file'];
   // die($files->getData()->getFileName());
    
           
      // On vérifie que les valeurs entrées sont correctes
      // (Nous verrons la validation des objets en détail dans le prochain chapitre)
      if ($form->isValid()) {
  // Ici : On traite manuellement le fichier uploadé
         
                foreach($files as $file)
                {
              $file->upload();
          
  // Puis, le reste de la méthode, qu'on avait déjà fait
  $em = $this->getDoctrine()->getManager();
  $em->persist($file);
  $em->flush();
                }
        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', 'image bien ajouté');

        // On redirige vers la page de visualisation de l'article nouvellement créé
        return $this->redirect($this->generateUrl('toubarefaneadmin_ajouterphoto'));
      }
    }
    return $this->render('ToubarefaneSiteBundle:Admin:photo.html.twig',array('chemin'=> $chemin,'form' => $form->createView()));
  }
  
public function voirphotoAction($id)
  {
    $chemin="Photo>> Voir";
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
    
  return $this->render('ToubarefaneSiteBundle:Admin:voirPhoto.html.twig', array(
    'chemin'       => $chemin,
    'image' => $image
  ));
    
  
  }
  public function tousphotoAction()
  {
    $chemin="Photo>> Tous"; 
// On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Image');

  // On récupère l'entité correspondant à l'id $id
  $images = $repository->findAll();

  // $article est donc une instance de Sdz\BlogBundle\Entity\Article

    
  return $this->render('ToubarefaneSiteBundle:Admin:tousphoto.html.twig', array(
      'chemin'       => $chemin,
    'images' => $images
  ));
 
  }
  
  public function supprimerphotoAction(Image $photo)
  {
    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'un video contre cette faille
    $form = $this->createFormBuilder()->getForm();
    $chemin="Photo>> Supprimer";
    $request = $this->getRequest();
    if ($request->getMethod() == 'POST') {
      $form->bind($request);

      if ($form->isValid()) {
        // On supprime l'audio
        $em = $this->getDoctrine()->getManager();
        $em->remove($photo);
        $em->flush();

        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', 'Photo bien supprimé');

        // Puis on redirige vers l'accueil
        return $this->redirect($this->generateUrl('toubarefaneadmin_tousphoto'));
      }
    }

    // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
    return $this->render('ToubarefaneSiteBundle:Admin:supprimerphoto.html.twig', array(
      'photo' => $photo,
        'chemin'       => $chemin,
      'form'    => $form->createView()
    ));
  }
  
  //methode pour les audios
  
  public function ajouteraudioAction()
  {
     

     $audio = new Audio();
     $chemin="Audio>> ajouter";
     $message="";
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
        $this->get('session')->getFlashBag()->add('info', 'audio bien ajouté'+$audio->getAlt());
       $message="audio bien ajouté";
        // On redirige vers la page de visualisation de l'article nouvellement créé
        return $this->redirect($this->generateUrl('toubarefaneadmin_ajouteraudio',array('message'=> $message)));
      }
    }
    return $this->render('ToubarefaneSiteBundle:Admin:audio.html.twig',array('chemin'=> $chemin,'message'=> $message,'form' => $form->createView()));
  }
 
  public function voiraudioAction($id)
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
    
  return $this->render('ToubarefaneSiteBundle:Admin:voirAudio.html.twig', array(
    'chemin'       => $chemin,
    'audio' => $audio
  ));
    
  
  }
  
  public function tousaudioAction()
  {
    $chemin="Audio>> Tous"; 
// On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Audio');

  // On récupère les etité corresponant à Audio
  $audios = $repository->findAll();

  //retourne tous les audios
  return $this->render('ToubarefaneSiteBundle:Admin:tousaudio.html.twig', array(
      'chemin'       => $chemin,
    'audio' => $audios
  ));
    
  
  }
  
  public function supprimeraudioAction(Audio $audio)
  {
    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'un video contre cette faille
    $form = $this->createFormBuilder()->getForm();
    $chemin="Audio>> Supprimer";
    $request = $this->getRequest();
    if ($request->getMethod() == 'POST') {
      $form->bind($request);

      if ($form->isValid()) {
        // On supprime l'audio
        $em = $this->getDoctrine()->getManager();
        $em->remove($audio);
        $em->flush();

        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', 'Audio bien supprimé ');

        // Puis on redirige vers l'accueil
        return $this->redirect($this->generateUrl('toubarefaneadmin_tousaudio'));
      }
    }

    // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
    return $this->render('ToubarefaneSiteBundle:Admin:supprimeraudio.html.twig', array(
      'audio' => $audio,
        'chemin'       => $chemin,
      'form'    => $form->createView()
    ));
  }

 public function modifieraudioAction(Audio $audio)
  {
    // On utiliser le VideoEditType
    $form = $this->createForm(new AudioType(), $audio);
    $chemin="Video>> Modifier";
    $request = $this->getRequest();

    if ($request->getMethod() == 'POST') {
      $form->bind($request);

      if ($form->isValid()) {
        // On enregistre l'video
        $em = $this->getDoctrine()->getManager();
        $em->persist($audio);
        $em->flush();

        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', 'Audio bien modifié');

        return $this->redirect($this->generateUrl('toubarefaneadmin_tousaudio'));
      }
    }

    return $this->render('ToubarefaneSiteBundle:Admin:modifieraudio.html.twig', array(
      'form'    => $form->createView(),
      'chemin'       => $chemin,
    ));
  }

  
  
  //methodes pour les videos
  public function ajoutervideoAction()
  {
     

     $video = new Video();
     $chemin="Video>> ajouter";
    // On crée le formulaire grâce à l'VideoType
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

        // On redirige vers la page de visualisation de l'video nouvellement créé
        return $this->redirect($this->generateUrl('toubarefaneadmin_ajoutervideo'));
      }
    }
    return $this->render('ToubarefaneSiteBundle:Admin:video.html.twig',array('chemin'=> $chemin,'form' => $form->createView()));
  }
  public function voirtousvideoAction()
  {
    $chemin="Video>> tous"; 
// On récupère le repository
  $repository = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('ToubarefaneSiteBundle:Video');

  // On récupère l'entité correspondant à l'id $id
  $videos = $repository->findAll();

  // $video est donc une instance de Sdz\BlogBundle\Entity\Video

    
  return $this->render('ToubarefaneSiteBundle:Admin:voirtousvideo.html.twig', array(
      'chemin'       => $chemin,
    'videos' => $videos
  ));
    
  
  }
  
 
  public function supprimervideoAction(Video $video)
  {
    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'video contre cette faille
    $form = $this->createFormBuilder()->getForm();
    $chemin="Video>> supprimer";
    $request = $this->getRequest();
    if ($request->getMethod() == 'POST') {
      $form->bind($request);

      if ($form->isValid()) {
        // On supprime l'video
        $em = $this->getDoctrine()->getManager();
        $em->remove($video);
        $em->flush();

        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', 'Video bien supprimé');

        // Puis on redirige vers l'accueil
        return $this->redirect($this->generateUrl('toubarefaneadmin_tousvideo'));
      }
    }

    // Si la requête est en GET, on affiche une page de confirmation avant de supprimer
    return $this->render('ToubarefaneSiteBundle:Admin:supprimervideo.html.twig', array(
      'video' => $video,
        'chemin'       => $chemin,
      'form'    => $form->createView()
    ));
  }

 public function modifiervideoAction(Video $video)
  {
    // On utiliser le VideoEditType
    $form = $this->createForm(new VideoType(), $video);
    $chemin="Video>> modifier";
    $request = $this->getRequest();

    if ($request->getMethod() == 'POST') {
      $form->bind($request);

      if ($form->isValid()) {
        // On enregistre l'video
        $em = $this->getDoctrine()->getManager();
        $em->persist($video);
        $em->flush();

        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', 'Video bien modifié');

        return $this->redirect($this->generateUrl('toubarefaneadmin_tousvideo'));
      }
    }

    return $this->render('ToubarefaneSiteBundle:Admin:modifiervideo.html.twig', array(
      'form'    => $form->createView(),
      'chemin'       => $chemin,
    ));
  }

  
  //graphe admin
  public function flotAction()
  {
   $chemin="Graphe>>Flot"; 
    
  return $this->render('ToubarefaneSiteBundle:Admin:flot.html.twig', array(
    'chemin' => $chemin
  ));
    
  
  }
  public function morrisAction()
  {
    
    $chemin="Graphe>>Morris"; 
  return $this->render('ToubarefaneSiteBundle:Admin:morris.html.twig', array(
    'chemin' => $chemin
  ));
    
  
  }
  public function tableAction()
  {
   $chemin="Graphe>>Table";  
    
  return $this->render('ToubarefaneSiteBundle:Admin:table.html.twig', array(
    'chemin' => $chemin
  ));
    
  
  }
  
  
  
  
  
  
  
  
  
  
  
  
  // On modifie voirAction, car elle existe déjà
  public function sendMailAction($pseudo){
    $mailer = $this->get('mailer');
$contenu = $this->renderView('ToubarefaneSiteBundle:Admin:email.txt.twig', array(
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
    
    
  return $this->render('ToubarefaneSiteBundle:Admin:index.html.twig', array(
    'image' => $image
  ));
    
  
  }
   public function contactAction()
    {
        $form = $this->get('form.factory')->create(new ContactType());

         // Get the request
        $request = $this->get('request');
    $message=null;
    $chemin="Contact>>";
        // Check the method
        if ($request->getMethod() == 'POST')
        {
            // Bind value with form
            $form->bind($request);

            $data = $form->getData();

            $message = \Swift_Message::newInstance()
                ->setContentType('text/html')
                ->setSubject($data['sujet'])
                ->setFrom($data['email'])
                ->setTo('diopref@gmail.com')
                ->setBody($data['contenu']);

            $this->get('mailer')->send($message);
            $message='Merci de nous avoir contacté, nous répondrons à vos questions dans les plus brefs délais.';
            // Launch the message flash
            $this->get('session')->getFlashBag()->add('notice', 'Merci de nous avoir contacté, nous répondrons à vos questions dans les plus brefs délais.');
            return $this->render('ToubarefaneSiteBundle:Admin:contact.html.twig',
                array(
                    'form' => $form->createView(),
                    'chemin'       => $chemin,
                    'message'=> $message
                ));
        }

        return $this->render('ToubarefaneSiteBundle:Admin:contact.html.twig',
                array(
                    'form' => $form->createView(),
                    'chemin'       => $chemin,
                    'message'=> $message
                ));

    }


}