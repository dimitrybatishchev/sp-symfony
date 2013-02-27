<?php

namespace SP\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('urlName', 'text')
            ->add('body', 'textarea',array(
                'attr' => array('class'=>'tinymce')
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SP\PostBundle\Document\Post'
        ));
    }

    public function getName()
    {
        return 'sp_adminbundle_posttype';
    }
}