<?php

namespace AppBundle\Controller\Web;

use AppBundle\Entity\Branch;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
    /**
     * @Route("/qr")
     */
    public function branchesAction()
    {
        $qrCode = $this->get('endroid.qrcode.factory')->create('QR Code', ['size' => 500]);
        return $this->render(':default:qr.html.twig',['qr'=>$qrCode]);
    }
}
