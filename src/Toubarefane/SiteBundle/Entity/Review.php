<?php

namespace Toubarefane\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntityName
 * @ORM\Table(name="entityname")
 */
class Review
{
    /**
     * @var array
     *
     * @ORM\Column(name="images", type="array", nullable=true)
     */
    private $images;
    public function getImages() {
        return $this->images;
    }

    public function setImages($images) {
        $this->images = $images;
    }


}