<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;
use App\Entity\Product;
use DateTime;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $products = array(
            array(
                'name' => 'Boissons',
                'slug' => 'boissons',
                'image' => 'boissons.svg',
                'products' => array(
                    1 => array(
                        'name' => 'Eau',
                        'description' => 'Le goût originel de l\'eau',
                        'price' => 0.5,
                        'slug' => 'eau',
                        'filename' => 'eau.jpg'
                    ),
                    2 => array(
                        'name' => 'Coca-Cola',
                        'description' => 'Ouvre un Coca-Cola, ouvre du bonheur',
                        'price' => 1.5,
                        'slug' => 'coca-cola',
                        'filename' => 'coca-cola.jpg'
                    ),
                    3 => array(
                        'name' => 'Limonade',
                        'description' => 'Comble votre soif',
                        'price' => 0.95,
                        'slug' => 'limonade',
                        'filename' => 'limonade.jpg'
                    )
                )
            ),
            array(
                'name' => 'Salades',
                'slug' => 'salades',
                'image' => 'salades.svg',
                'products' => array(
                    1 => array(
                        'name' => 'Salade César',
                        'description' => 'Une valeur sure',
                        'price' => 4.75,
                        'slug' => 'cesar',
                        'filename' => 'cesar.jpg'
                    ),
                    2 => array(
                        'name' => 'Salade tahitienne',
                        'description' => 'Régalez-vous !',
                        'price' => 4.75,
                        'slug' => 'tahitienne',
                        'filename' => 'tahitienne.jpg'
                    )
                )
            ),
            array(
                'name' => 'Desserts',
                'slug' => 'desserts',
                'image' => 'desserts.svg',
                'products' => [
                    1 => array(
                        'name' => 'Tiramisu',
                        'description' => 'Le meilleur dessert possible',
                        'price' => 6.5,
                        'slug' => 'tiramisu',
                        'filename' => 'tiramisu.jpg'
                    )
                ]
            ),
            array(
                'name' => 'Pizzas',
                'slug' => 'pizzas',
                'image' => 'pizzas.svg',
                'products' => array()
            ),
            array(
                'name' => 'Plats',
                'slug' => 'plats',
                'image' => 'plats.svg',
                'products' => array()
            )
        );

        foreach ($products as $cat) {
            $category = new Category();
            $category->setName($cat['name'])
                ->setSlug($cat['slug'])
                ->setImage($cat['image'])
                ->setIcon($cat['icon']);

            $manager->persist($category);

            foreach ($cat['products'] as $pro) {
                $product = new Product();
                $product->setName($pro['name'])
                    ->setDescription($pro['description'])
                    ->setPrice($pro['price'])
                    ->setSlug($pro['slug'])
                    ->setFilename($pro['filename'])
                    ->setUpdatedAt(new DateTime('now'))
                    ->setCategory($category);

                $manager->persist($product);
            }
        }

        $manager->flush();
    }
}
