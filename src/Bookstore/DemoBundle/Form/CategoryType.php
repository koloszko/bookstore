<?php

namespace Bookstore\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', null, array('label' => 'Nazwa','required' => true))
                ->add('parent', null, array('label' => 'Kategoria nadrzędna', 'required' => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Bookstore\DemoBundle\Entity\Category'
        ));
    }

    public function getName() {
        return 'bookstore_category_type';
    }

}
