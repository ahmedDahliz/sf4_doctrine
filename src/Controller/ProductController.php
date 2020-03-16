<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ProductController
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
     * @Route("/products", name="product.index")
     */
    public function products()
    {
        return new Response($this->twig->render('product/index.html.twig'));
    }
}