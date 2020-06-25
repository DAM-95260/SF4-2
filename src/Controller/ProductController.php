<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product_list")
     */
    public function index(ProductRepository $repository)
    {
        $product_list = $repository->findAll();

        return $this->render('product/index.html.twig', [
            'product_list' => $product_list
        ]);
    }

    /**
     * Grace au ParamConverter (installé par FrameworkExtraBundel)
     * Symfony va récupérer l'entité Product qui correspond à l'identifiant dans l'URI
     * @Route("/product/{id}", name="product_show")
     */
    public function show(Product $product)
    {
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}