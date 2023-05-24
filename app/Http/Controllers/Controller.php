<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Services\Midtrans\Midtrans as PaymentGateway;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    protected function initPaymentGateway()
	{
        $paymentgateway = new PaymentGateway();
        $paymentgateway->_configureMidtrans();
	}
}
