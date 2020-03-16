<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class PageController
{
    private $twig;
    /**
     * PageController constructor.
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }
    /**
     * @Route("/", name="page.home")
     */
    public function home()
    {
        return new Response($this->twig->render('pages/home.html.twig'));
    }

    /**
     * @Route("/about", name="page.about")
     */
    public function about()
    {
        return new Response($this->twig->render('pages/about.html.twig'));
    }


}