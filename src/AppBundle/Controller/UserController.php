<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserController extends FOSRestController
{
    public function getUsersAction()
    {
        $data = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        $view = $this->view($data, 200)
            ->setTemplate("AppBundle:Users:index.html.twig")
            ->setTemplateVar('users')
        ;

        return $this->handleView($view);
    }
    public function getUserAction($id){
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if(!is_object($user)){
            throw $this->createNotFoundException();
        }
        return $user;
    }
}