<?php

namespace Toubarefane\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository
{
  // On ajoute deux arguments : le nombre d'articles par page, ainsi que la page courante
  public function getUser()
  {
    // On déplace la vérification du numéro de page dans cette méthode
   
    // La construction de la requête reste inchangée
    $query = $this->createQueryBuilder('u')
                  ->leftJoin('u.image', 'i')
                    ->addSelect('i')
                  ->getQuery();

   return $query;
  }
}