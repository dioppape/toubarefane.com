<?php

namespace Toubarefane\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AudioType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('alt', 'choice', array(
              'choices' => array( 'coran' => 'Coran','kourel' => 'Kourel','radias' => 'Radias','segnesam'=>'Serigne Sam','wakhtane'=>'Wakhtane',
                  'zikr' => 'Zikr','segnesaliou'=>'Serigne Saliou Sow','maggni'=>'Maggni'
                  ,'sikhar' => 'Mame Mor Xam Sa Diné','soubane' => 'Autre Xam Sa Diné','jawhar' => 'Jawhar','nahjou' => 'Nahjou','massalik' => 'Massalik')
               ))
           ->add('file', 'file')
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Toubarefane\SiteBundle\Entity\Audio'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'toubarefane_sitebundle_audio';
    }
}
