<?php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @author David Badura <d.a.badura@gmail.com>
 *
 * @Annotation
 */
class Task extends Constraint
{
    /**
     * @return string
     */
    public function validatedBy()
    {
        return 'task';
    }

    /**
     * @return string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}