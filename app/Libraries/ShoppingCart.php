<?php

namespace App\Libraries;

class ShoppingCart
{
 protected $session;

    public function __construct(){
        //Accès à la session
        $this->session = session();

         //Initialisation du panier vide
        if(!$this->session->has('cart')){ // has verifie si on a un panier exsistant
            $this->session->set('cart',[ //set creer le tableau du panier
                'items'=> [],
                'count'=> 0,
                'total'=> 0,
            ]);
        }
    }

    public function addProduct(array $product)
    {
        //Récuperer le panier actuel depuis la session, si je n'en ai pas dans ma session alors je lui met un panier vide ( ce cas "panier vide" ne devrait jamais arriver car nous avons déjà initialisé le panier avec la function precedente)
        $cart = $this->session->get('cart') ?? ['items' => [], 'count' => 0, 'total' => 0];

        //verifier si le produit existe déja dans le panier
        $found = false;
        foreach ($cart['items'] as &$item) { //le & devant $item permet de garder sa valeur de maniere persistante
            if ($item['id'] == $product['id']) {
                //si le produit existe deja dans mon panier alors j'augmente sa quantité
                $item['quantity'] += $product['quantity'];
                $found = true;
                break;
            }
        }

            //le produit n'as pas été trouvé dans la panier car il n'existe pas encore, alors je l'ajoute dans le panier
            if (!$found) {
                $cart['items'][] = $product;
            }
            $cart['total'] = $this->caculateTotal($cart['items']);
            $cart['count'] = $this->calculateCountItem($cart['items']);
            //mettre à jour le panier
            $this->session->set('cart', $cart);

    }
    //calculer le total du panier
    protected function caculateTotal(array $items)
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $item['quantity'] * $item['price']; //on suppose que chaque produit a un 'price' et une 'quantity'
        }
        return $total;
    }

    //calculer le nombre d'ojet dans le panier
    protected function calculateCountItem(array $items)
    {
        $count = 0;
        foreach ($items as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }
}