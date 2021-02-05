<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Srmklive\PayPal\Services\ExpressCheckout;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    //private $apiContext;

    protected $provider;

    public function __construct()
    {
        //$payPalConfig = Config::get('PayPal');

        //$this->apiContext->setConfig($payPalConfig['sandbox']);

        $this->provider = new ExpressCheckout();

        Stripe::setApiKey('sk_test_ChV04hZNgJP2HPxMsRI9sa3a00yujLP5Ru');

    }

    // ...

    public function payWithPayPal(Request $request)
    {
        $data = [];
        $data['items'] = [
            [
                'name' => 'Website',
                'price' => $request->amount,
                'desc'  => 'websites description',
                'qty' => 1
            ]
        ];
  
        $data['invoice_id'] = 1;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('paypal.success');
        $data['cancel_url'] = route('paypal.cancel');
        $data['total'] = $request->amount;
  
        $response = $this->provider->setExpressCheckout($data);
  
        //$response = $this->provider->setExpressCheckout($data, true);
  
        return redirect($response['paypal_link']);
    }

   

    public function payWithStripe(Request $request){

        Stripe::setApiKey('sk_test_ChV04hZNgJP2HPxMsRI9sa3a00yujLP5Ru');

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
              'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                  'name' => 'Website',
                ],
                'unit_amount_decimal' => $request->amount,
              ],
              'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success'),
            'cancel_url' => route('stripe.cancel'),
          ]);

          $id = $session->id;

          return response()->json(['id' => $id]);
    }

    public function show() {
        //
    }
}
