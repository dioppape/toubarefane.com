<?php

namespace Toubarefane\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ArticleRechercheType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('motcle', 'text', array('label' => 'Mot-clé'));
     

    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'articlerecherche';
    }
}
