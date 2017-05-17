<?php

namespace AppBundle\Controller\Api;
use AppBundle\Entity\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Response;

class QRController extends Controller
{
    /**
     * @Route("/api/qrcode/{code}", name="qrcode")
     * @param $code
     * @return Response
     */
    public function QrcodeAction($code)
    {
        $qr=$this->getDoctrine()->getRepository('AppBundle:QrCode')->findAll();
        if(empty($qr)){
            $qr = new QrCode();
        }else{
            $qr=$qr[0];
        }

        $qr->setStartDate(new \DateTime());
        $qr->setCode($code);
        $qr->setDuration(30);
        $em = $this->getDoctrine()->getManager();
        $em->persist($qr);
        $em->flush();
        $qrCode = $this->get('endroid.qrcode.factory')->create($code, ['size' => 500]);
        return new Response(
            $qrCode->writeString(PngWriter::class),
            Response::HTTP_OK,
            ['Content-Type' => $qrCode->getContentType(PngWriter::class)]
        );
    }
    private function randomString($length){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


}