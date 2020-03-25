<?php


namespace App\Controller;


use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\OrderDetailRepository;
use App\Repository\ProductRepository;
use App\Service\ProductFormHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProductController extends AbstractController
{
    private $twig;
    private $router;
    private $session;
    private $entityManager;
    private $productRepo;
    private $flashbag;
    /**
     * PageController constructor.
     * @param Environment $twig
     * @param RouterInterface $router
     * @param EntityManagerInterface $entityManager
     * @param ProductRepository $prodRepo
     */
    public function __construct(Environment $twig,RouterInterface $router, EntityManagerInterface $entityManager, ProductRepository $prodRepo, SessionInterface $session,  FlashBagInterface $flashBag)
    {
        $this->twig = $twig;
        $this->router = $router;
        $this->entityManager = $entityManager;
        $this->productRepo = $prodRepo;
        $this->session = $session;
        $this->flashbag = $flashBag;
    }

    /**
     * @Route("/products", name="products.index")
     * @param ProductRepository $prodRepo
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        return new Response($this->twig->render('product/index.html.twig', ['products' =>  $this->productRepo->findAll()]));
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
        $product =  $this->productRepo->find($idProduct);

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
        $product = $this->productRepo->find($idProduct);
        $product->setName($request->get('Name'));
        $product->setPrice($request->get('Price'));
        $product->setQuantity($request->get('Quantity'));
        $product->setDescription($request->get('Description'));
        $this->entityManager->flush();

        $this->flashbag->add('success', 'The product is edited successfully');

        return new RedirectResponse($this->router->generate('products.index'));
    }

    /**
     * @Route("/products/add", name="products.add")
     */
    public function add()
    {
        //for Q2
        //$form = $this->createFormBuilder($product)
        //->add('Name', TextType::class)
        //->add('Price', MoneyType::class)
        //->add('Quantity', IntegerType::class)
        //->add('imageUrl', HiddenType::class, array(
        //'label' => 'Image',
        //'data' => 'https://hbr.org/resources/images/article_assets/2019/11/Nov19_14_sb10067951dd-001.jpg'
        //))
        //->add('Description', TextareaType::class)
        //->add('save', SubmitType::class, ['label' => 'Submit'])
        //->getForm();
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        return new Response($this->twig->render('product/add.html.twig', ['form'=> $form->createView()]));
    }

    /**
     * @Route("/products/save", name="products.save")
     * @param Request $request
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function save(Request $request, ProductFormHandler $formHandler)
    {

        // for Q2 TP1
        //$form = $this->createFormBuilder($product)
        //   ->add('Name', TextType::class)
        //   ->add('Price', MoneyType::class)
        //   ->add('Quantity', IntegerType::class)
        //   ->add('Description', TextareaType::class)
        //   ->add('imageUrl', TextareaType::class, array(
        //      'label' => 'Image',
        //    'data' => 'https://hbr.org/resources/images/article_assets/2019/11/Nov19_14_sb10067951dd-001.jpg'
        //))
        //->add('save', SubmitType::class, ['label' => 'Submit'])
        //->getForm();
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        if ($formHandler->handle($request, $form)){
            return $this->redirectToRoute('products.index');
        }
        return new Response($this->twig->render('product/add.html.twig', ['form'=> $form->createView()]));
    }

    /**
     * @Route("/products/delete/{idProduct}", name="products.delete")
     * @param $idProduct
     * @return RedirectResponse
     */
    public function delete($idProduct)
    {
        $product =  $this->productRepo->find($idProduct);
        $this->entityManager->remove($product);
        $this->entityManager->flush();
        $this->flashbag->add('warning', 'The product is deleted');

        return new RedirectResponse($this->router->generate('products.index'));
    }


    /**
     * @Route("/products/show/{idProduct}", name="products.show")
     * @param $idProduct
     * @param OrderDetailRepository $orderDRepo
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function show($idProduct, OrderDetailRepository $orderDRepo)
    {
        $product =  $this->productRepo->find($idProduct);
        $orderDetails = $orderDRepo->findBy(array('product'=> $product));
        return new Response($this->twig->render('product/show.html.twig', ['product'=> $product, 'orderDetails'=> $orderDetails]));
    }

}