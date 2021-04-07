<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/home", name="home")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/helloUser/{name?}", name="hello_user")
     */
    public function helloUser(Request $request, $name)
    {
        // request
        // $name = $request->get('name');

        $form = $this->createFormBuilder()
            ->add('fullname')
            ->getForm()
            ->createView();

        $person = [
            'name' => 'Amit',
            'lastname' => 'V',
            'age' => '24'
        ];

        return $this->render('home/greet.html.twig', compact('person', 'form'));
    }
}
