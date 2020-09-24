<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ProductController extends AbstractController
{

    /**
     * @Route("/produits/{categorySlug}/{productSlug}", name="product.view")
     */
    public function index($categorySlug, $productSlug, CategoryRepository $categoryRepository, ProductRepository $productRepository): Response
    {
        $category = $categoryRepository->findOneBy([
            'slug' => $categorySlug
        ]);

        if (!$category) {
            throw $this->createNotFoundException('Cette catégorie n\'existe pas.');
        }

        $product = $productRepository->findOneBy([
            'category' => $category,
            'slug' => $productSlug
        ]);
        
        if (!$product) {
            throw $this->createNotFoundException('Ce produit n\'existe pas.');
        }

        return $this->render('product/view.html.twig', [
            'product' => $product,
            'category' => $category
        ]);
    }

    /**
     * @Route("/admin/produits", name="admin.product.list")
     */
    public function list(ProductRepository $productRepository) {
        $products = $productRepository->findAll();

        return $this->render('product/list.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/admin/produit/creation", name="admin.product.create")
     * @Route("/admin/produit/{categorySlug}/{productSlug}/edition", name="admin.product.edit")
     */
    public function form($categorySlug = null, $productSlug = null, CategoryRepository $categoryRepository,
        ProductRepository $productRepository, Request $request, EntityManagerInterface $entityManager)
    {
        if (!$categorySlug && !$productSlug) {
            $category = new Category();
            $product = new Product();
        } else {
            $category = $categoryRepository->findOneBy([
                'slug' => $categorySlug
            ]);
    
            if (!$category) {
                throw $this->createNotFoundException('Cette catégorie n\'existe pas.');
            }
    
            $product = $productRepository->findOneBy([
                'category' => $category,
                'slug' => $productSlug
            ]);
            
            if (!$product) {
                throw $this->createNotFoundException('Ce produit n\'existe pas.');
            }
        }

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('admin.product.list');
        }

        return $this->render('product/form.html.twig', [
            'formProduct' => $form->createView(),
            'editMode' => $category->getId() !== null
        ]);
    }
}
