<?php

namespace SP\MarketResearchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MarketResearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'Название',
            ))
            ->add('description', 'textarea', array(
                'label' => 'Описание',
            ))
            ->add('file', 'file', array(
                'label' => 'Картинка',
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SP\MarketResearchBundle\Document\MarketResearch'
        ));
    }

    public function getName()
    {
        return 'market_research_type';
    }
}