<?php

namespace AppBundle\Controller;

use DavidBadura\Taskwarrior\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author David Badura <d.a.badura@gmail.com>
 *
 * @Route("/task")
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/{id}/info", name="task_info")
     *
     * @param string $id
     * @return array
     * @throws \DavidBadura\Taskwarrior\TaskwarriorException
     */
    public function infoAction($id)
    {
        $task = $this->getTaskManager()->find($id);

        if (!$task) {
            throw $this->createNotFoundException();
        }

        dump($task);
        die;

        return [
            'task' => $task
        ];
    }

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
        $form->add('submit', 'submit');

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
     * @Route("/{id}/edit", name="task_edit")
     * @Template()
     *
     * @param Request $request
     * @param string $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \DavidBadura\Taskwarrior\TaskwarriorException
     */
    public function editAction(Request $request, $id)
    {
        $task = $this->getTaskManager()->find($id);

        if (!$task) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm('task', $task);
        $form->add('submit', 'submit');

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getTaskManager()->save($task);
            return $this->redirectToRoute('homepage');
        }

        return [
            'task' => $task,
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/{id}/done", name="task_done")
     *
     * @param Request $request
     * @param string $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \DavidBadura\Taskwarrior\TaskwarriorException
     */
    public function doneAction(Request $request, $id)
    {
        $task = $this->getTaskManager()->find($id);

        if (!$task) {
            throw $this->createNotFoundException();
        }

        $this->getTaskManager()->done($task);

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/{id}/delete", name="task_delete")
     *
     * @param Request $request
     * @param string $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \DavidBadura\Taskwarrior\TaskwarriorException
     */
    public function deleteAction(Request $request, $id)
    {
        $task = $this->getTaskManager()->find($id);

        if (!$task) {
            throw $this->createNotFoundException();
        }

        $this->getTaskManager()->delete($task);

        return $this->redirectToRoute('homepage');
    }
}