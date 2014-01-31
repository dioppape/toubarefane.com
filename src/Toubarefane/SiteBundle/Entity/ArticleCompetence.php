<?php

namespace Toubarefane\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticleCompetence
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Toubarefane\SiteBundle\Entity\ArticleCompetenceRepository")
 */
class ArticleCompetence
{
    
    /**
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", length=255)
     */
    private $niveau;
     /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="Toubarefane\SiteBundle\Entity\Article")
   */
  private $article;

  /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="Toubarefane\SiteBundle\Entity\Competence")
   */
  private $competence;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set niveau
     *
     * @param string $niveau
     * @return ArticleCompetence
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;
    
        return $this;
    }

    /**
     * Get niveau
     *
     * @return string 
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set article
     *
     * @param \Toubarefane\SiteBundle\Entity\Article $article
     * @return ArticleCompetence
     */
    public function setArticle(\Toubarefane\SiteBundle\Entity\Article $article)
    {
        $this->article = $article;
    
        return $this;
    }

    /**
     * Get article
     *
     * @return \Toubarefane\SiteBundle\Entity\Article 
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set competence
     *
     * @param \Toubarefane\SiteBundle\Entity\Competence $competence
     * @return ArticleCompetence
     */
    public function setCompetence(\Toubarefane\SiteBundle\Entity\Competence $competence)
    {
        $this->competence = $competence;
    
        return $this;
    }

    /**
     * Get competence
     *
     * @return \Toubarefane\SiteBundle\Entity\Competence 
     */
    public function getCompetence()
    {
        return $this->competence;
    }
}
