<?php

namespace AppBundle\Form\Type;

use DavidBadura\Taskwarrior\Task;
use DavidBadura\Taskwarrior\Taskwarrior;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
            ->add('description', 'text', [
                'attr' => ["autofocus" => true]
            ])
            ->add('project', 'text', [
                'required' => false,
                'datalist' => $this->taskwarrior->projects()
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

        $builder->get('due')->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
            $data = $event->getData();

            if ($data['date'] && !$data['time']) {
                $data['time'] = '23:30';
            }

            $event->setData($data);
        });

        $builder->get('wait')->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
            $data = $event->getData();

            if ($data['date'] && !$data['time']) {
                $data['time'] = '00:00';
            }

            $event->setData($data);
        });
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