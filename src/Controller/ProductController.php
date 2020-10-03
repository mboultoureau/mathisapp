<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{

    private CategoryRepository $categoryRepository;
    private ProductRepository $productRepository;
    private EntityManagerInterface $em;

    public function __construct(CategoryRepository $categoryRepository, ProductRepository $productRepository, EntityManagerInterface $em)
    {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->em = $em;
    }

    /**
     * @Route("/produits/{categorySlug}/{productSlug}", name="product.view")
     */
    public function index($categorySlug, $productSlug): Response
    {
        $category = $this->categoryRepository->findOneBy([
            'slug' => $categorySlug
        ]);

        if (!$category) {
            throw $this->createNotFoundException('Cette catégorie n\'existe pas.');
        }

        $product = $this->productRepository->findOneBy([
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
    public function list()
    {
        $products = $this->productRepository->findAll();

        return $this->render('product/list.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/admin/produit/creation", name="admin.product.create")
     * @Route("/admin/produit/{categorySlug}/{productSlug}/edition", name="admin.product.edit")
     */
    public function form($categorySlug = null, $productSlug = null, Request $request)
    {
        if (!$categorySlug && !$productSlug) {
            $category = new Category();
            $product = new Product();
        } else {
            $category = $this->categoryRepository->findOneBy([
                'slug' => $categorySlug
            ]);

            if (!$category) {
                throw $this->createNotFoundException('Cette catégorie n\'existe pas.');
            }

            $product = $this->productRepository->findOneBy([
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
            $this->em->persist($product);
            $this->em->flush();

            return $this->redirectToRoute('admin.product.list');
        }

        return $this->render('product/form.html.twig', [
            'formProduct' => $form->createView(),
            'editMode' => $category->getId() !== null
        ]);
    }

    /**
     * @Route("/admin/produit/{categorySlug}/{productSlug}/suppression", name="admin.product.delete")
     */
    public function delete($categorySlug, $productSlug)
    {
        $category = $this->categoryRepository->findOneBy([
            'slug' => $categorySlug
        ]);

        if (!$category) {
            throw $this->createNotFoundException('Cette catégorie n\'existe pas.');
        }

        $product = $this->productRepository->findOneBy([
            'category' => $category,
            'slug' => $productSlug
        ]);

        if (!$product) {
            throw $this->createNotFoundException('Ce produit n\'existe pas.');
        }

        $this->em->remove($product);
        $this->em->flush();

        return $this->redirectToRoute('admin.product.list');
    }
}
