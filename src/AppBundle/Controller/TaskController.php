<?php

namespace AppBundle\Controller;

use DavidBadura\Taskwarrior\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/add", name="task_add")
     * @Template()
     *
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request)
    {
        $task = new Task();

        $form = $this->createForm('task', $task);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getTaskManager()->save($task);

            return $this->redirectToRoute('homepage');
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route()
     * @Template()
     */
    public function editAction()
    {

    }

}