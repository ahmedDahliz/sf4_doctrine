<?php


namespace App\Controller;


use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
     * @Route("/products", name="products.index")
     */
    public function index()
    {
        $products = [];
        $products[] = new Product(1,'prod1',123,12,'description1','https://hbr.org/resources/images/article_assets/2019/11/Nov19_14_sb10067951dd-001.jpg','2020-03-12');
        $products[] = new Product(2,'prod2',1223,10,'description2','https://hbr.org/resources/images/article_assets/2019/11/Nov19_14_sb10067951dd-001.jpg','2020-03-12');
        $products[] = new Product(3,'prod3',194,2,'description3','https://hbr.org/resources/images/article_assets/2019/11/Nov19_14_sb10067951dd-001.jpg','2020-03-12');
        $products[] = new Product(4,'prod4',323,32,'description4','https://hbr.org/resources/images/article_assets/2019/11/Nov19_14_sb10067951dd-001.jpg','2020-03-12');
        $products[] = new Product(5,'prod5',243,84,'description5','https://hbr.org/resources/images/article_assets/2019/11/Nov19_14_sb10067951dd-001.jpg','2020-03-12');
        $products[] = new Product(6,'prod6',673,15,'description6','https://hbr.org/resources/images/article_assets/2019/11/Nov19_14_sb10067951dd-001.jpg','2020-03-12');
        $products[] = new Product(7,'prod7',1353,37,'description7','https://hbr.org/resources/images/article_assets/2019/11/Nov19_14_sb10067951dd-001.jpg','2020-03-12');
        $products[] = new Product(8,'prod8',233,22,'description8','https://hbr.org/resources/images/article_assets/2019/11/Nov19_14_sb10067951dd-001.jpg','2020-03-12');


        return new Response($this->twig->render('product/index.html.twig', ['products' => $products]));
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
     * @Route("/products/show", name="products.show")
     */
    public function show()
    {
        return new Response($this->twig->render('product/show.html.twig'));
    }
}