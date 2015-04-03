<?php

namespace AppBundle\Form\Transformer;

use DavidBadura\Taskwarrior\Recurring;
use DavidBadura\Taskwarrior\TaskwarriorException;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class RecurringTransformer implements DataTransformerInterface
{
    /**
     * @param null|Recurring $value
     * @return mixed|void
     */
    public function transform($value)
    {
        if (!$value) {
            return '';
        }

        return $value->getValue();
    }

    /**
     * @param mixed $value
     * @return mixed|void
     */
    public function reverseTransform($value)
    {
        if(!$value) {
            return null;
        }

        try {
            return new Recurring($value);
        } catch (TaskwarriorException $e) {
            throw new TransformationFailedException();
        }
    }
}