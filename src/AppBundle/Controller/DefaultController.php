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
        return $this->redirectToRoute('list', ['q' => 'report:' . $this->getParameter('default_report')]);
    }

    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error        = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return [
            'last_username' => $lastUsername,
            'error'         => $error,
        ];
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
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
            $params['tags'] = $tag;
        }

        return [
            'add_link' => $this->generateUrl('task_add', $params),
        ];
    }
}
