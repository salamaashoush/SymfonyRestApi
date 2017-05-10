<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Branch;
use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class BranchController extends FOSRestController
{
    /**
     * @return array
     * @View()
     *
     */
    public function getBranchesAction()
    {
        $data = $this->getDoctrine()->getRepository('AppBundle:Branch')->findAll();
        return $data;
    }

    /**
     * @param Branch $branch
     * @return array
     * @View()
     * @ParamConverter("branch",class="AppBundle:Branch")
     */
    public function getBranchAction(Branch $branch)
    {
        return $branch;
    }

    public function postBranchAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $branch = new Branch();
        $form = $this->createForm('AppBundle\Form\BranchType', $branch);
        $form->submit($data);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($branch);
            $em->flush();
            return $this->view(['Message' => 'Created Successfully', 'Success' => true], Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * @param Branch $branch
     * @param Request $request
     * @return array
     * @View()
     * @ParamConverter("branch",class="AppBundle:Branch")
     */
    public function putBranchAction(Branch $branch, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm('AppBundle\Form\BranchType', $branch);
        $form->submit($data, false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($branch);
            $em->flush();
            return $this->view(['Message' => 'Updated Successfully', 'Success' => true], Response::HTTP_OK);
        }

        return $form;
    }

    /**
     * @param Branch $branch
     * @return array
     * @internal param Request $request
     * @View()
     * @ParamConverter("branch",class="AppBundle:Branch")
     */
    public function deleteBranchAction(Branch $branch)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($branch);
        $em->flush();
        return $this->view(['Message' => 'Deleted Successfully', 'Success' => true], Response::HTTP_OK);

    }
}