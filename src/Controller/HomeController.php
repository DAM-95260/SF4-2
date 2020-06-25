<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ProductRepository $repository)
    {
        
        $result = $repository->findNews();
        return $this->render('home/index.html.twig', [
            'new_products' => $repository->findAll()
        ]);
    }
}
