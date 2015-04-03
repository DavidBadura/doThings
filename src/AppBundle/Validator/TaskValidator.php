<?php

namespace AppBundle\Validator;

use DavidBadura\Taskwarrior\TaskManager;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class TaskValidator extends ConstraintValidator
{
    /**
     * @var TaskManager
     */
    private $taskManager;

    /**
     * @param TaskManager $taskManager
     */
    public function __construct(TaskManager $taskManager)
    {
        $this->taskManager = $taskManager;
    }

    /**
     * @param \DavidBadura\Taskwarrior\Task $task
     * @param Constraint $constraint
     */
    public function validate($task, Constraint $constraint)
    {
        $errors = $this->taskManager->validate($task);

        foreach ($errors as $error) {
            $this->context->addViolation($error);
        }
    }
}