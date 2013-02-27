<?php

namespace SP\UserMessagesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('receiver', 'text', array(
                'label' => 'Кому',
            ))
            ->add('body', 'textarea', array(
                'label' => 'Текст',
            ))
        ;
    }
    
    public function getName()
    {
        return 'sp_usermessagesbundle_message';
    }
}