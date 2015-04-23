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
        $info = $this->get('task_information');

        return [
            'reports'  => $info->getReports(),
            'projects' => $info->getProjects(),
            'tags'     => $info->getTags()
        ];
    }

    /**
     * @Template()
     */
    public function headerAction()
    {
        $masterRequest = $this->get('request_stack')->getMasterRequest();

        $params = [];

        if ($project = $masterRequest->get('project')) {
            $params['project'] = $project;
        }

        if ($tag = $masterRequest->get('tag')) {
            $params['project'] = $tag;
        }

        return [
            'add_link' => $this->generateUrl('task_add', $params),
        ];
    }
}