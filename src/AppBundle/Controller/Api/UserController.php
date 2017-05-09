<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UserController extends FOSRestController
{
    /**
     * @return array
     * @View()
     *
     */
    public function getUsersAction()
    {
        $data = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        return $data;
    }

    /**
     * @param User $user
     * @return array
     * @View()
     * @ParamConverter("user",class="AppBundle:User")
     */
    public function getUserAction(User $user)
    {
        return $user;
    }

    public function postUserAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $user = new User();
        $form = $this->createForm('AppBundle\Form\RegistrationType', $user);
        $form->submit($data);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($branch);
            $em->flush();
            return $this->handleView(['Message' => 'Created Successfully', 'Success' => true], Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * @param User $user
     * @param Request $request
     * @return array
     * @View()
     * @ParamConverter("student",class="AppBundle:User")
     */
    public function putUserAction(User $user, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm('AppBundle\Form\RegistrationType', $user);
        $form->submit($data, false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->view(['Message' => 'Updated Successfully', 'Success' => true], Response::HTTP_OK);
        }

        return $form;
    }

    /**
     * @param User $user
     * @return array
     * @View()
     * @ParamConverter("student",class="AppBundle:User")
     */
    public function deleteUserAction(User $user)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->view(['Message' => 'Deleted Successfully', 'Success' => true], Response::HTTP_OK);

    }
}