<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Track;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class TrackController extends FOSRestController
{
    /**
     * @return array
     * @View()
     *
     */
    public function getTracksAction()
    {
        $data = $this->getDoctrine()->getRepository('AppBundle:Track')->findAll();
        return $data;
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
            $em->persist($track);
            $em->flush();
            return $this->handleView(['Message' => 'Created Successfully', 'Success' => true], Response::HTTP_CREATED);
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
        $form->submit($data, false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
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