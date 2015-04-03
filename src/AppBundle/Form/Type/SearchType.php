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
class SearchType extends AbstractType
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
        $choices = [
            'status:' . Task::STATUS_COMPLETED,
            'status:' . Task::STATUS_PENDING,
            'status:' . Task::STATUS_RECURRING,
            'status:' . Task::STATUS_WAITING,
            'status:' . Task::STATUS_DELETED,
            'priority:' . Task::PRIORITY_HIGH,
            'priority:' . Task::PRIORITY_LOW,
            'priority:' . Task::PRIORITY_MEDIUM
        ];

        foreach ($this->taskwarrior->tags() as $tag) {
            $choices[] = '+' . $tag;
        }

        foreach ($this->taskwarrior->projects() as $project) {
            $choices[] = 'project:' . $project;
        }

        $builder
            ->add('q', 'tag', [
                'required' => false,
                'choices'  => $choices
            ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'task_search';
    }
}