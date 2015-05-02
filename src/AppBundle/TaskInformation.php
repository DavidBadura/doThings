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
        $reports = $this->taskManager->getTaskwarrior()->config()->getReports();
        $list    = [];

        foreach ($this->reports as $report) {
            $list[$report] = [
                'url'   => $this->router->generate('list_report', ['report' => $report]),
                'count' => count($this->taskManager->filterByReport($reports[$report]))
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

        $taskwarrior = $this->taskManager->getTaskwarrior();
        foreach ($taskwarrior->projects() as $project) {
            $projects[$project] = [
                'url'   => $this->router->generate('list_project', ['project' => $project]),
                'count' => count($this->taskManager->filterPending('project:' . $project))
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

        $taskwarrior = $this->taskManager->getTaskwarrior();
        foreach ($taskwarrior->tags() as $tag) {
            $tags[$tag] = [
                'url'   => $this->router->generate('list_tag', ['tag' => $tag]),
                'count' => count($this->taskManager->filterPending('+' . $tag))
            ];
        }

        return $tags;
    }
}