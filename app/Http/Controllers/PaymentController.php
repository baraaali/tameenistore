<?php

namespace App\Http\Controllers;

use App\Balance;
use App\Payment;
use Illuminate\Http\Request;
//use PayPal\Api\Amount;
//use PayPal\Api\Details;
//use PayPal\Api\Item;
//use PayPal\Api\ItemList;
//use PayPal\Api\Payer;
//use PayPal\Api\Payment;
//use PayPal\Api\PaymentExecution;
//use PayPal\Api\RedirectUrls;
//use PayPal\Api\Transaction;
//use PayPal\Auth\OAuthTokenCredential;
//use PayPal\Rest\ApiContext;
//use Omnipay\Omnipay;

//use Omnipay\Omnipay as Omnipay;
class PaymentController extends Controller
{
    private $apiContex;
    private $clientId;
    private $secret;

//    public function __construct()
//    {
////        if (config('paypal.settings.mode')=='live'){
////            $this->clientId=config('paypal.live_client_id');
////            $this->secret=config('paypal.live_secret');
////        }else{
////            $this->clientId=config('paypal.sandbox_client_id');
////            $this->secret=config('paypal.sandbox_secret');
////        }
////        $this->apiContex=new ApiContext(new OAuthTokenCredential($this->clientId,$this->secret));
////        $this->apiContex->setConfig(config('paypal.settings'));
//        $this->apiContex=new ApiContext(
//            new OAuthTokenCredential(
//                config('paypal.paypal.id'),
//                config('paypal.paypal.secret')
//            )
//        );
//    }//end construct

    public function charging(Request  $request){
        $request->validate([
            'balance' => 'required',
        ]);
        $balance=$request->balance;
        $name=auth()->user()->name;
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        //item
        $item1 = new Item();
        $item1->setName('charge amount of ' .$name)
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setDescription($name." charging balance")
         //   ->setSku("123123") // Similar to `item_number` in Classic API
            ->setPrice($balance);
        //itemlist
        $itemList = new ItemList();
        $itemList->setItems(array($item1));
        //amount
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($balance);

        //Transaction
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('success_payment'))
            ->setCancelUrl(route('show_balance'));

        //payment
        $payment = new Payment();
//        dd($payment);
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
        try {
            $payment->create($this->apiContex);
        } catch (\Paypal\Exception\PayPalConnectionException $ex) {
          die($ex);
        }
        $approvalUrl = $payment->getApprovalLink();
        return redirect($approvalUrl);
    }//end charging

    public function successPayment(Request  $request){
       // dd($request->all());
      //  dd($request->token);
      if (empty($request->PayerID)||empty($request->token)){
          die('payment failed');
      }
      //dd($request->PayerID);
      $paymentId=$request->paymentId;
      $payment=Payment::get($paymentId,$this->apiContex);

        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);
        //dd($this->apiContex);dd('ddd');

        try {
            $payment->execute($execution,$this->apiContex);
        } catch (\Paypal\Exception\PayPalConnectionException $ex) {
            die($ex->getData());
        }
    }//end successPayment


    public $gateway;

    public function __construct()
    {
        // $this->gateway = Omnipay::create('PayPal_Rest');
        // $this->gateway->setClientId('AQQpR7h8PB6qMY1YkhdZXe142ueQPZ0eCDe8nVj82sadzrtZ9sRfdUEh1RDde4PclfnT8JrTLw3oizAP');
        // $this->gateway->setSecret('EJXhVqQ0QoyKzcuthoTBBQaseRwevFLk1dP_gFax3HQZTnl7JM1_Zojj9oAbTU111LiU5_lM_JarmIoq');
//        $this->gateway->setClientId('ATJFAlYl69yLxPYihfgMsfEpdu9aXozynbwrwcrTPFc3uZfaGg9nf0qjIA2a3Ohu4ApvzhHoeOmG2gvq');
//        $this->gateway->setSecret('EOY1yWSdLmEGJbWScK3xg3DblJTkSSaMNrGNyIkRQGIfdTcvb1sKzSX4EK0BL7v8xGzYYdYMHQ18UoIl');
        // $this->gateway->setTestMode(false); //set it to 'false' when go live
    }

    public function index()
    {
        return view('payment');
    }

    public function charge(Request $request)
    {
        if($request->input('submit'))
        {
            try {
                $response = $this->gateway->purchase(array(
                    'amount' => $request->amount,
                    'currency' => "USD",
                    'returnUrl' => url('paymentsuccess'),
                    'cancelUrl' => route('show_balance'),
                ))->send();

                if ($response->isRedirect()) {
                    $response->redirect(); // this will automatically forward the customer
                } else {
                    // not successful
                    dd($response);
                }
            } catch(Exception $e) {
                return $e->getMessage();
            }
        }
    }

    public function payment_success(Request $request)
    {
        // Once the transaction has been approved, we need to complete it.
       $user_id=auth()->user()->id;
        if ($request->input('paymentId') && $request->input('PayerID'))
        {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id'             => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();

            if ($response->isSuccessful())
            {
                // The customer has successfully paid.
                $arr_body = $response->getData();

                // Insert transaction data into the database
                $isPaymentExist = Payment::where('payment_id', $arr_body['id'])->first();

                if(!$isPaymentExist)
                {
                    $payment = new Payment;
                    $payment->payment_id = $arr_body['id'];
                    $payment->payer_id = $arr_body['payer']['payer_info']['payer_id'];
                    $payment->payer_email = $arr_body['payer']['payer_info']['email'];
                    $payment->amount = $arr_body['transactions'][0]['amount']['total'];
                    $payment->currency = "USD";
                    $payment->payment_status = $arr_body['state'];
                    $payment->save();
                }
                $paid=$arr_body['transactions'][0]['amount']['total'];
                $balance=Balance::where('user_id',$user_id)->first();
                transaction($user_id,'in',$paid,'charge',0);
                if ($balance) {
                    $value=$balance->balance+$paid;
                    $balance->update(['balance'=>$value]);
                    return redirect()->back()->with('success','You Charged Your Balance Successfully');
                }else{
                    Balance::create(['user_id'=>auth()->user()->id,'balance'=>$paid]);
                    return redirect()->back()->with('success','You Charged Your Balance Successfully');
                }


            } else {
                return $response->getMessage();
            }
        } else {
            return 'Transaction is declined';
        }

    }

    public function payment_error()
    {
        return 'User is canceled the payment.';
    }

}//end class
