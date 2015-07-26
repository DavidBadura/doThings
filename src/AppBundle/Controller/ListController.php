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
            'action'          => $this->generateUrl('list'),
            'method'          => 'get',
            'csrf_protection' => false
        ]);

        $form->get('q')->setData($filter);
        $form->add('submit', 'submit', ['label' => 'Search']);

        $filterAndReport = $this->splitReportFromFilter($filter);

        if (empty($filterAndReport['report'])) {
            $tasks = $this->getTaskManager()
                ->createQueryBuilder()
                ->where($filter)
                ->orderBy($sortBy)
                ->getResult();
        } else {
            $tasks = $this->getTaskManager()->filterByReport(
                $filterAndReport['report'],
                $filterAndReport['filter']
            );
        }

        return $this->render("AppBundle:List:list.html.twig", [
            'filter' => $filter,
            'tasks'  => $tasks,
            'form'   => $form->createView()
        ]);
    }

    private function splitReportFromFilter($filter)
    {
        if (!preg_match('/report:([a-z0-9]+)/i', $filter, $matches)) {
            return [
                'report' => null,
                'filter' => $filter
            ];
        }

        return [
            'report' => $matches[1],
            'filter' => str_replace('report:' . $matches[1], '', $filter)
        ];

    }
}
