<?php

namespace Toubarefane\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FileType extends ArticleType
{
    private $type;
    public function __construct($type)
    {
        $this->type = $type;
    }
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
          ->add('files','file')
            ->add('description','text',array('label'=>'Embed'))
           ->add('type', 'choice', array(
                   'choices' => array('image' => 'Image', 'audio' => 'Audio','video'=>'Video')
                          ))
            ;
        
         if($this->type==="youtube"){
       $builder->remove ("files");
        $builder->remove ("type")
        ->add('type', 'choice', array(
                   'choices' => array('youtube'=>'Youtube')
                          ));
                }
   else{
      $builder->remove ("description"); 
   }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Toubarefane\SiteBundle\Entity\File'
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
