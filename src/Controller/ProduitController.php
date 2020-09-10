<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ProduitController extends AbstractController
{

    /**
     * @Route("/produits/{categorieSlug}/{produitSlug}", name="produit.view")
     */
    public function index($categorieSlug, $produitSlug, CategorieRepository $categorieRepository, ProduitRepository $produitRepository): Response
    {

        $categorie = $categorieRepository->findOneBy([
            'slug' => $categorieSlug
        ]);


        if (!$categorie) {
            throw $this->createNotFoundException('Cette catégorie n\'existe pas.');
        }

        $produit = $produitRepository->findOneBy([
            'categorie' => $categorie,
            'slug' => $produitSlug
        ]);
        
        if (!$produit) {
            throw $this->createNotFoundException('Ce produit n\'existe pas.');
        }


        return $this->render('produit/view.html.twig', [
            'controller_name' => 'ProduitController',
            'produit' => $produit,
            'categorie' => $categorie
        ]);
    }
}
