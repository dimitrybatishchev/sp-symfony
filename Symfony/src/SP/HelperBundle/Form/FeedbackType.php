<?php

namespace SP\HelperBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FeedbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject', 'text', array(
                'label' => 'Тема',
            ))
            ->add('message', 'textarea', array(
                'label' => 'Сообщение',
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SP\HelperBundle\Document\Feedback'
        ));
    }

    public function getName()
    {
        return 'sp_adminbundle_feedback';
    }
}