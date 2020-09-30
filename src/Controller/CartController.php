<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart.view")
     */
    public function index(CartService $cartService)
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cartService->get(),
            'total' => $cartService->getTotal()
        ]);
    }

    /**
     * @Route("/panier/ajout/{id}", name="cart.add")
     */
    public function add($id, CartService $cartService)
    {
        $cartService->add($id);

        return $this->redirectToRoute('cart.view');
    }

    /**
     * @Route("/panier/suppression/{id}", name="cart.remove")
     */
    public function remove($id, CartService $cartService)
    {
        $cartService->remove($id);

        return $this->redirectToRoute('cart.view');
    }
}
