<?php

require __DIR__ . '/vendor/autoload.php';

define("ACCESS_TOKEN", "APP_USR-6317427424180639-042414-47e969706991d3a442922b0702a0da44-469485398");
define("CLIENT_ID", "469485398");
define("PUBLIC_KEY", "APP_USR-7eb0138a-189f-4bec-87d1-c0504ead5626");

define("NOTIFICATION_URL", $_SERVER['SERVER_NAME'] . "/notification.php");
define("BACK_SUCCESS", $_SERVER['SERVER_NAME'] . "/result_success.php");
define("BACK_PENDING", $_SERVER['SERVER_NAME'] . "/result_pending.php");
define("BACK_FAILURE", $_SERVER['SERVER_NAME'] . "/result_failure.php");

define("DESCRIPTION_ITEM", "Dispositivo móvil de Tienda e-commerce");
define("EXTERNAL_REFERENCE", "ABCD1234");
define("ITEM_ID", "1234");

// Credenciales
MercadoPago\SDK::setAccessToken(ACCESS_TOKEN);
MercadoPago\SDK::setClientId(CLIENT_ID);
MercadoPago\SDK::setPublicKey(PUBLIC_KEY);


function createPreference($title, $price, $unit, $image)
{

    $item = new MercadoPago\Item();
    $item->id = ITEM_ID;
    $item->title = $title;
    $item->quantity = $unit;
    $item->unit_price = $price;
    $item->description = DESCRIPTION_ITEM;
    $item->picture_url = $_SERVER['SERVER_NAME'] . $image;

    $payer = new MercadoPago\Payer();
    $payer->name = "Lalo";
    $payer->surname = "Landa";
    $payer->email = "test_user_63274575@testuser.com";
    $payer->identification = array(
        "type" => "DNI",
        "number" => "22.333.444"
    );
    $payer->phone = array(
        "area_code" => "011",
        "number" => "2222-3333"
    );
    $payer->address = array(
        "street_name" => "Falsa",
        "street_number" => 123,
        "zip_code" => "1111"
    );

    $preference = new MercadoPago\Preference();
    $preference->payment_methods = array(
        "excluded_payment_methods" => array(
            array("id" => "amex")
        ),
        "excluded_payment_types" => array(
            array("id" => "atm")
        ),
        "installments" => 6
    );
    $preference->payer = $payer;
    $preference->items = array($item);
    // ExternalReference debería estar compuesto por el id del item,
    // en este caso utilizo el valor de la consigna como ejemplo.
    $preference->external_reference = EXTERNAL_REFERENCE;
    $preference->back_urls = array(
        "success" => BACK_SUCCESS,
        "failure" => BACK_FAILURE,
        "pending" => BACK_PENDING
    );
    $preference->auto_return = "all";
    $preference->notification_url = NOTIFICATION_URL;
    $preference->save();

    return $preference;
}


function getPayment($paymentId){
    return MercadoPago\Payment::find_by_id($paymentId);
}