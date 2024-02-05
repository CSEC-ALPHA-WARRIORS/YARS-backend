<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Chapa\Chapa\Facades\Chapa as Chapa;

class ChapaController extends Controller
{
    protected $reference;

    public function __construct(){
        $this->reference = Chapa::generateReference();

    }
    public function initialize($amount, $email, $fname, $lname)
    {
        //This generates a payment reference
        $reference = $this->reference;
        
        // Enter the details of the payment
        $data = [
            
            'amount' => $amount,
            'email' => $email,
            'tx_ref' => $reference,
            'currency' => "ETB",
            'callback_url' => route('callback',[$reference]),
            'return_url' => 'http://localhost:5173/payment-successful?status=completed',
            'first_name' => $fname,
            'last_name' => $lname,
            "customization" => [
                "title" => 'YARS',
                "description" => "Time to pay"
            ]
        ];
        

        $payment = Chapa::initializePayment($data);


        if ($payment['status'] !== 'success') {
            // notify something went wrong
            return;
        }

        return $payment['data']['checkout_url'];

        // return $payment['data']['checkout_url'].' '.$reference;
    }

     public function callback($reference)
    {
        
        $data = Chapa::verifyTransaction($reference);
        dd($data);

        //if payment is successful
        if ($data['status'] ==  'success') {
        

        dd($data);
        }

        else{
            //oopsie something ain't right.
        }


    }
}
