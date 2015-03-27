<?php

namespace AppBundle\Controller;

use DavidBadura\Taskwarrior\TaskManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
abstract class AbstractController extends Controller
{
    /**
     * @return TaskManager
     */
    public function getTaskManager()
    {
        return $this->get('task_manager');
    }
}