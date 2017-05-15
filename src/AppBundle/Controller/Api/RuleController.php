<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Rule;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class RuleController extends FOSRestController
{

    public function getRulesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $rules = $em->getRepository('AppBundle:Rule')->findAll();
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
        return $form;
    }

    /**
     * @param Request $request
     * @param Rule $rule
     * @return array
     * @View()
     * @ParamConverter("rule",class="AppBundle:Rule")
     */
    public function putRuleAction(Request $request, Rule $rule)
    {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm('AppBundle\Form\RuleType', $rule);
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
     * @param Rule $rule
     * @return array
     * @View()
     * @ParamConverter("rule",class="AppBundle:Rules")
     */
    public function deleteRuleAction(Rule $rule)
    {
      $em = $this->getDoctrine()->getManager();
      $em->remove($rule);
      $em->flush();
      return $this->view(['Message' => 'Rule Deleted Successfully', 'Success' => true], Response::HTTP_OK);
    }

}
