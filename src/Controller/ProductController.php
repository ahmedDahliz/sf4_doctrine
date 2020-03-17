<?php


namespace App\Controller;


use App\Entity\Product;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProductController
{
    private $twig;
    private $router;
    private $session;
    private $products = [];

    /**
     * PageController constructor.
     */
    public function __construct(Environment $twig,RouterInterface $router, SessionInterface $session)
    {
        $this->twig = $twig;
        $this->router = $router;
        $this->session = $session;
    }

    /**
     * @Route("/products", name="products.index")
     */
    public function index()
    {
        return new Response($this->twig->render('product/index.html.twig', ['products' => $this->session->get('products')]));
    }

    /**
     * @Route("/products/edit", name="products.edit")
     */
    public function edit()
    {
        return new Response($this->twig->render('product/edit.html.twig'));
    }

    /**
     * @Route("/products/add", name="products.add")
     */
    public function add()
    {
        return new Response($this->twig->render('product/add.html.twig'));
    }

    /**
     * @Route("/products/save", name="products.save")
     * @param Request $request
     * @return RedirectResponse
     */
    public function save(Request $request)
    {
        if ($request->getMethod() == 'POST') {
            if ($this->session->has('products')) {
                $product = $this->session->get('products');
                $product[] = new Product(mt_rand(1, 1000), $request->get('Name'), $request->get('Price'), $request->get('Quantity'), $request->get('Description'), 'https://hbr.org/resources/images/article_assets/2019/11/Nov19_14_sb10067951dd-001.jpg', date("d/m/Y"));
                $this->session->set('products', $product);
            } else {
                $this->products[] = new Product(1, $request->get('Name'), $request->get('Price'), $request->get('Quantity'), $request->get('Description'), 'https://hbr.org/resources/images/article_assets/2019/11/Nov19_14_sb10067951dd-001.jpg', date("d/m/Y"));
                $this->session->set('products', $this->products);
            }
        }
        return new RedirectResponse($this->router->generate('products.index'), 301);
    }

    /**
     * @Route("/products/show/{idProduct}", name="products.show")
     */
    public function show($idProduct)
    {
        return new Response($this->twig->render('product/show.html.twig', ['id'=> $idProduct]));
    }
}