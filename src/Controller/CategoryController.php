<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;


class CategoryController extends AbstractController
{
    /**
     * @Route("/produits", name="category.index")
     */
    public function index(CategoryRepository $categoryRepository)
    {
        $categorys = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categorys' => $categorys
        ]);
    }

    /**
     * @Route("/admin/categories", name="admin.category.list")
     */
    public function list(CategoryRepository $categoryRepository)
    {
        $categorys = $categoryRepository->findAll();

        return $this->render('category/list.html.twig', [
            'categorys' => $categorys
        ]);
    }

    /**
     * @Route("/produits/{slug}", name="category.view")
     */
    public function view(Category $category, ProductRepository $productRepository)
    {
        $products = $productRepository->findBy([
            'category' => $category
        ]);

        return $this->render('category/view.html.twig', [
            'category' => $category,
            'products' => $products
        ]);
    }

    /**
     * @Route("/admin/categorie/creation", name="admin.category.create")
     * @Route("/admin/categorie/{slug}/edition", name="admin.category.edit")
     */
    public function form(Category $category = null, Request $request, EntityManagerInterface $entityManager)
    {
        if (!$category) {
            $category = new Category();
        }

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('admin.category.list');
        }

        return $this->render('category/form.html.twig', [
            'formCategory' => $form->createView(),
            'editMode' => $category->getId() !== null
        ]);
    }
}
