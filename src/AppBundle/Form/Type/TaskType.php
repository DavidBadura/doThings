<?php

namespace AppBundle\Form\Type;

use DavidBadura\Taskwarrior\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class TaskType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'text')
            ->add('priority', 'choice', [
                'choices' => [
                    Task::PRIORITY_HIGH   => Task::PRIORITY_HIGH,
                    Task::PRIORITY_MEDIUM => Task::PRIORITY_MEDIUM,
                    Task::PRIORITY_LOW    => Task::PRIORITY_LOW
                ]
            ])
            ->add('project', 'autocomplete')
            ->add('due', 'datetime', [
                'widget' => 'single_text',
                'attr'   => ['class' => 'datetimepicker']
            ])
            ->add('wait', 'datetime', [
                'widget' => 'single_text',
                'attr'   => ['class' => 'datetimepicker']
            ])
            ->add('tags', 'tag')
            ->add('recurring', 'recurring')
            ->add('until', 'datetime', [
                'widget' => 'single_text',
                'attr'   => ['class' => 'datetimepicker']
            ]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'DavidBadura\Taskwarrior\Task'
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'task';
    }
}