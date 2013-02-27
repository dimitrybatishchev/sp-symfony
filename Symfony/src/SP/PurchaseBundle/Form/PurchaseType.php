<?php

namespace SP\PurchaseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PurchaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'Название',
            ))
            ->add('city', 'document', array(
                'class' => 'SP\GeoBundle\Document\City',
                'property' => 'name',
                'label' => 'Город',
            ))
            ->add('foreignUsers', 'checkbox', array(
                'required' => false,
                'label' => 'Могу выслать в другие города',
            ))
            ->add('categories', 'document', array(
                'class' => 'SP\CatalogBundle\Document\Category',
                'property' => 'name',
                'label' => 'Категории',
            ))
            ->add('fromSite', 'text', array(
                'label' => 'Закупка с сайта',
            ))
            ->add('userCanAddOffers', 'checkbox', array(
                'required' => false,
                'label' => 'Разрешить пользователям добавлять товары',
            ))
            ->add('colorIsGaranted', 'checkbox', array(
                'required' => false,
                'label' => 'Цвет гарантирован',
            ))
            ->add('sizeIsGaranted', 'checkbox', array(
                'required' => false,
                'label' => 'Размер гарантирован',
            ))
            ->add('exchangeBrokenIsGaranted', 'checkbox', array(
                'required' => false,
                'label' => 'Обмен брака гарантирован',
            ))
            ->add('profit', 'text', array(
                'label' => 'Процент организатора',
            ))
            ->add('deliveryIncluded', 'checkbox', array(
                'required' => false,
                'label' => 'Транспортные расходы включены в цену заказов',
            ))
            ->add('moneyTransferTypes', 'document', array(
                'class' => 'SP\PurchaseBundle\Document\Transfer',
                'property' => 'name',
                'label' => 'Способы оплаты',
            ))
            ->add('prepaymentAmount', 'text', array(
                'label' => 'Предоплата',
            ))
            ->add('deliveryTypes', 'document', array(
                'class' => 'SP\PurchaseBundle\Document\Delivery',
                'property' => 'name',
                'label' => 'Варианты раздачи',
            ))
            ->add('description', 'textarea', array(
                'label' => 'Описание закупки',
            ))
            ->add('supplier', 'textarea', array(
                'label' => 'Информация о поставщике',
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
        return 'sp_spbundle_sptype';
    }
}