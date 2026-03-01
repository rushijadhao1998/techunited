<?php
/* ============================================
   STPL SMS API CONFIGURATION
   ============================================ */

define('SMS_USERNAME', 'YOUR_STPL_USERNAME');
define('SMS_PASSWORD', 'YOUR_STPL_PASSWORD');
define('SMS_SENDERID', 'URCCSL'); // Header shown in template
define('SMS_TEMPLATEID', '1707172716376902168'); // Your DLT Template ID

/* ============================================
   SEND SMS FUNCTION
   ============================================ */

function sendSMS($mobile, $amount, $ledger, $account, $date, $balance)
{
    // remove spaces or +91
    $mobile = preg_replace('/[^0-9]/', '', $mobile);
    if(strlen($mobile) == 10) $mobile = "91".$mobile;

    /* MESSAGE (MATCHES YOUR TEMPLATE) */
    $message = "Dear Customer, A sum of Rs. $amount Collect By Agent with $ledger A/c No. $account on date $date. Available Balance is Rs. $balance Cr.- UNITED RURAL SOCIETY";
            // Dear Customer, A sum of Rs. 500 Collect By Agent with SMALL SAVING DEPOSITE A/c No. 213 On date 21/08/24. Available Balance is Rs. 10000 Cr. - UNITED RURAL SOCIETY

    // URL encode message
    $message = urlencode($message);

    /* API URL (STPL HTTP API) */
    $url = "http://sms.stpl.in/API/WebSMS/Http/v1.0a/index.php".
           "?username=".SMS_USERNAME.
           "&password=".SMS_PASSWORD.
           "&sender=".SMS_SENDERID.
           "&to=".$mobile.
           "&message=".$message.
           "&reqid=1".
           "&format=text".
           "&route_id=17".
           "&template_id=".SMS_TEMPLATEID;

    /* CURL REQUEST */
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $response = curl_exec($ch);
    $error    = curl_error($ch);

    curl_close($ch);

    /* LOG RESULT (optional but helpful) */
    $log = date("Y-m-d H:i:s")." | $mobile | $response | $error\n";
    file_put_contents(__DIR__."/sms_log.txt", $log, FILE_APPEND);

    return $response;
}
?>



// Dear Customer, A sum of Rs. {#var#} Collect By Agent with {#var#} A/c No. {#var#} On date {#var#}. Available Balance is Rs. {#var#} Cr.- UNITED RURAL SOCIETY

