<?php

namespace App\Http\Controllers;

use App\Balance;
use App\Http\Services\FatooraService;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use App\PaymentHistory;

class FatooraController extends Controller
{
    private $fatooraService;
    public function __construct(FatooraService  $fatooraService)
    {
        $this->middleware(['auth']);
        $this->fatooraService=$fatooraService;
    }

    protected function payMoney(Request  $request)
    {
           $request->validate([
                 'amount'=>'required|integer|min:1',
             ],
            [
                'amount.required' => 'المبلغ مطلوب',
                'amount.integer' => 'يجب ان يكون المبلغ رقم صحيح',
                'amount.min' => 'يجب ان يكون المبلغ على الاقل 1$',
            ]);
        $user=auth()->user();
        Payment::create([
            'payer_id'=>$user->id,
            'payer_email'=>$user->email,
            'amount'=>$request->amount,
            'currency'=>'USD',
            'payment_status'=>"pending",
        ]);
        $data = [
            "InvoiceValue"=>$request->amount,
            'NotificationOption' => 'Lnk',
            "CustomerName"=> $user->name,
            "CustomerEmail"=> $user->email,
            'DisplayCurrencyIso' => 'USD',
            "CustomerMobile"=> "1234567890",
            "Language"=> "en",
            "CallBackUrl"=>env('call_back_success'),
            "ErrorUrl"=>env('call_back_error'),
        ];
        $response= $this->fatooraService->sendPayment($data);
        $url=$response['Data']['InvoiceURL'];

        return Redirect::to($url);
        // return $url;
    }//end fun payMoney

    public function callBack(Request $request)
    {  $user=auth()->user();
//dd($request->all());
        $postFields = [
            'Key'     => $request->paymentId,
            'KeyType' => 'paymentId'
        ];
        $data=$this->fatooraService->getPaymentStatus($postFields);
        DB::beginTransaction();
        try {

            if($data['IsSuccess']==true){
                $row=Payment::where('payer_id',$user->id)->where('payment_status',"pending")
                    ->orderBy('id','Desc')->first()->update(['payment_id'=>$data['Data']['InvoiceId'],'payment_status'=>'paid']);
                $paid=Payment::where('payer_id',$user->id)->first()->amount;
                $balance=Balance::where('user_id',$user->id)->first();
                $balance_before=$balance->balance;
                $balance_after=$balance_before+$paid;
                transaction($user->id,'in',$paid,'charge',0,$balance_before,$balance_after);
                if ($balance) {
                    $value=$balance->balance+$paid;
                    $balance->update(['balance'=>$value]);
                    DB::commit();
                    return redirect()->route('show_balance')->with('success','تم اضافه الرصيد بنجاح');
                }else{
                    Balance::create(['user_id'=>auth()->user()->id,'balance'=>$paid]);
                    DB::commit();
                    return redirect()->route('show_balance')->with('success','تم اضافه الرصيد بنجاح');
                }
            }

        }catch (\Exception $e) {
            DB::rollback();
        }
    }//end callBack

    public function error()
    {$user=auth()->user();
        Payment::where('payer_id',$user->id)->where('payment_status',"pending")
            ->orderBy('id','Desc')->first()->delete();
        return redirect()->route('show_balance')->with('success','Transaction is declined');
    }//end callBack

    public function paymentReport($lang=''){
        $user=auth()->user();
        $rows=PaymentHistory::where('user_id',$user->id)->get();
        $balance=Balance::where('user_id',$user->id)->first();

        return view('dashboard.payment_report.index',compact('rows','lang','balance'));
    }

}//end class

