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

    /**
     * @Route("/products/edit", name="product.edit")
     */
    public function editProducts()
    {
        return new Response($this->twig->render('product/edit.html.twig'));
    }

    /**
     * @Route("/products/add", name="product.add")
     */
    public function addProducts()
    {
        return new Response($this->twig->render('product/add.html.twig'));
    }

    /**
     * @Route("/products/show", name="product.show")
     */
    public function showProducts()
    {
        return new Response($this->twig->render('product/show.html.twig'));
    }
}