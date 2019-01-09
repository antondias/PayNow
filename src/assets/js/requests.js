function makeFinalPaymentRequest($body,$url,$sucess,$error) {
    var customData = JSON.parse($body.customData);
    $body.customData = customData;
    $.ajax($url,{
        data : JSON.stringify($body),
        contentType : 'application/json',
        type : 'POST',
    }).done($sucess).fail($error);
}


function buildFinalPaymentRequest($sessionId) {
    return {
        "total" : $("#validate-total").val(),
        "orderId" : $("#validate-orderId").val(),
        "orderCurrency" : $("#validate-currency").val(),
        "sessionId" : $sessionId,
        "customData" : $("#custom-data").val()
    }
}