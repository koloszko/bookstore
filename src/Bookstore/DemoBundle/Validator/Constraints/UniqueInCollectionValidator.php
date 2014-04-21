<?php

namespace Bookstore\DemoBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\PropertyAccess\PropertyAccess;

class UniqueInCollectionValidator extends ConstraintValidator {

    private $collectionValues = array();

    public function validate($object, Constraint $constraint) {
        $accessor = PropertyAccess::createPropertyAccessor();
        // Apply the property path if specified
        if ($constraint->propertyPath) {
            $value = $accessor->getValue($object, $constraint->propertyPath);
        }

        // Check that the value is not in the array
        if (in_array($value, $this->collectionValues)) {
            $this->context->addViolation($constraint->message, array());
        }
        
        // Add the value in the array for next items validation
        $this->collectionValues[] = $value;
    }

}