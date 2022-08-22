<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsuranceDocumentBrand extends Model
{
    protected $table = 'insurance_document_brands';
    protected $fillable = [
        'firstSlidePrice','OpenFileFirstSlide','OpenFilePerecentFirstSlide'
        ,'OpenFileFirstSlideMin' , 'SecondSlidePrice' , 'OpenFileSecondSlide','OpenFilePerecentSecondSlide'
        ,'thirdSlidePrice' , 'OpenFileThirdSlide' , 'OpenFilePerecentThirdSlide' , 'fourthSlidePrice'
        ,'OpenFileFourthSlide' , 'OpenFilePerecentFourthSlide' , 'insurance_document_id'
    ];
}
