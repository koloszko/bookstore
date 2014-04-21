<?php

namespace Bookstore\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Bookstore\DemoBundle\Form\BookHasCategoryType;

class BookType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', null, array('required' => true, 'label' => 'Tytuł'))
                ->add('author', null, array('required' => true, 'label' => 'Autor'))
                ->add('price', null, array('required' => true, 'label' => 'Cena'))
                ->add('categoriesWithPriority', 'collection',
                        array(
                    'label' => false,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'required' => false,     
                    'type' => new BookHasCategoryType()))
            ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Bookstore\DemoBundle\Entity\Book',
            'cascade_validation' => true
        ));
    }

    public function getName() {
        return 'bookstore_book_type';
    }

}
