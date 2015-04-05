<?php

namespace AppBundle\Form\Type;

use DavidBadura\Taskwarrior\Task;
use DavidBadura\Taskwarrior\Taskwarrior;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class TaskType extends AbstractType
{
    /**
     * @var Taskwarrior
     */
    private $taskwarrior;

    /**
     * @param Taskwarrior $taskwarrior
     */
    public function __construct(Taskwarrior $taskwarrior)
    {
        $this->taskwarrior = $taskwarrior;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'text')
            ->add('project', 'text', [
                'required' => false
            ])
            ->add('priority', 'choice', [
                'required' => false,
                'choices'  => [
                    Task::PRIORITY_HIGH   => Task::PRIORITY_HIGH,
                    Task::PRIORITY_MEDIUM => Task::PRIORITY_MEDIUM,
                    Task::PRIORITY_LOW    => Task::PRIORITY_LOW
                ]
            ])
            ->add('tags', 'tag', [
                'required' => false,
                'choices'  => $this->taskwarrior->tags()
            ])
            ->add('due', 'datetime', [
                'required'    => false,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ])
            ->add('wait', 'datetime', [
                'required'    => false,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
            ])
            ->add('recurring', 'recurring', [
                'required' => false
            ])
            ->add('until', 'datetime', [
                'required'    => false,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text'
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