<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ConfirmDeletionFormType;
use App\Form\ProductFormType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Autoriser l'accès qu'aux administrateurs sur toutes les routes de ce controlleur:
 * @IsGranted("ROLE_ADMIN")
 *
 * Spécifier un préfixe d'URI et de nom de route:
 * @Route("/admin/product", name="admin_product_")
 */
class AdminProductController extends AbstractController
{
    /**
     * Liste des produits. On combine l'annotation Route de la classe avec celle de la méthode
     *      URI:    /admin/products
     *      name:   admin_product_list
     * @Route("s", name="list")
     */
    public function index(ProductRepository $repository)
    {
        $products = $repository->findAll();
        return $this->render('admin_product/index.html.twig', [
            'product_list' => $products
        ]);
    }

    /**
     * @Route("/new", name="add")
     */
    public function add(Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ProductFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', 'Le produit a été enregistré.');
            return $this->redirectToRoute('admin_product_list');
        }

        return $this->render('admin_product/add.html.twig', [
            'product_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit")
     */
    public function edit(Product $product, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Modifications enregistrées.');
        }

        return $this->render('admin_product/edit.html.twig', [
            'product' => $product,
            'product_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(Product $product, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ConfirmDeletionFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->remove($product);
            $entityManager->flush();

            $this->addFlash('success', 'Le produit a été supprimmé.');
            return $this->redirectToRoute('admin_product_list');
        }

        return  $this->render('admin_product/delete.html.twig', [
            'product' => $product,
            'deletion_form' => $form->createView()
        ]);
    }
}
