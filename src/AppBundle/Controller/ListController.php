<?php

namespace AppBundle\Controller;

use DavidBadura\Taskwarrior\Query\QueryBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author David Badura <d.a.badura@gmail.com>
 *
 * @Route("/list")
 */
class ListController extends AbstractController
{
    /**
     * @Route("/", name="list")
     */
    public function listAction()
    {
        return $this->filterTasks('status:pending', [
            'urgency' => QueryBuilder::DESC
        ]);
    }

    /**
     * @Route("/report/{report}", name="list_report")
     */
    public function reportAction($report)
    {
        $report = $this->getTaskManager()->getTaskwarrior()->config()->getReport($report);

        return $this->filterTasks(
            $report->filter,
            $report->sort
        );
    }

    /**
     * @Route("/tag/{tag}", name="list_tag")
     */
    public function tagAction($tag)
    {
        return $this->filterTasks('+' . $tag . ' status:pending', [
            'urgency' => QueryBuilder::DESC
        ]);
    }

    /**
     * @Route("/project/{project}", name="list_project")
     */
    public function projectAction($project)
    {
        return $this->filterTasks('project:' . $project . ' status:pending', [
            'urgency' => QueryBuilder::DESC
        ]);
    }

    /**
     * @Route("/search", name="list_search")
     */
    public function searchAction(Request $request)
    {
        return $this->filterTasks(str_replace(',', ' ', $request->get('q', '')), [
            'description' => QueryBuilder::ASC
        ]);
    }

    /**
     * @param string $filter
     * @param array $sortBy
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function filterTasks($filter = '', array $sortBy = [])
    {
        $form = $this->get('form.factory')->createNamed(null, 'task_search', null, [
            'action'          => $this->generateUrl('list_search'),
            'method'          => 'get',
            'csrf_protection' => false
        ]);

        $form->get('q')->setData(explode(' ', $filter));
        $form->add('submit', 'submit', ['label' => 'Search']);

        $tasks = $this->getTaskManager()
            ->createQueryBuilder()
            ->where($filter)
            ->orderBy($sortBy)
            ->getResult();

        return $this->render("AppBundle:List:list.html.twig", [
            'filter' => $filter,
            'tasks'  => $tasks,
            'form'   => $form->createView()
        ]);
    }
}