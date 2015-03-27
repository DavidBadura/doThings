<?php

namespace AppBundle\Form\Type;

use DavidBadura\Taskwarrior\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class AutocompleteType extends AbstractType
{
    /**
     * @return string
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'autocomplete';
    }
}