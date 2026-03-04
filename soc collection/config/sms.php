<?php

function sendSMS($mobile, $message)
{
    $apiKey = "V9GXJ3nRI2Cmyq0a1hYlkuWsfrxH4bZtdpLcoTENUg8viMSQF5Jqz9kpMTCQIylc5hE4R7svVf2W6FwU";  // <-- API key here

    $fields = [
        "sender_id" => "URCCSL",
        "message"   => $message,
        "language"  => "english",
        "route"     => "q",
        "numbers"   => $mobile,
    ];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($fields),
        CURLOPT_HTTPHEADER => [
            "authorization: $apiKey",
            "accept: */*",
            "cache-control: no-cache",
            "content-type: application/json"
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}
?>