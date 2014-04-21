<?php

namespace Bookstore\DemoBundle\Form\DataTransformer;

use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryToIdTransformer implements DataTransformerInterface {

    private $om;

    public function __construct(ObjectManager $om) {
        $this->om = $om;
    }

    public function transform($val) {
        if (null === $val) {
            return '';
        }
        return $val->getId();
    }

    public function reverseTransform($val) {
        if (!$val) {
            return null;
        }

        $category = $this->om->getRepository('BookstoreDemoBundle:Category')->findOneBy(array('id' => $val));
        if (null === $category) {
            throw new TransformationFailedException(sprintf('There is no category with %s', $val));
        }
        return $category;
    }

}
