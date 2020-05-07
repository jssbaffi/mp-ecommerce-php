<?php

require_once "MercadoPagoService.php";

switch($_POST["type"]) {
    case "payment":
        $payment = MercadoPago\Payment::find_by_id($_POST["id"]);
        break;
    case "plan":
        $plan = MercadoPago\Plan::find_by_id($_POST["id"]);
        break;
    case "subscription":
        $plan = MercadoPago\Subscription::find_by_id($_POST["id"]);
        break;
    case "invoice":
        $plan = MercadoPago\Invoice::find_by_id($_POST["id"]);
        break;
}

http_response_code(200);
