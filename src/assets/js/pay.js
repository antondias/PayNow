function createNewSession(
    $sessionId,
    numberfield_ID,
    securityCode_ID,
    expiryMonth_ID,
    expiryYear_ID,
    success, error, timeoutError, internalError, initCall
) {
    PaymentSession.configure({
        session: $sessionId,
        fields: {
            card: {
                number: numberfield_ID,
                securityCode: securityCode_ID,
                expiryMonth: expiryMonth_ID,
                expiryYear: expiryYear_ID
            }
        },
        frameEmbeddingMitigation: ["javascript"],
        callbacks: {
            initialized: function (response) {
                initCall && initCall(response);
            },
            formSessionUpdate: function (response) {
                if (response.status) {
                    if ("ok" === response.status) {
                        success && success(response.session.id);
                    } else if ("fields_in_error" === response.status) {
                        error && error(response.errors);
                    } else if ("request_timeout" === response.status) {
                        timeoutError && timeoutError(response.errors.message);
                    } else if ("system_error" === response.status) {
                        internalError && internalError(response.errors.message);
                    }
                } else {
                    internalError && internalError("update failed");
                }
            }
        }
    });

}

function payNow() {
    PaymentSession.updateSessionFromForm('card');
}


function listenOnChangeOfFields() {
    PaymentSession.onChange(['card.securityCode'], function(selector) {

    });

    PaymentSession.onBlur(['card.securityCode'], function(selector) {

    });

    PaymentSession.onChange(['card.number'], function(selector) {

    });
}