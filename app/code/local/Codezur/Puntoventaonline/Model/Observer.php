<?php

class Codezur_Puntoventaonline_Pay_Order_Model_Observer {
    
    public function __construct(){
    }
    
    public function customerLogin(){
        echo "aaaa";
        die("asd");
    }
    
    public function onOrderComplete($observer) {

        $order = $observer->getEvent()->getOrder();
        $orderId = $order->getId();
        $customerId = $order->getCustomerId();
        $datetime = $order->getCreatedAt();

        //puntos que uso para la compra
        $pointsRedeem = Mage::getSingleton('core/session')->getData('points_redeem');

        //precio del punto
        $pointsPrice = Mage::getSingleton('core/session')->getData('points_price');

        //puntos del cliente
        $customerCreditPoints = Mage::getSingleton('customer/session')->getCustomer()->getCreditPoint();

        $products = array();

        $quote = $observer->getEvent()->getQuote();

        foreach ($quote->getAllItems() as $item) {
            $product = $item->getProduct(); //if you need it
            $products[] = $product;
        }

        $products = $products;


        foreach ($products as $product) {
            $isCredit = false;

            $categoryCollection = $product->getCategoryIds();

            $n = array();

            foreach ($categoryCollection as $ci) {
                $_cat = Mage::getModel('catalog/category')->load($ci);
                $n[] = $_cat->getName();
                $n = $n;
            }

            if (in_array("Creditos", $n)) {
                $isCredit = true;
            }

            if ($isCredit/* $pointsRedeem && $pointsPrice != NULL */) {
                $customerCreditPoints = $product->getPrice();

                //init our model, set data and save
                //deduct redeemed credit points from customer account and revise
                try {

                    $revisedCreditPoints = $customerCreditPoints - $pointsRedeem;
                    $creditModel = Mage::getSingleton('creditpoint/creditpoint')
                            ->setCustomerId($customerId)
                            ->setOrderId($orderId)
                            ->setAppliedCreditPoint($pointsRedeem)
                            ->setAppliedCreditPointPrice($pointsPrice)
                            ->setCreatedTime($datetime)
                            ->save();

                    $customerData = Mage::getSingleton('customer/customer')->load($customerId)->setCreditPoint($revisedCreditPoints)->save();

                    //unset credit points data
                    Mage::getSingleton('core/session')->unsEstimateCredit();
                    Mage::getSingleton('core/session')->unsPointsRedeem();
                    Mage::getSingleton('core/session')->unsPointsPrice();
                } catch (Exception $e) {
                    Mage::getModel('core/session')->addError($e->getMessage());
                }
            }
        }
    }

}
