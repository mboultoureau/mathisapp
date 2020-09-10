<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categorie;
use App\Entity\Produit;

class ProduitFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $produits = array(
            array(
                'nom' => 'Boissons',
                'slug' => 'boissons',
                'image' => 'boissons.svg',
                'produits' => array(
                    1 => array(
                        'nom' => 'Eau',
                        'description' => 'Le goût originel de l\'eau',
                        'prix' => 0.5,
                        'slug' => 'eau',
                        'image' => 'eau.jpg'
                    ),
                    2 => array(
                        'nom' => 'Coca-Cola',
                        'description' => 'Ouvre un Coca-Cola, ouvre du bonheur',
                        'prix' => 1.5,
                        'slug' => 'coca-cola',
                        'image' => 'coca-cola.jpg'
                    ),
                    3 => array(
                        'nom' => 'Limonade',
                        'description' => 'Comble votre soif',
                        'prix' => 0.95,
                        'slug' => 'limonade',
                        'image' => 'limonade.jpg'
                    )
                )
            ),
            array(
                'nom' => 'Salades',
                'slug' => 'salades',
                'image' => 'salades.svg',
                'produits' => array(
                    1 => array(
                        'nom' => 'Salade César',
                        'description' => 'Une valeur sure',
                        'prix' => 4.75,
                        'slug' => 'cesar',
                        'image' => 'cesar.jpg'
                    ),
                    2 => array(
                        'nom' => 'Salade tahitienne',
                        'description' => 'Régalez-vous !',
                        'prix' => 4.75,
                        'slug' => 'tahitienne',
                        'image' => 'tahitienne.jpg'
                    )
                )
            ),
            array(
                'nom' => 'Desserts',
                'slug' => 'desserts',
                'image' => 'desserts.svg',
                'produits' => [
                    1 => array(
                        'nom' => 'Tiramisu',
                        'description' => 'Le meilleur dessert possible',
                        'prix' => 6.5,
                        'slug' => 'tiramisu',
                        'image' => 'tiramisu.jpg'
                    )
                ]
            ),
            array(
                'nom' => 'Pizzas',
                'slug' => 'pizzas',
                'image' => 'pizzas.svg',
                'produits' => array()
            ),
            array(
                'nom' => 'Plats',
                'slug' => 'plats',
                'image' => 'plats.svg',
                'produits' => array()
            )
        );

        foreach($produits as $cat) {
            $categorie = new Categorie();
            $categorie  ->setNom($cat['nom'])
                        ->setSlug($cat['slug'])
                        ->setImage($cat['image']);

            $manager->persist($categorie);

            foreach($cat['produits'] as $pro) {
                $produit = new Produit();
                $produit->setNom($pro['nom'])
                        ->setDescription($pro['description'])
                        ->setPrix($pro['prix'])
                        ->setSlug($pro['slug'])
                        ->setImage($pro['image'])
                        ->setCategorie($categorie);

                $manager->persist($produit);
            }
        }

        $manager->flush();
    }
}
