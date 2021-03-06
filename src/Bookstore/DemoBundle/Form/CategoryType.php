<?php

namespace Bookstore\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', null, array('label' => 'Nazwa', 'required' => true))
                ->add('parent_name', new CategoryNameType(), array(
                    'label' => 'Kategoria nadrzędna',
                    'property_path' => 'parent',
                    'disabled' => true,
                    'required' => false))
                ->add('parent', 'category_text', array(
                    'required' => false));
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
