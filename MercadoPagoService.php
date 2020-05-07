<?php
define("BACK_SUCCESS", $_SERVER['SERVER_NAME'] . "/result_success.php");
define("BACK_PENDING", $_SERVER['SERVER_NAME'] . "/result_pending.php");
define("BACK_FAILURE", $_SERVER['SERVER_NAME'] . "/result_failure.php");
define("DESCRIPTION_ITEM", "Dispositivo móvil de Tienda e-commerce");
define("EXTERNAL_REFERENCE", "ABCD1234");
define("ITEM_ID", "1234");

function initPoint($title, $price, $unit, $image)
{
    // SDK de Mercado Pago
    require __DIR__ . '/vendor/autoload.php';

    // Credenciales
    MercadoPago\SDK::setAccessToken('APP_USR-6317427424180639-042414-47e969706991d3a442922b0702a0da44-469485398');
    MercadoPago\SDK::setClientId('469485398');
    MercadoPago\SDK::setPublicKey('APP_USR-7eb0138a-189f-4bec-87d1-c0504ead5626');

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
        "tyoe" => "DNI",
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
        )
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
    $preference->auto_return = "approved";
    $preference->save();

    return $preference->id;
}