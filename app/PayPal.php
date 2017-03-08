<?php

namespace App;


use PayPal\Exception\PayPalConnectionException;

class PayPal
{

    private $_apiContext;
    private $shopping_cart;
    private $_ClientId = 'Aag9zFq3RCAyw7fLS5opfXQ5QLriYaBf6S8Dm-0PdINuCzzLMCtdhSW0SY2I7AneZjsMC-_pXdiUb4eI';
    private $_ClientSecret = 'EJT6uFxdyPgSG0GBEyPmVYdMa2kP7lG3R_ANxaTsZ545nu40eEPNQe_0bAIufRlH_df7cGt35E33YYYC';

    /**
     * PayPal constructor.
     * @param $shopping_cart
     */
    public function __construct($shopping_cart)
    {
        $this->_apiContext = \PaypalPayment::ApiContext($this->_ClientId, $this->_ClientSecret);
        $config = config('paypal_payment');
        $flatConfig = array_dot($config);
        $this->_apiContext->setConfig($flatConfig);
        $this->shopping_cart = $shopping_cart;
    }

    public function generate()
    {
        $payment = \Paypalpayment::payment()
            ->setIntent('sale')
            ->setPayer($this->payer())
            ->setTransactions([$this->transaction()])
            ->setRedirectUrls($this->redirectURLs());

        try {
            $payment->create($this->_apiContext);
        } catch (PayPalConnectionException $ex) {
            dd($ex);
            exit();
        }

        return $payment;
    }

    public function payer()
    {
        return \PaypalPayment::payer()
            ->setPaymentMethod('paypal');
    }

    public function redirectURLs()
    {
        $baseURL = url('/');
        return \PaypalPayment::redirectUrls()
            ->setReturnUrl("$baseURL/payments/store")
            ->setCancelUrl("$baseURL/carrito");
    }

    public function transaction()
    {
        return \PaypalPayment::transaction()
            ->setAmount($this->amount())
            ->setItemList($this->items())
            ->setDescription('Tu compra en productos facilito!')
            ->setInvoiceNumber(uniqid());
    }

    public function items()
    {
        $items = [];

        $products = $this->shopping_cart->products()->get();

        foreach ($products as $product) {
            array_push($items, $product->paypalItem());
        }

        return \PaypalPayment::itemList()->setItems($items);
    }

    public function amount()
    {
        return \PaypalPayment::amount()
            ->setCurrency('USD')
            ->setTotal($this->shopping_cart->totalUSD());
    }

    public function execute($paymentId, $payerId)
    {
        $payment = \PaypalPayment::getById($paymentId, $this->_apiContext);

        $execution = \PaypalPayment::PaymentExecution()->setPayerId($payerId);

        return $payment->execute($execution, $this->_apiContext);
    }


}






