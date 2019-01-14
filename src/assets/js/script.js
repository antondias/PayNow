$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    spinner().show();
    $(".pay-button").click(function (event) {
        if (getFormValidationErrorMessags().length > 0) {
            event.preventDefault();
            event.stopPropagation();
            showErrorMessages();
        } else {
            spinner().show("Initiating payment request");
            payNow();
            spinner().show();
        }
    });

    var $sessionId = getInitialSessionId();
    createNewSession(
        $sessionId,
        "#cardNumber",
        "#cardCvv",
        "#expMonth",
        "#expYear", function (sessionId) {
            spinner().show("completing payment..");
            var $body = buildFinalPaymentRequest(sessionId);
            var $url = getPaymentCompleteUrl();
            makeFinalPaymentRequest($body, $url, function (response) {
                spinner().hide();
                log(response);
                if (response.status) {
                    $(".payment-complete").show();
                    $(".payment-make-view").hide();
                } else {
                    $(".payment-failed-view .reasonfor-failior").hide();
                    $(".payment-failed-view").show();
                    $(".payment-make-view").hide();
                    if (response.reason) {
                        $(".payment-failed-view .reasonfor-failior").html(response.reason);
                        $(".payment-failed-view .reasonfor-failior").show();
                    }
                }

            }, function (response) {

            });
        },
        function (errors) {
            handleValidationErrors(errors);
            log(errors);
        }, function (error) {
            //tiemout error
            log(error);
        }, function (error) {
            //internal error
            log(error);
        }, function (init) {
            //init call
            log(init);
            setTimeout(function () {
                fixUi(function () {
                    spinner().hide();
                })
            }, 500);
        });

    listenOnChangeOfFields();


    $(".retry-button-payment").on("click", function () {
        $(".payment-failed-view").hide();
        $(".payment-make-view").show();
    })
});

function showErrorMessages(customMessags) {
    var vwrapper = $(".validation-wrapper").hide();
    var verrors = $(".validation-errors").empty();
    var messaegs = getFormValidationErrorMessags();
    if (messaegs && messaegs.length > 0) {
        vwrapper.show();
        for (var m in messaegs) {
            verrors.append("<li><i class='fa fa-exclamation-circle error-iconx' ></i>" + messaegs[m] + "</li>");
        }
    }

    if (customMessags && customMessags.length > 0) {
        vwrapper.show();
        for (var m1 in customMessags) {
            verrors.append("<li><i class='fa fa-exclamation-circle error-iconx' ></i>" + customMessags[m1] + "</li>");
        }
    }
}

function handleValidationErrors(errors) {
    var customMessages = [];
    if (errors.securityCode || errors.cardNumber || errors.expiryMonth) {
        spinner().hide();
        if (errors.securityCode) {
            customMessages.push("Security code is " + errors.securityCode);
        }
        if (errors.cardNumber) {
            customMessages.push("Card number is " + errors.cardNumber);
        }
        if (errors.expiryMonth) {
            customMessages.push("Expiration month is " + errors.expiryMonth);
        }
    } else {
        customMessages.push("Unexpected error, please try again later");
    }
    showErrorMessages(customMessages);
}


function spinner() {
    var sp = $(".spinner-backdrop");
    var text = $(".text-message-spinner");
    return {
        show: function (msg) {
            text.hide();
            sp.show();
            if (msg) {
                text.empty();
                text.append(msg);
                text.show();
            }
        },
        hide: function () {
            text.hide();
            sp.hide();
        }
    }
}


//utils

function getFormElements() {
    return [$("#fullname"), $("#expMonth"), $("#expYear")];
}

function getFormValidationErrorMessags() {
    var allElements = getFormElements();
    var messages = [];
    for (var x in allElements) {
        if (!allElements[x][0].checkValidity()) {
            messages.push(allElements[x].data("vm"));
        } else {
            if (allElements[x].data("count")) {
                if ((parseInt(allElements[x].data("count")) !== allElements[x].val().length)) {
                    messages.push(allElements[x].data("vm"));
                }
            }
        }
    }
    return messages;
}

function getPaymentCompleteUrl() {
    return $("#complete-payment-url").val();
}

function getInitialSessionId() {
    return $("#initial-session-id").val();
}

function log(message) {
    console.log(message);
}

function fixUi(done) {
    setTimeout(function () {
        PaymentSession.setFocus('card.securityCode');
        setTimeout(function () {
            PaymentSession.setFocus('card.number');
            done && done();
        }, 100);
    })
}