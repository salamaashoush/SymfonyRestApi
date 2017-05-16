<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Rule;
use Doctrine\ORM\Tools\Pagination\Paginator;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class RuleController extends FOSRestController
{

    /**
     * @param ParamFetcherInterface $paramFetcher
     * @return array
     * @Annotations\QueryParam(name="_sort", nullable=true, description="Sort field.")
     * @Annotations\QueryParam(name="_order", nullable=true, description="Sort Order.")
     * @Annotations\QueryParam(name="_start", nullable=true, description="Start.")
     * @Annotations\QueryParam(name="_end", nullable=true, description="End.")
     */
    public function getRulesAction(ParamFetcherInterface $paramFetcher)
    {
        $sort=$paramFetcher->get('_sort');
        $order=$paramFetcher->get('_order');
        $start=$paramFetcher->get('_start');
        $end=$paramFetcher->get('_end');
        $query = $this->getDoctrine()
            ->getRepository('AppBundle:Rule')
            ->findAllQuery($sort,$order,$start,$end);
        $paginator = new Paginator($query);
        $total = $paginator->count();
        $result= $query->getResult();
        return $this->handleView($this->view($result,200)
            ->setHeader('Access-Control-Expose-Headers','X-Total-Count')
            ->setHeader('X-Total-Count',$total));
    }


    public function postRuleAction(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $rule = new Rule();
        $form = $this->createForm('AppBundle\Form\RuleType', $rule);
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
