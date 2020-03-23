<?php

namespace App\Controller;

use App\Repository\ProductRepository;
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
     * @Route("/", name="pages.home")
     */
    public function home(ProductRepository $productRepo)
    {
        return new Response($this->twig->render('pages/home.html.twig', ['products'=>$productRepo->findBy(array(),array('id'=>'DESC'),3)]));
    }

    /**
     * @Route("/about", name="pages.about")
     */
    public function about()
    {
        return new Response($this->twig->render('pages/about.html.twig'));
    }


}