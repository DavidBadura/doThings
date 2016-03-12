<?php

namespace AppBundle;

use DavidBadura\Taskwarrior\TaskManager;
use Symfony\Component\Routing\Router;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class TaskInformation
{
    /**
     * @var TaskManager
     */
    private $taskManager;
    /**
     * @var Router
     */
    private $router;

    /**
     * @var string[]
     */
    private $reports;

    /**
     * @param TaskManager $taskManager
     * @param Router $router
     * @param string[] $reports
     */
    public function __construct(TaskManager $taskManager, Router $router, array $reports = [])
    {
        $this->taskManager = $taskManager;
        $this->router      = $router;
        $this->reports     = $reports;
    }

    /**
     * @return array
     */
    public function getReports()
    {
        $reports = $this->getTaskwarrior()->config()->getReports();
        $list    = [];

        foreach ($this->reports as $name) {
            $report = $reports[$name];

            $count = $this->taskManager->createQueryBuilder()
                ->where($report->filter)
                ->count();

            $list[$name] = [
                'url'   => $this->router->generate('list_report', ['report' => $name]),
                'count' => $count
            ];
        }

        return $list;
    }

    /**
     * @return array
     */
    public function getProjects()
    {
        $projects = [];

        foreach ($this->getTaskwarrior()->projects() as $project) {

            $count = $this->taskManager->createQueryBuilder()
                ->whereProject($project)
                ->wherePending()
                ->count();

            $projects[$project] = [
                'url'   => $this->router->generate('list_project', ['project' => $project]),
                'count' => $count
            ];
        }

        return $projects;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        $tags = [];

        foreach ($this->getTaskwarrior()->tags() as $tag) {
            $count = $this->taskManager->createQueryBuilder()
                ->whereTag($tag)
                ->wherePending()
                ->count();

            $tags[$tag] = [
                'url'   => $this->router->generate('list_tag', ['tag' => $tag]),
                'count' => $count
            ];
        }

        uasort($tags, function ($tagA, $tagB) {
            return $tagB['count'] - $tagA['count'];
        });

        $tags = array_filter(
            $tags,
            function ($tag) {
                return $tag['count'] > 0;
            }
        );

        return $tags;
    }

    private function getTaskwarrior()
    {
        return $this->taskManager->getTaskwarrior();
    }
}
