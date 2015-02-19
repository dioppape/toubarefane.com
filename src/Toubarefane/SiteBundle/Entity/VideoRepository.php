<?php

namespace Toubarefane\SiteBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * VideoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VideoRepository extends EntityRepository
{
    public function getVideos(){
        $dql = "SELECT b FROM ToubarefaneSiteBundle:Video b ORDER BY b.id DESC";

        return $this->getEntityManager()->createQuery($dql)
                           
                             ->setMaxResults(4)
                             ->getResult();
}
public function getAutreVideos(){
        $dql = "SELECT b FROM ToubarefaneSiteBundle:Video b WHERE b.category = 'autre' ORDER BY b.id DESC";

        return $this->getEntityManager()->createQuery($dql)
                             ->getResult();
}
public function getKhassidaVideos(){
        $dql = "SELECT b FROM ToubarefaneSiteBundle:Video b WHERE b.category = 'khassida' ORDER BY b.id DESC";

        return $this->getEntityManager()->createQuery($dql)
                           ->getResult();
}
public function getWakhtaneVideos(){
        $dql = "SELECT b FROM ToubarefaneSiteBundle:Video b WHERE b.category = 'wakhtane' ORDER BY b.id DESC";

        return $this->getEntityManager()->createQuery($dql)
                             ->getResult();
}
//recherche de video
 public function getVideo($motcle){
        $query="select a from ToubarefaneSiteBundle:Video a WHERE a.description like '%$motcle%' or a.name like '%$motcle%' order by a.id DESC";
        
        return $this->getEntityManager()->createQuery($query)->getResult();
}
}
