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
        // findAll() / findBy() / findOneBy() / find()

        // findBy() va effectuer une comparaison d'égalité, alors que nous souhaitons
        //effectuer une comparaison de supériorité
        // solution: créer notre propre méthode dans le ProductRepository

        // On utilise notre propre méthode pour récupérer les nouveautés
        $result = $repository->findNews();
        return $this->render('home/index.html.twig', [
            'new_products' => $result
        ]);
    }
}
