<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Track;
use Doctrine\ORM\Tools\Pagination\Paginator;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TrackController extends FOSRestController
{
    /**
     * @param ParamFetcherInterface $paramFetcher
     * @return array
     * @Annotations\QueryParam(name="_sort", nullable=true, description="Sort field.")
     * @Annotations\QueryParam(name="_order", nullable=true, description="Sort Order.")
     * @Annotations\QueryParam(name="_start", nullable=true, description="Start.")
     * @Annotations\QueryParam(name="_end", nullable=true, description="End.")
     */
    public function getTracksAction(ParamFetcherInterface $paramFetcher)
    {
        $sort=$paramFetcher->get('_sort');
        $order=$paramFetcher->get('_order');
        $start=$paramFetcher->get('_start');
        $end=$paramFetcher->get('_end');
        $query = $this->getDoctrine()
            ->getRepository('AppBundle:Track')
            ->findAllQuery($sort,$order,$start,$end);
        $paginator = new Paginator($query);
        $total = $paginator->count();
        $result= $query->getResult();
        return $this->handleView($this->view($result,200)
            ->setHeader('Access-Control-Expose-Headers','X-Total-Count')
            ->setHeader('X-Total-Count',$total));
    }

    /**
     * @param Track $track
     * @return array
     * @View()
     * @ParamConverter("track",class="AppBundle:Track")
     */
    public function getTrackAction(Track $track)
    {
        return $track;
    }

    public function postTrackAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $track = new Track();
        $form = $this->createForm('AppBundle\Form\TrackType', $track);
        $form->submit($data);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $track->setBranch($this->getDoctrine()
                ->getRepository('AppBundle:Branch')
                ->find($form['branch_id']->getData())
            );
            $em->persist($track);
            $em->flush();
            return $this->view(['Message' => 'Created Successfully', 'Success' => true], Response::HTTP_CREATED);
        }

        return $form;
    }

    /**
     * @param Track $track
     * @param Request $request
     * @return array
     * @View()
     * @ParamConverter("track",class="AppBundle:Track")
     */
    public function putTrackAction(Track $track, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm('AppBundle\Form\TrackType', $track);
        unset($data['id']);
        unset($data['branch']);
        unset($data['rules']);
        unset($data['students']);

        $form->submit($data, false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $track->setBranch($this->getDoctrine()
                ->getRepository('AppBundle:Branch')
                ->find($form['branch_id']->getData())
            );
            $em->persist($track);
            $em->flush();
            return $this->view(['Message' => 'Updated Successfully', 'Success' => true], Response::HTTP_OK);
        }

        return $form;
    }

    /**
     * @param Track $track
     * @return array
     * @View()
     * @ParamConverter("track",class="AppBundle:Track")
     */
    public function deleteTrackAction(Track $track)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($track);
        $em->flush();
        return $this->view(['Message' => 'Deleted Successfully', 'Success' => true], Response::HTTP_OK);

    }
}