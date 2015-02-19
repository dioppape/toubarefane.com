<?php

namespace Toubarefane\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('images', 'file', array(
                'attr' => array(
                    'accept' => 'image/*',
                    'multiple' => 'multiple'
                )
            ))
        ;
    }

    // other functions here ...

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Toubarefane\SiteBundle\Entity\Review'
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
