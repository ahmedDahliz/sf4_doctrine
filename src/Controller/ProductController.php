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
     * @Route("/products/edit/{idProduct}", name="products.edit")
     * @param $idProduct
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit($idProduct)
    {
        $product = [];
        foreach ($this->session->get('products') as $prod) {
            if ($prod->getId() == $idProduct){
                    $product = $prod;
                    break;
            }
        }
        return new Response($this->twig->render('product/edit.html.twig', ['product' => $product]));
    }

    /**
     * @Route("/products/update/{idProduct}", name="products.update")
     * @param Request $request
     * @param $idProduct
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function update(Request $request, $idProduct)
    {
        $products = $this->session->get('products');
        foreach ($products as $key => $prod) {
            if ($prod->getId() == $idProduct){
                $products[$key]->setName($request->get('Name'));
                $products[$key]->setPrice($request->get('Price'));
                $products[$key]->setQuantity($request->get('Quantity'));
                $products[$key]->setDescription($request->get('Description'));
                $this->session->set('products', $products);
                break;
            }
        }
        return new RedirectResponse($this->router->generate('products.index'));
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
        $products = [];
        if ($request->getMethod() == 'POST') {
            if ($this->session->has('products')) {
                $products = $this->session->get('products');

                $products[] = new Product(end($products)->getId()+1, $request->get('Name'), $request->get('Price'), $request->get('Quantity'), $request->get('Description'), 'https://hbr.org/resources/images/article_assets/2019/11/Nov19_14_sb10067951dd-001.jpg', date("d/m/Y"));
                $this->session->set('products', $products);
            } else {
                $products[] = new Product(1, $request->get('Name'), $request->get('Price'), $request->get('Quantity'), $request->get('Description'), 'https://hbr.org/resources/images/article_assets/2019/11/Nov19_14_sb10067951dd-001.jpg', date("d/m/Y"));
                $this->session->set('products', $products);
            }
        }
        return new RedirectResponse($this->router->generate('products.index'));
    }

    /**
     * @Route("/products/delete/{idProduct}", name="products.delete")
     * @param $idProduct
     * @return RedirectResponse
     */
    public function delete($idProduct)
    {
            $products = $this->session->get('products');
            foreach ($products as $key => $product) {
                if ($product->getId() == $idProduct){
                    unset($products[$key]);
                    break;
                }
            }
            $this->session->set('products', $products);

        return new RedirectResponse($this->router->generate('products.index'), 301);
    }


    /**
     * @Route("/products/show/{idProduct}", name="products.show")
     * @param $idProduct
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show($idProduct)
    {
        return new Response($this->twig->render('product/show.html.twig', ['id'=> $idProduct]));
    }
}