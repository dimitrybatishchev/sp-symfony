<?php

namespace SP\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text', array(
                'label' => 'Имя',
                'required' => false,
            ))
            ->add('middlename', 'text', array(
                'label' => 'Отчество',
                'required' => false,
            ))
            ->add('lastname', 'text', array(
                'label' => 'Фамилия',
                'required' => false,
            ))
            ->add('file', 'file', array(
                'label' => 'Аватар',
                'required' => false,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SP\UserBundle\Document\User'
        ));
    }

    public function getName()
    {
        return 'sp_userbundle_userprofile';
    }
}