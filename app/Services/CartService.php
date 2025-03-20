<?php

namespace App\Services;

use App\Models\Admin\Product;

class CartService
{
    /**
     * Get the current cart from session
     *
     * @return array
     */
    public function getCart()
    {
        return session()->get('cart', []);
    }

    /**
     * Get the total number of items in cart
     *
     * @return int
     */
    public function getCartCount()
    {
        return count($this->getCart());
    }

    /**
     * Calculate the total price of all items in cart
     *
     * @return float
     */
    public function getCartTotal()
    {
        $total = 0;
        $cart = $this->getCart();
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return $total;
    }

    /**
     * Add a product to cart
     *
     * @param string $slug
     * @return array
     */
    public function addToCart($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $cart = $this->getCart();
        
        if (isset($cart[$product->slug])) {
            $cart[$product->slug]['quantity']++;
        } else {
            $cart[$product->slug] = [
                "id" => $product->id,
                "name" => $product->name,
                "slug" => $product->slug,
                "quantity" => 1,
                "description" => $product->description,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
        
        $this->updateCart($cart);
        
        return [
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cartCount' => $this->getCartCount()
        ];
    }

    /**
     * Update product quantity in cart
     *
     * @param string $slug
     * @param int $quantity
     * @return array
     */
    public function updateCartItem($slug, $quantity)
    {
        $cart = $this->getCart();
        
        if (!isset($cart[$slug])) {
            return [
                'success' => false,
                'message' => 'Item not found'
            ];
        }
        
        $cart[$slug]['quantity'] = $quantity;
        $this->updateCart($cart);
        
        $newTotal = $cart[$slug]['price'] * $quantity;
        $cartTotal = $this->getCartTotal();
        
        return [
            'success' => true,
            'new_total' => number_format($newTotal, 2),
            'cartTotal' => number_format($cartTotal, 2),
        ];
    }

    /**
     * Remove a product from cart
     *
     * @param string $slug
     * @return array
     */
    public function removeFromCart($slug)
    {
        $cart = $this->getCart();
        
        if (!isset($cart[$slug])) {
            return [
                'success' => false,
                'message' => 'Product not found in cart.'
            ];
        }
        
        unset($cart[$slug]);
        $this->updateCart($cart);
        
        return [
            'success' => true,
            'message' => 'Product removed from cart successfully!',
            'cartCount' => $this->getCartCount(),
            'total' => $this->getCartTotal()
        ];
    }

    /**
     * Clear the entire cart
     *
     * @return void
     */
    public function clearCart()
    {
        session()->forget('cart');
    }

    /**
     * Update the cart in session
     *
     * @param array $cart
     * @return void
     */
    private function updateCart($cart)
    {
        session()->put('cart', $cart);
    }

    /**
     * Check if a product exists in cart
     *
     * @param string $slug
     * @return bool
     */
    public function itemExistsInCart($slug)
    {
        $cart = $this->getCart();
        return isset($cart[$slug]);
    }

    /**
     * Get a specific item from cart
     *
     * @param string $slug
     * @return array|null
     */
    public function getCartItem($slug)
    {
        $cart = $this->getCart();
        return $cart[$slug] ?? null;
    }
}