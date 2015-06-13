<?php

class Jotapey_Pos_Model_Observer {
    
    public function __construct(){
    }
    
    public function customerLogin(){
        /*echo "aaaa";
        die("asd");*/
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
        $customerCreditPoints = Mage::getSingleton('customer/customer')->load($order->getCustomerId())->getCreditPoint();
        
        if(!$customerCreditPoints){
            $customerCreditPoints = 0;
        }
        
        $products = array();

        $quote = $observer->getEvent()->getQuote();
        
        $items = Mage::getModel('sales/order')->load($orderId);
        
        $items = $items->getAllItems();

        foreach ($items as $item) {
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
                
                /**/
                $cart = Mage::helper('checkout/cart')->getCart()->getQuote();
                $theqty = 0;
                foreach ($cart->getAllItems() as $item) {
                    $theqty = $item->getQty();
                }
                /**/
                if(!$theqty){
                    $theqty = 1;
                }
                
                $customerCreditPoints += ($product->getPrice()*$theqty);

                //init our model, set data and save
                //deduct redeemed credit points from customer account and revise
                try {
                    if(!$pointsRedeem){
                        $pointsRedeem = 0;
                    }
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
