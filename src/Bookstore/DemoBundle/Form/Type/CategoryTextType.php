<?php

namespace Bookstore\DemoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Bookstore\DemoBundle\Form\DataTransformer\CategoryToIdTransformer;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryTextType extends AbstractType {

    private $om;

    public function __construct(ObjectManager $om) {
        $this->om = $om;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $transformer = new CategoryToIdTransformer($this->om);
        $builder->addModelTransformer($transformer);
    }

    public function getDefaultOptions(array $options) {
        return array(
            'invalid_message' => 'Wybrana kategoria nie istnieje',
            'hidden' => false
        );
    }

    public function getParent() {
        return 'text';
    }

    public function getName() {
        return 'category_text';
    }

}

