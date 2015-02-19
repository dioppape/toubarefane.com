<?php

//3fc3b92681f5ac57df463a0a9ff89f31a68c5e90
// src/Toubarefane/SiteBundle/Controller/SiteController.php

namespace Toubarefane\SiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Toubarefane\SiteBundle\Form\ContactType;

class SiteController extends Controller {
    /* http://symfony.com/fr/doc/current/cookbook/security/voters.html
     * https://github.com/valllabh/jquery.currency.converter
     * http://finance.yahoo.com/currency-converter/
     * http://stackoverflow.com/questions/3139879/how-do-i-get-currency-exchange-rates-via-an-api-such-as-google-finance
     * http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%22USDEUR%22,%20%22USDISK%22)&env=store://datatables.org/alltableswithkeys
     * http://query.yahooapis.com/v1/public/yql?q=select * from yahoo.finance.xchange where pair in ("USDEUR", "USDISK")&env=store://datatables.org/alltableswithkeys */

    public function indexAction($page) {

        $nbParPage = $this->container->getParameter('tbrsite.nombre_par_page');
// Les articles :
        // On récupère le repository
        $articles = $this->getDoctrine()
                ->getManager()
                ->getRepository('ToubarefaneSiteBundle:Article')
                ->getArticles($nbParPage, $page);
        $response = new Response();
        //$response->$this->getRequest()->getClientIp();
        $ip = $this->getRequest()->getClientIp();
        // $article est donc une instance de Toubarefane\SiteBundle\Entity\Article
        // Ou null si aucun article n'a été trouvé avec l'id $id
        if ($articles === null) {
            throw $this->createNotFoundException('Article inexistant.');
        }
        $chemin = 'Accueil>>';
        // Mais pour l'instant, on ne fait qu'appeler le template
        return $this->render('ToubarefaneSiteBundle:Site:index.html.twig', array(
                    'articles' => $articles,
                    'autrevideo' => SiteController::getVideo(),
                    'ipclient' => $ip,
                    'chemin' => $chemin,
                    'page' => $page,
                    'nb_page' => ceil(count($articles) / $nbParPage) ? : 1
        ));
    }

    public function getVideo() {
        $video = $this->getDoctrine()
                ->getManager()
                ->getRepository('ToubarefaneSiteBundle:Video')
                ->getVideos();
        if ($video === null) {
            throw $this->createNotFoundException('Video[id] inexistant.');
        }
        return $video;
    }

    public function recherchearticleAction() {
        //$form = $this->container->get('form.factory')->create(new ArticleRechercheType());
        $chemin = "Article>> Rechercher";

        $article = null;
        // On récupère la requête
        $request = $this->getRequest();

        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {
            $motcle = $request->request->get('motcle');

            $article = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('ToubarefaneSiteBundle:Article')
                    ->getArticle($motcle);


            $video = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('ToubarefaneSiteBundle:Video')
                    ->getVideo($motcle);

        }
        return $this->render('ToubarefaneSiteBundle:Site:recherche.html.twig', array(
                    'videos' => $video,
                    'articles' => $article,
                    'chemin' => $chemin
        ));
    }

    public function rechercheajaxAction() {
        $titres = array();

        $request = $this->container->get('request');

        if ($request->isXmlHttpRequest()) {
            $video = array();
            $article = array();
            $audio = array();
            $dol = array();
            $photo = array();

            $critere = $request->request->get('critere');
            $motcle = $request->request->get('motcle');

            if ($critere == "article" || $critere == "tous") {
                $article = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('ToubarefaneSiteBundle:Article')
                        ->getArticle($motcle);
            }
            if ($critere == "video" || $critere == "tous") {
                $video = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('ToubarefaneSiteBundle:Video')
                        ->getVideo($motcle);
            }

            if ($critere == "audio" || $critere == "tous") {
                $audio = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('ToubarefaneSiteBundle:Audio')
                        ->getAudio($motcle);
            }
            if ($critere == "dol" || $critere == "tous") {
                $dol = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('ToubarefaneSiteBundle:Image')
                        ->getDol($motcle);
            }
            if ($critere == "photo" || $critere == "tous") {
                $photo = $this->getDoctrine()
                        ->getManager()
                        ->getRepository('ToubarefaneSiteBundle:Image')
                        ->getImage($motcle);
            }


            foreach ($article as $ar) {
                $titres [$ar->getId()] = $ar->getTitre();
            }


            foreach ($video as $v) {
                $titres [$v->getId() . 'v'] = $v->getName();
            }



            foreach ($dol as $d) {
                $titres [$d->getId() . 'd'] = $d->getUrl();
            }
            foreach ($photo as $p) {
                $titres [$p->getId() . 'p'] = $p->getUrl();
            }

            foreach ($audio as $a) {
                $titres [$a->getId() . 'a'] = $a->getUrl();
            }

            $reponse = new JsonResponse();
            //$reponse->setContent($audio);
            // var_dump($reponse->setData($audio));
            //   die();
            return $reponse->setData($titres);
        } else {
            throw new \Exception("ereeur");
        }
    }

    public function rechercheajax2Action() {
        $request = $this->container->get('request');
        //$request = $this->getRequest();
        $article = null;
        if ($request->isXmlHttpRequest()) {
            $em = $this->container->get('doctrine')->getEntityManager();

            $motcle = '';
            $motcle = $request->request->get('motcle');

            if ($motcle != '') {
                $qb = $em->createQueryBuilder();

                $qb->select('a')
                        ->from('ToubarefaneSiteBundle:Article', 'a')
                        ->where("a.contenu LIKE :motcle OR a.titre LIKE :motcle")
                        ->orderBy('a.titre', 'ASC')
                        ->setParameter('motcle', '%' . $motcle . '%');

                $query = $qb->getQuery();
                $article = $query->getResult();
                //var_dump($article);
                $articles = array();
                foreach ($article as $ar) {
                    $articles [] = $ar->getTitre();
                }
            }
            $reponse = new JsonResponse();
            return $reponse->setData(array('article' => $articles));
        } else {
            throw new \Exception("ereeur");
        }
    }

    public function voirAction($id) {
        $chemin = "Article>> voir";
        // On récupère le repository
        $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('ToubarefaneSiteBundle:Article');

        // On récupère l'entité correspondant à l'id $id
        $article = $repository->find($id);

        // $article est donc une instance de Toubarefane\SiteBundle\Entity\Article
        // Ou null si aucun article n'a été trouvé avec l'id $id
        if ($article === null) {
            throw $this->createNotFoundException('Article[id=' . $id . '] inexistant.');
        }

        return $this->render('ToubarefaneSiteBundle:Site:voir.html.twig', array(
                    'chemin' => $chemin,
                    'article' => $article
        ));
    }

    public function voirtousAction() {
        $chemin = "Article>> Tous";
// On récupère le repository
        $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('ToubarefaneSiteBundle:Article');

        // On récupère l'entité correspondant à l'id $id
        $article = $repository->findAll();

        // $article est donc une instance de BlogBundle\ToubarefaneSiteBundle\Entity\Article


        return $this->render('ToubarefaneSiteBundle:Site:article.html.twig', array(
                    'chemin' => $chemin,
                    'articles' => $article,
                    'autrevideo' => SiteController::getVideo()
        ));
    }

    public function magalAction() {
        $chemin = "Article>> Magal";
// On récupère le repository
        $article = $this->getDoctrine()
                ->getManager()
                ->getRepository('ToubarefaneSiteBundle:Article')
                ->getMagal();

      
        return $this->render('ToubarefaneSiteBundle:Site:article.html.twig', array(
                    'chemin' => $chemin,
                    'autrevideo' => SiteController::getVideo(),
                    'articles' => $article
        ));
    }

    public function almouridiyaAction() {
        $chemin = "Article>> Almouridiya";
// On récupère le repository
        $article = $this->getDoctrine()
                ->getManager()
                ->getRepository('ToubarefaneSiteBundle:Article')
                ->getAlmouridiya();

        // On récupère l'entité correspondant à l'id $id
        // $article = $repository->findAll();
        // $article est donc une instance de Toubarefane\SiteBundleEntity\Article


        return $this->render('ToubarefaneSiteBundle:Site:article.html.twig', array(
                    'chemin' => $chemin,
                    'autrevideo' => SiteController::getVideo(),
                    'articles' => $article
        ));
    }

    public function albumAction() {
        $chemin = "Album>> voir";
// On récupère le repository
        $repository = $this->getDoctrine()
                ->getManager()
                ->getRepository('ToubarefaneSiteBundle:Album');

        // On récupère l'entité correspondant à l'id $id
        $album = $repository->findAll();

        // $article est donc une instance de Toubarefane\SiteBundle\Entity\Article


        return $this->render('ToubarefaneSiteBundle:Site:album.html.twig', array(
                    'chemin' => $chemin,
                    'album' => $album
        ));
    }

    // On modifie voirAction, car elle existe déjà
    public function sendMailAction($pseudo) {
        $mailer = $this->get('mailer');
        $contenu = $this->renderView('ToubarefaneSiteBundle:Site:email.txt.twig', array(
            'pseudo' => $pseudo
        ));
// $nbParPage = $this->container->getParameter('tbrsite.nombre_par_page');
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


    public function contactAction() {
        $form = $this->get('form.factory')->create(new ContactType());

        // Get the request
        $request = $this->get('request');
        $message = null;
        $monmail = $this->container->getParameter('mailer_user');
        $chemin = "Contact>>";
        // Check the method
        if ($request->getMethod() == 'POST') {
            // Bind value with form
            $form->bind($request);

            $data = $form->getData();

            $message = \Swift_Message::newInstance()
                    ->setContentType('text/html')
                    ->setSubject($data['sujet'])
                    ->setFrom($data['email'])
                    ->setTo($monmail)
                    ->setBody($data['contenu']);

            $this->get('mailer')->send($message);
            $message = 'Merci de nous avoir contacté, nous répondrons à vos questions dans les plus brefs délais.';
            // Launch the message flash
            $this->get('session')->getFlashBag()->add('notice', 'Merci de nous avoir contacté, nous répondrons à vos questions dans les plus brefs délais.');
            return $this->render('ToubarefaneSiteBundle:Site:contact.html.twig', array(
                        'form' => $form->createView(),
                        'chemin' => $chemin,
                        'message' => $message
            ));
        }

        return $this->render('ToubarefaneSiteBundle:Site:contact.html.twig', array(
                    'form' => $form->createView(),
                    'chemin' => $chemin,
                    'message' => $message
        ));
    }

}
