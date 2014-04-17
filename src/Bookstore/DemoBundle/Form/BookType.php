<?php

namespace Bookstore\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BookType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', null, array('required' => true, 'label' => 'Tytuł'))
                ->add('author', null, array('required' => true, 'label' => 'Autor'))
                ->add('price', null, array('required' => true, 'label' => 'Cena'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Bookstore\DemoBundle\Entity\Book'
        ));
    }

    public function getName() {
        return 'bookstore_user_type';
    }

}
