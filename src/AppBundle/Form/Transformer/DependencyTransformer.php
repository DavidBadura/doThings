<?php

namespace AppBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Marcin Kurzyna <m.kurzyna@gmail.com>
 */
class DependencyTransformer implements DataTransformerInterface
{
    /**
     * @param mixed $deps
     * @return array|void
     */
    public function transform($deps)
    {
        if ($deps instanceof ArrayCollection) {
            return $deps->toArray();
        }

        return (array) $deps;
    }

    /**
     * @param mixed $deps
     * @return ArrayCollection|void
     */
    public function reverseTransform($deps)
    {
        if (is_array($deps)) {
            return new ArrayCollection($deps);
        }
    }
}
