<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetail;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class OrderController extends AbstractController
{

    private $session;
    private $entityManager;
    private $twig;
    private $productRepo;
    private $router;
    private $flash;

    public function __construct(Environment $twig,SessionInterface $session,RouterInterface $router, ProductRepository $prodRepo, EntityManagerInterface $entityManager,  FlashBagInterface $flashBag)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
        $this->twig = $twig;
        $this->productRepo = $prodRepo;
        $this->router = $router;
        $this->flash = $flashBag;
    }


    /**
     * @Route("/order", name="order.index")
     */
    public function index()
    {
        $order = new Order();
        $this->entityManager->persist($order);
        $basket = $this->session->get('basket');
        if ($this->session->has('basket')) {
            foreach ($basket as $key=> $product){
                $productToOrder =  $this->productRepo->find($product['product']);
                $productToOrder->setQuantity((int)$productToOrder->getQuantity() - (int)$product['quantity']);
                $orderDetail = new OrderDetail();
                $orderDetail->setOrderProduct($order);
                $orderDetail->setProduct($productToOrder);
                $orderDetail->setQuantity($product['quantity']);
                $this->entityManager->persist($orderDetail);
            }
            $this->entityManager->flush();
            $this->session->clear();
            $this->flash->add('success', 'Your command saved successfully !');
        }
        return $this->render('order/index.html.twig');
    }


    /**
     * @Route("/order/addToBasket/{idProduct}", name="order.tobasket")
     * @param Request $request
     * @param $idProduct
     * @return RedirectResponse
     */
    public function addToBasket(Request $request, $idProduct)
    {
        $product =  $this->productRepo->find($idProduct);
        if ($this->session->has('basket')) {
            $basket = $this->session->get('basket');
            $basket[]['product'] = $product;
            $basket[array_key_last($basket)]['quantity'] = $request->get('commandQuantity');
            $this->session->set('basket', $basket);
        } else {
            $basket = [];
            $basket[]['product'] = $product;
            $basket[array_key_last($basket)]['quantity'] = $request->get('commandQuantity');
            $this->session->set('basket', $basket);
        }
        $this->flash->add('success', 'The product is added to basket !');
        return new RedirectResponse($this->router->generate('products.index'));
    }

    /**
     * @Route("/order/basket/delete/{idProduct}", name="order.delete")
     * @param $idProduct
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function deletefomBasket($idProduct)
    {
        $basket = $this->session->get('basket');
        foreach ($basket as $key => $product) {
            if ($product['product']->getId() == $idProduct){
                unset($basket[$key]);
                break;
            }
        }
        $this->session->set('basket', $basket);
        $this->flash->add('warning', 'The product is removed from the basket !');

        return new Response($this->twig->render('order/index.html.twig'));
    }

    /**
     * @Route("/order/basket", name="order.basket")
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function basket()
    {
        return new Response($this->twig->render('order/index.html.twig'));
    }
}
