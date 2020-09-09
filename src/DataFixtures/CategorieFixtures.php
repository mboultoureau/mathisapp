<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categorie;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = array(
            array(
                'nom' => 'Boissons',
                'slug' => 'boissons',
                'image' => 'boissons.svg'
            ),
            array(
                'nom' => 'Salades',
                'slug' => 'salades',
                'image' => 'salades.svg'
            ),
            array(
                'nom' => 'Desserts',
                'slug' => 'desserts',
                'image' => 'desserts.svg'
            ),
            array(
                'nom' => 'Pizzas',
                'slug' => 'pizzas',
                'image' => 'pizzas.svg'
            ),
            array(
                'nom' => 'Plats',
                'slug' => 'plats',
                'image' => 'plats.svg'
            )
        );

        foreach($categories as $cat) {
            $categorie = new Categorie();
            $categorie->setNom($cat['nom']);
            $categorie->setSlug($cat['slug']);
            $categorie->setImage($cat['image']);
            
            $manager->persist($categorie);
        }

        $manager->flush();
    }
}
