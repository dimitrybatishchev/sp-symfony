<?php

namespace SP\PurchaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PurchaseStopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('stopDate', 'text', array(
                'label' => 'Дата СТОП-заказа',
                'required' => false,
            ))
            ->add('stopSum', 'text', array(
                'label' => 'Нужно набрать сумму',
                'required' => false,
            ))
            ->add('stopMinCount', 'text', array(
                'label' => 'Минимальный заказ, штук',
                'required' => false,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SP\PurchaseBundle\Document\Purchase'
        ));
    }

    public function getName()
    {
        return 'purchase_stop';
    }
}