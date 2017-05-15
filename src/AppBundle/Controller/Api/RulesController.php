<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Rules;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class RulesController extends FOSRestController
{

    public function getRulesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $rules = $em->getRepository('AppBundle:Rules')->findAll();
        return $rules;
    }


    public function postRuleAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $rule = new Rule();
        $form = $this->createForm('AppBundle\Form\RulesType', $rule);
        $form->submit($data);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rule);
            $em->flush();
            return $this->view(['Message' => 'Rule Created Successfully', 'Success' => true], Response::HTTP_CREATED);
        }
        return $form
    }

    /**
     * @param Rules $rule
     * @return array
     * @View()
     * @ParamConverter("rule",class="AppBundle:Rules")
     */
    public function putRuleAction(Request $request, Rules $rule)
    {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm('AppBundle\Form\RulesType', $rule);
        $form->submit($data,false);

        if ($form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($rule);
          $em->flush();
          return $this->view(['Message' => 'Rule Updated Successfully', 'Success' => true], Response::HTTP_OK);
        }
        return $form;
    }

    /**
     * @param Rules $rule
     * @return array
     * @View()
     * @ParamConverter("rule",class="AppBundle:Rules")
     */
    public function deleteRuleAction(Rules $rule)
    {
      $em = $this->getDoctrine()->getManager();
      $em->remove($rule);
      $em->flush();
      return $this->view(['Message' => 'Rule Deleted Successfully', 'Success' => true], Response::HTTP_OK);
    }

}