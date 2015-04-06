<?php

namespace AppBundle\Controller;

use DavidBadura\Taskwarrior\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author David Badura <d.a.badura@gmail.com>
 *
 * @Route("/task")
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/{id}/info", name="task_info")
     * @Template()
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
        $task->setProject($request->get('project', null));
        $task->setTags($request->get('tags', []));

        $form = $this->createForm('task', $task, [
            'action' => $this->generateUrl('task_add')
        ]);

        $form->add('submit', 'submit', [
            'attr' => ['class' => 'btn btn-secondly']
        ]);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getTaskManager()->save($task);

            return new Response('', 201);
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

        $form = $this->createForm('task', $task, [
            'action' => $this->generateUrl('task_edit', ['id' => $task->getUuid()])
        ]);

        $form->add('submit', 'submit', [
            'attr' => ['class' => 'btn btn-secondly']
        ]);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->getTaskManager()->save($task);

            return new Response('', 201);
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

        return new Response('', 201);
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

        return new Response('', 201);
    }

    /**
     * @Route("/{id}/reopen", name="task_reopen")
     *
     * @param Request $request
     * @param string $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \DavidBadura\Taskwarrior\TaskwarriorException
     */
    public function reopenAction(Request $request, $id)
    {
        $task = $this->getTaskManager()->find($id);

        if (!$task) {
            throw $this->createNotFoundException();
        }

        $this->getTaskManager()->reopen($task);

        return new Response('', 201);
    }
}