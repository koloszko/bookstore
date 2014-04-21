<?php

namespace Bookstore\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BookHasCategoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('category_name', null, array(
                    'label' => 'Kategoria', 
                    'property_path' => 'category.name', 
                    'disabled' => true, 
                    'attr' => array('class' => 'category_name')))
                ->add('priority', null, array('required' => true, 'label' => 'Priorytet'))                
                ->add('category', 'category_text', array(                    
                    'required' => true,
                    'attr' => array('class' => 'category_id'))                     
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Bookstore\DemoBundle\Entity\BookHasCategory'
        ));
    }

    public function getName() {
        return 'bookstore_bookhascategory_type';
    }

}
