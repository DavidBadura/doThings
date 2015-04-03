<?php

namespace AppBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class TokenTransformer implements DataTransformerInterface
{
    /**
     * @param mixed $value
     * @return mixed|void
     */
    public function transform($value)
    {
        if (!is_array($value)) {
            return [];
        }

        return implode(' ', $value);
    }

    /**
     * @param mixed $value
     * @return mixed|void
     */
    public function reverseTransform($value)
    {
        return array_map('trim', explode(' ', $value));
    }
}