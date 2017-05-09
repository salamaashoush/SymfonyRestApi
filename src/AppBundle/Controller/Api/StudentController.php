<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class StudentController extends FOSRestController
{
    /**
     * @return array
     * @View()
     *
     */
    public function getStudentsAction()
    {
        $data = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        return ['users'=>$data];
    }

    /**
     * @param User $user
     * @View()
     * @ParamConverter("user",class="AppBundle:User")
     * @return array
     */
    public function getStudentAction(User $user){
        return ['user'=>$user];
    }
}