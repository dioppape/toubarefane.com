<?php

namespace Toubarefane\SiteBundle\Form;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Toubarefane\SiteBundle\Entity\Image;

class FilesTransformer implements DataTransformerInterface
{
    
    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param  Issue|null $issue
     * @return string
     */
    public function transform($photo)
    {
        if (null === $photo) {
            return "";
        }

        return $photo->getFile();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $number
     * @return Issue|null
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($files)
    {
        $photos = [];
        foreach($files as $file){
            $photo = new Image();
            $photo->setFile($file);
            $photos[] = $photo;
        }
         if (null === $files) {
            throw new TransformationFailedException(sprintf(
                'Le problème avec le numéro "%s" ne peut pas être trouvé!',
                $photos
            ));
        }
        return $photos;
    }
}