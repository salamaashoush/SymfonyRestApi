<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UserController extends FOSRestController
{
    /**
     * @param ParamFetcherInterface $paramFetcher
     * @return array
     * @Annotations\QueryParam(name="_sort", nullable=true, description="Sort field.")
     * @Annotations\QueryParam(name="_order", nullable=true, description="Sort Order.")
     * @Annotations\QueryParam(name="_start", nullable=true, description="Start.")
     * @Annotations\QueryParam(name="_end", nullable=true, description="End.")
     */
    public function getUsersAction(ParamFetcherInterface $paramFetcher)
    {
        $sort=$paramFetcher->get('_sort');
        $order=$paramFetcher->get('_order');
        $start=$paramFetcher->get('_start');
        $end=$paramFetcher->get('_end');
        $query = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findAllQuery($sort,$order,$start,$end);
        $paginator = new Paginator($query);
        $total = $paginator->count();
        $result= $query->getResult();
        return $this->handleView($this->view($result,200)
            ->setHeader('Access-Control-Expose-Headers','X-Total-Count')
            ->setHeader('X-Total-Count',$total));
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
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->submit($data);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setBranch($this->getDoctrine()
                ->getRepository('AppBundle:Branch')
                ->find($form['branch_id']->getData())
            );
            $user->setTrack($this->getDoctrine()
                ->getRepository('AppBundle:Track')
                ->find($form['track_id']->getData())
            );
            $em->persist($user);
            $em->flush();
            return $this->view(['Message' => 'Created Successfully', 'Success' => true], Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * @param User $user
     * @param Request $request
     * @return array
     * @View()
     * @ParamConverter("user",class="AppBundle:User")
     */
    public function putUserAction(User $user, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        unset($data['id']);
        unset($data['enabled']);
        unset($data['username_canonical']);
        unset($data['email_canonical']);
        unset($data['password']);
        $form->submit($data, false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setBranch($this->getDoctrine()
                ->getRepository('AppBundle:Branch')
                ->find($form['branch_id']->getData())
            );
            $user->setTrack($this->getDoctrine()
                ->getRepository('AppBundle:Track')
                ->find($form['track_id']->getData())
            );
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
     * @ParamConverter("user",class="AppBundle:User")
     */
    public function deleteUserAction(User $user)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->view(['Message' => 'Deleted Successfully', 'Success' => true], Response::HTTP_OK);

    }
}