<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Branch;
use AppBundle\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class BranchController extends FOSRestController
{
    /**
     * @param ParamFetcherInterface $paramFetcher
     * @return array
     * @Annotations\QueryParam(name="_sort", nullable=true, description="Sort field.")
     * @Annotations\QueryParam(name="_order", nullable=true, description="Sort Order.")
     * @Annotations\QueryParam(name="_start", nullable=true, description="Start.")
     * @Annotations\QueryParam(name="_end", nullable=true, description="End.")
     */
    public function getBranchesAction(ParamFetcherInterface $paramFetcher)
    {
        $sort=$paramFetcher->get('_sort');
        $order=$paramFetcher->get('_order');
        $start=$paramFetcher->get('_start');
        $end=$paramFetcher->get('_end');
        $query = $this->getDoctrine()
            ->getRepository('AppBundle:Branch')
            ->findAllQuery($sort,$order,$start,$end);
        $paginator = new Paginator($query);
        $total = $paginator->count();
        $result= $query->getResult();
        return $this->handleView($this->view($result,200)
            ->setHeader('Access-Control-Expose-Headers','X-Total-Count')
            ->setHeader('X-Total-Count',$total));
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
        unset($data['id']);
        unset($data['tracks']);
        $form->submit($data,false);
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