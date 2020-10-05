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
use Exception;

class CategoryController extends AbstractController
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
     * @Route("/produits", name="category.index")
     */
    public function index()
    {
        $categories = $this->categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/admin/categories", name="admin.category.list")
     */
    public function list()
    {
        $categories = $this->categoryRepository->findAll();

        return $this->render('category/list.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/produits/{slug}", name="category.view")
     */
    public function view(Category $category)
    {
        $products = $this->productRepository->findBy([
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
    public function form(Category $category = null, Request $request)
    {
        if (!$category) {
            $category = new Category();
        }

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($category);
            $this->em->flush();

            return $this->redirectToRoute('admin.category.list');
        }

        return $this->render('category/form.html.twig', [
            'formCategory' => $form->createView(),
            'editMode' => $category->getId() !== null
        ]);
    }

    /**
     * @Route("/admin/categorie/{slug}/suppression", name="admin.category.delete")
     */
    public function delete(Category $category)
    {
        $products = $this->productRepository->findBy([
            'category' => $category
        ]);

        if (empty($products)) {
            $this->em->remove($category);
            $this->em->flush();

            return $this->redirectToRoute('admin.category.list');
        } else {
            throw new Exception("Cette catégorie contient toujours des produits");
        }
    }
}
