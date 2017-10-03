<?php
class Sprite
{
    private $charge;
    function __construct($secret_key)
    {
        $this->charge = \Stripe\Stripe::setApiKey($secret_key);
    }

    function buy ($token, $price, $user){
        $this->charge = \Stripe\Charge::create(array(
            "amount" => $price,
            "currency" => "eur",
            "description" => $user,
            "source" => $token,
        ));
    }
}