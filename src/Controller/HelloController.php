<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HelloController extends AbstractController
{

    /**
     * @Route("/hello-world/{name}", name="hello-world", methods={"GET"})
     */
    public function helloWorld($name = "World")
    {
        return $this->render("hello/hello.html.twig", [
            'name' => $name
        ]);
    }

    
}
