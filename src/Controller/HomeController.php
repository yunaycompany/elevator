<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Class HomeController
 */
class HomeController extends AbstractController
{

    /**
     * Home Page
     * @Route("/")
     */
    public function index(Request $request)
    {
        $em= $this->getDoctrine()->getManager();
        //Obtener todos los pedidos
        $requests = $em->getRepository(\App\Entity\Request::class)->findAll();

       return $this->render('index.html.twig',[
           'requests'=> $requests
       ]);
    }



}