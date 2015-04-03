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
            'lists'    => $info->getLists(),
            'projects' => $info->getProjects(),
            'tags'     => $info->getTags()
        ];
    }
}