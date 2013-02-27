<?php

namespace SP\PurchaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'Название',
            ))
            ->add('codeNumber', 'text', array(
                'label' => 'Артикул поставщика',
            ))
            ->add('description', 'textarea', array(
                'label' => 'Описание',
            ))
            ->add('price', 'text', array(
                'label' => 'Цена в рублях',
            ))
            ->add('file', 'file', array(
                'label' => 'Картинка',
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SP\PurchaseBundle\Document\Offer'
        ));
    }

    public function getName()
    {
        return 'offer_type';
    }
}