<?php
$response= array();


$apiURL = 'https://api.myfatoorah.com';
$apiKey =$site->token;


//Inquiry using paymentId
$keyId   = $_GET['paymentId'];
$KeyType = 'paymentid';


//Fill POST fields array
$postFields = [
    'Key'     => $keyId,
    'KeyType' => $KeyType
];
//Call endpoint
$Data       = callAPI("$apiURL/v2/getPaymentStatus", $apiKey, $postFields)->Data;

$InvoiceStatus = $Data->InvoiceStatus;
$InvoiceId = $Data->InvoiceId;
$InvoiceReference = $Data->InvoiceReference;
$CustomerName = $Data->CustomerName;
$CustomerEmail = $Data->CustomerEmail;
$InvoiceDisplayValue = $Data->InvoiceDisplayValue;

function callAPI($endpointURL, $apiKey, $postFields = []) {

    $curl = curl_init($endpointURL);
    curl_setopt_array($curl, array(
        CURLOPT_CUSTOMREQUEST  => 'POST',
        CURLOPT_POSTFIELDS     => json_encode($postFields),
        CURLOPT_HTTPHEADER     => array("Authorization: Bearer $apiKey", 'Content-Type: application/json'),
        CURLOPT_RETURNTRANSFER => true,
    ));

    $response = curl_exec($curl);
    $curlErr  = curl_error($curl);

    curl_close($curl);

    if ($curlErr) {
        //Curl is not working in your server
        die("Curl Error: $curlErr");
    }

    $error = handleError($response);
    if ($error) {
        die("Error: $error");
    }

    return json_decode($response);
}

//------------------------------------------------------------------------------
/*
* Handle Endpoint Errors Function
*/

function handleError($response) {

    $json = json_decode($response);
    if (isset($json->IsSuccess) && $json->IsSuccess == true) {
        return null;
    }

    //Check for the errors
    if (isset($json->ValidationErrors) || isset($json->FieldsErrors)) {
        $errorsObj = isset($json->ValidationErrors) ? $json->ValidationErrors : $json->FieldsErrors;
        $blogDatas = array_column($errorsObj, 'Error', 'Name');

        $error = implode(', ', array_map(function ($k, $v) {
            return "$k: $v";
        }, array_keys($blogDatas), array_values($blogDatas)));
    } else if (isset($json->Data->ErrorMessage)) {
        $error = $json->Data->ErrorMessage;
    }

    if (empty($error)) {
        $error = (isset($json->Message)) ? $json->Message : (!empty($response) ? $response : 'API key or API URL is not correct');
    }

    return $error;
}

?>

<html>

<head>
    <title>تاميني ستور</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head

<body>

<style>
    body {
        background: #3f51b5;
    }
    .main-block {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 60%;
        padding: 60px;
        background: #ffffff !important;
        box-shadow: 0 0 3px 0 rgb(0 0 0 / 15%);
        border: 1px solid #e0e0e0;
        border-radius: 10px;
    }
    h2 {
        font-size: 16px;
        margin: 0px;
        padding: 10px;
    }
    .InvoiceDisplayValue{
        margin: 0px;
        text-align: center;
        margin-bottom: 20px;
        font-size: 18px;
        font-weight: 700;
    }
    .InvoiceStatus {
        background: #0e7e0b;
        text-align: center;
        color: #FFF;
        padding: 17px;
        font-size: 20px;
        font-weight: 700;
        text-transform: uppercase;
        margin: 0px;
        margin-bottom: 20px;
        border-radius: 5px;
    }
    /* On screens that are 992px wide or less, the background color is blue */
    @media screen and (max-width: 1100px) {
        .main-block {
            width: 80%;
        }
    }

    /* On screens that are 992px wide or less, the background color is blue */
    @media screen and (max-width: 992px) {
        .main-block {
            width: 70%;
        }
    }

    /* On screens that are 600px wide or less, the background color is olive */
    @media screen and (max-width: 600px) {
        .main-block {
            width: 80%;
        }
    }

    /* On screens that are 600px wide or less, the background color is olive */
    @media screen and (max-width: 500px) {
        .main-block {
            width: 80%;
        }
    }
</style>

<div class="container-fluid main-block">
    <h2 class="InvoiceStatus"><?php echo $InvoiceStatus ?></h2>
    <p class="InvoiceDisplayValue"><?php echo $InvoiceDisplayValue ?></p>
    <div class="row">

        <div class="col-md-6 col-sm-12 col-xs-12" style="background-color:lavender;">
            <h2>Invoice ID : <?php echo $InvoiceId ?></h2>
        </div>

        <div class="col-md-6 col-sm-12 col-sm-pull-12 col-xs-12 col-xs-pull-12" style="background-color:lavenderblush;">
            <h2>Invoice Reference : <?php echo $InvoiceReference ?></h2>
        </div>

        <div class="col-md-6 col-sm-12 col-sm-push-12 col-xs-12 col-xs-push-12" style="background-color:lavender;">
            <h2>Name : <?php echo $CustomerName ?></h2>
        </div>


        <div class="col-md-6 col-sm-12 col-xs-12" style="background-color:lavenderblush;">
            <h2>Email : <?php echo $CustomerEmail ?></h2>
        </div>

    </div>
</div>
</body>

</html>
