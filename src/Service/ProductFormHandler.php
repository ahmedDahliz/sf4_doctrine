<?php


namespace App\Service;


use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductFormHandler
{

    private $em;

    /**
     * ProductFormHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function handle(Request $request, $form)
    {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $this->em->persist($product);
            $this->em->flush();
            return true;
        }
        return false;
    }
}