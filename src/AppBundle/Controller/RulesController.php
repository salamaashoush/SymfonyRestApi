<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Rules;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Rule controller.
 *
 * @Route("rules")
 */
class RulesController extends Controller
{
    /**
     * Lists all rule entities.
     *
     * @Route("/", name="rules_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $rules = $em->getRepository('AppBundle:Rules')->findAll();

        return $this->render('rules/index.html.twig', array(
            'rules' => $rules,
        ));
    }

    /**
     * Creates a new rule entity.
     *
     * @Route("/new", name="rules_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $rule = new Rule();
        $form = $this->createForm('AppBundle\Form\RulesType', $rule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rule);
            $em->flush();

            return $this->redirectToRoute('rules_show', array('id' => $rule->getId()));
        }

        return $this->render('rules/new.html.twig', array(
            'rule' => $rule,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a rule entity.
     *
     * @Route("/{id}", name="rules_show")
     * @Method("GET")
     */
    public function showAction(Rules $rule)
    {
        $deleteForm = $this->createDeleteForm($rule);

        return $this->render('rules/show.html.twig', array(
            'rule' => $rule,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing rule entity.
     *
     * @Route("/{id}/edit", name="rules_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Rules $rule)
    {
        $deleteForm = $this->createDeleteForm($rule);
        $editForm = $this->createForm('AppBundle\Form\RulesType', $rule);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rules_edit', array('id' => $rule->getId()));
        }

        return $this->render('rules/edit.html.twig', array(
            'rule' => $rule,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a rule entity.
     *
     * @Route("/{id}", name="rules_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Rules $rule)
    {
        $form = $this->createDeleteForm($rule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rule);
            $em->flush();
        }

        return $this->redirectToRoute('rules_index');
    }

    /**
     * Creates a form to delete a rule entity.
     *
     * @param Rules $rule The rule entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rules $rule)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rules_delete', array('id' => $rule->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
