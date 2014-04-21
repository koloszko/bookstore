<?php

namespace Bookstore\DemoBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class UniqueInCollection extends Constraint {
    public $message = 'The error message (with %parameters%)';
    public $propertyPath = null;

}
