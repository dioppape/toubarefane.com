<?php

namespace Toubarefane\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Toubarefane\SiteBundle\Entity\ArticleRepository")
 */
class Article
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetimetz")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="auteur", type="string", length=255)
     */
    private $auteur;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;

/**
   * @ORM\Column(name="publication", type="boolean")
   */
  private $publication;

  /**
   * @ORM\Column(type="date", nullable=true)
   */
  private $dateEdition;
  
 
  /**
   * @ORM\OneToOne(targetEntity="Toubarefane\SiteBundle\Entity\File", cascade={"persist", "remove"})
   */
  private $file;

  /**
   * @ORM\ManyToMany(targetEntity="Toubarefane\SiteBundle\Entity\Categorie", cascade={"persist"})
   */
  private $categories;

  /**
   * @ORM\OneToMany(targetEntity="Toubarefane\SiteBundle\Entity\Commentaire", mappedBy="article")
   */
  private $commentaires; // Ici commentaires prend un « s », car un article a plusieurs commentaires !


  public function __construct()
  {
    $this->date     = new \Datetime;
    $this->publication  = true;
    $this->categories   = new \Doctrine\Common\Collections\ArrayCollection();
    $this->commentaires = new \Doctrine\Common\Collections\ArrayCollection();
  }
  
  
  public function updateDate()
  {
    $this->setDateEdition(new \Datetime());
  }
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
     * Set date
     *
     * @param \DateTime $date
     * @return Article
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Article
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    
        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     * @return Article
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;
    
        return $this;
    }

    /**
     * Get auteur
     *
     * @return string 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Article
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    
        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set publication
     *
     * @param boolean $publication
     * @return Article
     */
    public function setPublication($publication)
    {
        $this->publication = $publication;
    
        return $this;
    }

    /**
     * Get publication
     *
     * @return boolean 
     */
    public function getPublication()
    {
        return $this->publication;
    }

   
    /**
     * Set dateEdition
     *
     * @param \DateTime $dateEdition
     * @return Article
     */
    public function setDateEdition($dateEdition)
    {
        $this->dateEdition = $dateEdition;
    
        return $this;
    }

    /**
     * Get dateEdition
     *
     * @return \DateTime 
     */
    public function getDateEdition()
    {
        return $this->dateEdition;
    }

    /**
     * Add categories
     *
     * @param \Toubarefane\SiteBundle\Entity\Categorie $categories
     * @return Article
     */
    public function addCategory(\Toubarefane\SiteBundle\Entity\Categorie $categories)
    {
        $this->categories[] = $categories;
    
        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Toubarefane\SiteBundle\Entity\Categorie $categories
     */
    public function removeCategory(\Toubarefane\SiteBundle\Entity\Categorie $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add commentaires
     *
     * @param \Toubarefane\SiteBundle\Entity\Commentaire $commentaires
     * @return Article
     */
    public function addCommentaire(\Toubarefane\SiteBundle\Entity\Commentaire $commentaires)
    {
        $this->commentaires[] = $commentaires;
    
        return $this;
    }

    /**
     * Remove commentaires
     *
     * @param \Toubarefane\SiteBundle\Entity\Commentaire $commentaires
     */
    public function removeCommentaire(\Toubarefane\SiteBundle\Entity\Commentaire $commentaires)
    {
        $this->commentaires->removeElement($commentaires);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Set file
     *
     * @param \Toubarefane\SiteBundle\Entity\File $file
     * @return Article
     */
    public function setFile(\Toubarefane\SiteBundle\Entity\File $file = null)
    {
        $this->file = $file;
    
        return $this;
    }

    /**
     * Get file
     *
     * @return \Toubarefane\SiteBundle\Entity\File 
     */
    public function getFile()
    {
        return $this->file;
    }
}
