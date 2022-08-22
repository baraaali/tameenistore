<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Request;


class FatooraService
{
    private $base_url;
    private $headers;
    private $request_client;

    public function __construct(Client  $request_client)
    {
        $this->request_client=$request_client;
        $this->base_url=env('fatoorah_base_ur');
        $this->headers=[
            'Content-Type'=>'application/json',
            "Authorization"=>"Bearer ".env('fatoorah_token')
        ];
    }

    public function sendPayment($data)
    {
        $response=$this->buildRequest('/v2/SendPayment','post',$data);
        return $response;
    }//end fun payMoney

    public function getPaymentStatus($data){
        $response=$this->buildRequest('/v2/getPaymentStatus','post',$data);
         return $response;
    }

    private function buildRequest($url,$method,$data=[]){
        //dd($this->base_url.$url);
        $request=new \GuzzleHttp\Psr7\Request($method,$this->base_url.$url,$this->headers);
        if (!$data) return false;
        $response=$this->request_client->send($request,['json'=>$data]);
        
        if ($response->getStatusCode() !=200) return false;
        $response=json_decode($response->getBody(),true);
        
        return $response;
    }//end buildRequest
    
        


}//end class
