<?php

namespace AppBundle\Form\Type;

use DavidBadura\Taskwarrior\Task;
use Symfony\Component\Form\AbstractType;
use AppBundle\Form\Transformer\DependencyTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * @author Marcin Kurzyna <m.kurzyna@gmail.com>
 */
class DependencyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new DependencyTransformer());
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'multiple' => true,
            'choices' => [],
            'choices_as_values' => true,
            'choice_label' => function (Task $task = null) {
                return ($task ? $task->getDescription() : null);
            },
            'choice_value' => function (Task $task = null) {
                return ($task ? $task->getUuid() : null);
            },
        ]);

    }

    /**
     * @return string
     */
    public function getParent()
    {
        return ChoiceType::class;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'dependency';
    }
}
