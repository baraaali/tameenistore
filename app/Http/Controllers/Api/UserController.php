<?php

namespace App\Http\Controllers\Api;

use App\Balance;
use App\Http\Controllers\Controller;
use App\Payment;
use App\Token;
use App\Traits\GeneralTrait;
use App\User;
use Validator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use GeneralTrait;
    public function getUsers(){
        $user=User::all();
        return response()->json($user);
    }//end getUser

    public function charge(Request  $request){
        $rules=[
            'payment_id'=>'required',
            'payer_id'=>'required',
            'payer_email'=>'required',
            'amount'=>'required',
            'payment_status'=>'required',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        try {
        $arr=$request->all()+['currency'=>'USD'];
        Payment::create($arr);
        $user_id=auth()->guard('api')->user()->id;
        $paid=$request->amount;
        $balance=Balance::where('user_id',$user_id)->first();
        transaction($user_id,'in',$paid,'charge',0);
        if ($balance) {
            $value=$balance->balance+$paid;
            $balance->update(['balance'=>$value]);
            return $this->returnSuccessMessage('success');
        }else{
            Balance::create(['user_id'=>auth()->user()->id,'balance'=>$paid]);
            return $this->returnSuccessMessage('success');
        }
        }catch(\Exception $ex){
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }//end cach
        return  $this->returnSuccessMessage('success');
    }//end charge

    public function createToken(Request  $request)
    {
        $rules=[
            'token'=>'required',
            'user_id'=> 'required|exists:users,id',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        try {
        Token::firstOrCreate($request->all());
        return $this->returnSuccessMessage('success');
        } catch(\Exception $ex){
            return $this->returnError($ex->getCode(),$ex->getMessage());
                 }//end cach

    }//end createToken

    public function deleteToken(Request  $request)
    {
        $rules=[
            'token'=>'required',
            'user_id'=> 'required|exists:users,id',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        try {
        $row=Token::where(['user_id'=>$request->user_id,'token'=>$request->token])->first();
        if (!$row) return $this->returnError(99,'not found');
        $row->delete();
        return $this->returnSuccessMessage('success');
        } catch(\Exception $ex){
            return $this->returnError($ex->getCode(),$ex->getMessage());
                 }//end cach

    }//end createToken

    public function getUserToken(Request  $request)
    {
        $rules=[
            'user_id'=> 'required|exists:users,id',
        ];
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails()){
            $code=$this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code,$validator);
        }
        try {
           $rows=Token::where('user_id',$request->user_id)->get();
            return $this->returnData('rows',$rows);
        } catch(\Exception $ex){
            return $this->returnError($ex->getCode(),$ex->getMessage());
        }//end cach

    }//end createToken

   public function showUserbalance(){
       $user_id=auth()->guard('api')->user()->id;
       $balance=Balance::where('user_id',$user_id)->first();

       return $this->returnData('balance',$balance);
   }//end showUserbalance

}//end class
