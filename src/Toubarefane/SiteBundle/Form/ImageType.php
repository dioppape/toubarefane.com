<?php

namespace Toubarefane\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Toubarefane\SiteBundle\Form\FilesTransformer;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           
                 ->add(
                $builder->create('file', 'file', array(
            "label" => "Fichiers",
            "required" => FALSE,
            "attr" => array(
                "accept" => "image/*",
                "multiple" => "multiple",
                 )
                   ))
                         ->addModelTransformer
             ->addModelTransformer(new FilesTransformer()))
            ->add('type', 'choice', array(
              'choices' => array( 'marakhib' => 'Marakhib','photo' => 'Photo','wakana' => 'Wakana','taysir' => 'Taysir')))
             ;
         
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Toubarefane\SiteBundle\Entity\Image'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'toubarefane_sitebundle_image';
    }
}
