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
        dump($value);
    }

    /**
     * @param mixed $value
     * @return mixed|void
     */
    public function reverseTransform($value)
    {

    }
}