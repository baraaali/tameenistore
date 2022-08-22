<?php

namespace App\Traits;

use App\UserBanner;

trait GeneralTrait
{


   public function getBanners($page)
   {
     $conditions = [];
     if(auth()->user())
     {
         array_push($conditions,['country_id','=',auth()->user()->country_id]);
     }else if(!is_null(session()->get('selected_value')) &&  session()->get('selected_value') != -1)
     {
        array_push($conditions,['country_id','=',session()->get('selected_value') ]);
     }

    //return $conditions;
     return UserBanner::whereDate('end_date', '>', date('Y-m-d'))
     ->where($conditions)
     ->whereHas('Banner',function($q)use($page){
         $q->where('page',$page);
     }) ->get();


   }
    public function getCurrentLang()
    {
        return app()->getLocale();
    }

    public function returnError($errNum, $msg)
    {
        return response()->json([
            'status' => false,
            'errNum' => $errNum,
            'msg' => $msg
        ]);
    }


    public function returnSuccessMessage($msg = "", $errNum = "S000")
    {
        return [
            'status' => true,
            'errNum' => $errNum,
            'msg' => $msg
        ];
    }

    public function returnData($key, $value, $msg = "")
    {
        return response()->json([
            'status' => true,
            'errNum' => "S000",
            'msg' => $msg,
            $key => $value
        ]);
    }


    //////////////////
    public function returnValidationError($code = "E001", $validator)
    {
        return $this->returnError($code, $validator->errors()->first());
    }


    public function returnCodeAccordingToInput($validator)
    {
        $inputs = array_keys($validator->errors()->toArray());
        $code = $this->getErrorCode($inputs[0]);
        return $code;
    }

    public function getErrorCode($input)
    {
        if ($input == "name")
            return 'E0011';

        else if ($input == "password")
            return 'E002';

        else if ($input == "user_name")
            return 'E003';

        else if ($input == "country_id")
            return 'E004';

        else if ($input == "password")
            return 'E005';

        else if ($input == "user_type")
            return 'E006';

        else if ($input == "email")
            return 'E007';

        else if ($input == "city_id")
            return 'E008';

        else if ($input == "insurance_company_id")
            return 'E009';

        else if ($input == "car_id")
            return 'E010';

        else if ($input == "from_date")
            return 'E011';

        else if ($input == "to_date")
            return 'E012';

        else if ($input == "id")
            return 'E013';

        else if ($input == "address")
            return 'E014';

        else if ($input == "phone")
            return 'E015';

        else if ($input =='carprice')
            return 'E016';

        else if ($input == "type_of_use")
            return 'E017';

        else if ($input == "brand_id")
            return 'E018';

        else if ($input == "model_id")
            return 'E019';

        else if ($input == "sort")
            return 'E020';

        else if ($input == "message")
            return 'E021';

        else if ($input == "status")
            return 'E022';

        else if ($input == "membership_id")
            return 'E023';

        else if ($input == "Insurance_Company_ar")
            return 'E024';

        else if ($input == "name_en")
            return 'E025';

        else if ($input == "name_ar")
            return 'E026';

        else if ($input == "Insurance_Company_en")
            return 'E027';

        else if ($input == "deliveryFee")
            return 'E028';

        else if ($input == "precent")
            return 'E029';

        else if ($input == "ar_term")
            return 'E030';

        else if ($input == "en_term")
            return 'E031';

        else if ($input == "max_value")
            return 'E032';

        else if ($input == "max_year")
            return 'E033';

        else if ($input == "start_disc")
            return 'E034';

        else if ($input == "end_disc")
            return 'E035';

        else if ($input == "ToleranceratioCheck")
            return 'E036';

        else if ($input == "Tolerance_ratio")
            return 'E037';

        else if ($input == "ToleranceYearPerecenteage")
            return 'E038';

        else if ($input == "ConsumptionRatio")
            return 'E039';

        else if ($input == "ConsumptionFirstRatio")
            return 'E040';

        else if ($input == "YearPerecenteage")
            return 'E041';

        else if ($input == "ConsumptionYearPerecenteage")
            return 'E042';

        else if ($input == "last_percent")
            return 'E043';

        else if ($input == "last_percent_en")
            return 'E044';

        else if ($input == "logo")
            return 'E045';

        else if ($input == "model_id")
            return 'E046';

        else if ($input == "firstSlidePrice")
            return 'E047';

        else if ($input == "OpenFileFirstSlide")
            return 'E048';

        else if ($input == "OpenFilePerecentFirstSlide")
            return 'E049';

        else if ($input == "OpenFileFirstSlideMin")
            return 'E050';

        else if ($input == "SecondSlidePrice")
            return 'E051';

        else if ($input == "OpenFileSecondSlide")
            return 'E052';

        else if ($input == "OpenFilePerecentSecondSlide")
            return 'E053';

        else if ($input == "thirdSlidePrice")
            return 'E054';

        else if ($input == "OpenFileThirdSlide")
            return 'E055';

        else if ($input == "OpenFilePerecentThirdSlide")
            return 'E063';
        else if ($input == "fourthSlidePrice")
            return 'E064';
        else if ($input == "OpenFileFourthSlide")
            return 'E065';
        else if ($input == "OpenFilePerecentFourthSlide")
            return 'E066';

        else if ($input == "company_name")
            return 'E057';
        else if ($input == "license_number")
            return 'E058';
        else if ($input == "start_date")
            return 'E059';
        else if ($input == "end_date")
            return 'E060';
        else if ($input == "license_image")
            return 'E061';
        else if ($input == "id_image")
            return 'E062';
        //
        else if ($input == "ar_brand")
            return 'E063';
        else if ($input == "ar_model")
            return 'E064';
        else if ($input == "number_days")
            return 'E065';
        else if ($input == "ar_name")
            return 'E066';
        else if ($input == "ar_description")
            return 'E067';
        else if ($input == "en_description")
            return 'E068';
        else if ($input == "images")
            return 'E069';
        else if ($input == "discount_amount")
            return 'E070';
        else if ($input == "discount_percent")
            return 'E071';
        else if ($input == "discount_start_date")
            return 'E072';
        else if ($input == "discount_end_date")
            return 'E073';
        else if ($input == "fuel")
            return 'E074';
        else if ($input == "sell")
            return 'E075';
        else if ($input == "talap")
            return 'E076';
        else if ($input == "transmission")
            return 'E077';
        else if ($input == "rent_type")
            return 'E078';
        else if ($input == "kilometers")
            return 'E079';
        else if ($input == "maxSpeed")
            return 'E080';
        else if ($input == "engine")
            return 'E081';
        else if ($input == "user_id")
            return 'E082';
        else if ($input == "token")
            return 'E083';

        else
            return "";
    }


}
