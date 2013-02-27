<?php

namespace SP\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text')
            ->add('codeNumber', 'text')
            ->add('description', 'text')
            ->add('price', 'text')
            ->add('file', 'file')
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
        return 'sp_adminbundle_spitemtype';
    }
}