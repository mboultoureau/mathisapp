<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;


class CategorieController extends AbstractController
{
    /**
     * @Route("/produits", name="categorie.index")
     */
    public function index(CategorieRepository $categorieRepository)
    {
        $categories = $categorieRepository->findAll();

        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/produits/{slug}", name="categorie.view")
     */
    public function view(Categorie $categorie, ProduitRepository $produitRepository)
    {
        $produits = $produitRepository->findBy([
            'categorie' => $categorie
        ]);

        return $this->render('categorie/view.html.twig', [
            'controller_name' => 'CategorieController',
            'categorie' => $categorie,
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/admin/categorie/creation", name="categorie.creation")
     * @Route("/admin/categorie/{slug}/edition", name="categorie.edition")
     */
    public function form(Categorie $categorie = null, Request $request, EntityManagerInterface $entityManager)
    {
        if (!$categorie) {
            $categorie = new Categorie();
        }

        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('categorie.creation');
        }

        return $this->render('categorie/form.html.twig', [
            'controller_name' => 'CategorieController',
            'formCategorie' => $form->createView(),
            'editMode' => $categorie->getId() !== null
        ]);
    }
}
