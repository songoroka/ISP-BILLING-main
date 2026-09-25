<?php

namespace App\Services\Payments;

interface TanzaniaPaymentGateway
{
    /** @return array{status:string,merchant_reference:string,provider_transaction_id:?string,provider_reference:?string,redirect_url:?string,raw:array} */
    public function initiate(array $payment): array;

    /** @return array{status:string,provider_transaction_id:?string,provider_reference:?string,raw:array} */
    public function query(string $merchantReference): array;
}
