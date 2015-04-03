<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @author David Badura <d.a.badura@gmail.com>
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('list');
    }

    /**
     * @Template()
     */
    public function navigationAction()
    {
        $taskwarrior = $this->getTaskManager()->getTaskwarrior();

        $projects = $taskwarrior->projects('status:pending');
        $tags     = $taskwarrior->tags('status:pending');

        return [
            'projects' => $projects,
            'tags'     => $tags
        ];
    }
}