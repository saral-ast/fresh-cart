<?php

namespace App\Services;

class OrderService
{
    /**
     * Get the current order data from session
     *
     * @return array
     */
    public function getOrderData()
    {
        return session()->get('order_data', [
            'address' => [],
            'payment' => [],
            'cart' => []
        ]);
    }

    /**
     * Store address information in session
     *
     * @param array $addressData
     * @return void
     */
    public function storeAddress($addressData)
    {
        $orderData = $this->getOrderData();
        $orderData['address'] = $addressData;
        $this->updateOrderData($orderData);
    }

    /**
     * Store payment information in session
     *
     * @param array $paymentData
     * @return void
     */
    public function storePayment($paymentData)
    {
        $orderData = $this->getOrderData();
        $orderData['payment'] = $paymentData;
        $this->updateOrderData($orderData);
    }

    /**
     * Store cart information in session
     *
     * @param array $cartData
     * @return void
     */
    public function storeCart($cartData)
    {
        $orderData = $this->getOrderData();
        $orderData['cart'] = $cartData;
        $this->updateOrderData($orderData);
    }

    /**
     * Update the order data in session
     *
     * @param array $orderData
     * @return void
     */
    private function updateOrderData($orderData)
    {
        session()->put('order_data', $orderData);
    }

    /**
     * Clear the order data from session
     *
     * @return void
     */
    public function clearOrderData()
    {
        session()->forget('order_data');
    }

    /**
     * Check if order data exists in session
     *
     * @return bool
     */
    public function hasOrderData()
    {
        return session()->has('order_data');
    }

    /**
     * Get address data from session
     *
     * @return array
     */
    public function getAddressData()
    {
        $orderData = $this->getOrderData();
        return $orderData['address'] ?? [];
    }

    /**
     * Get payment data from session
     *
     * @return array
     */
    public function getPaymentData()
    {
        $orderData = $this->getOrderData();
        return $orderData['payment'] ?? [];
    }

    /**
     * Get cart data from session
     *
     * @return array
     */
    public function getCartData()
    {
        $orderData = $this->getOrderData();
        return $orderData['cart'] ?? [];
    }
}