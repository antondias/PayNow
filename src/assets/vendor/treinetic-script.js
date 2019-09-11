function showErrorMessages(e) {
    var n = $(".validation-wrapper").hide(), i = $(".validation-errors").empty(), t = getFormValidationErrorMessags();
    if (t && 0 < t.length) for (var o in n.show(), t) i.append("<li><i class='fa fa-exclamation-circle error-iconx' ></i>" + t[o] + "</li>");
    if (e && 0 < e.length) for (var a in n.show(), e) i.append("<li><i class='fa fa-exclamation-circle error-iconx' ></i>" + e[a] + "</li>")
}

function handleValidationErrors(e) {
    var n = [];
    e.securityCode || e.cardNumber || e.expiryMonth ? (spinner().hide(), e.securityCode && n.push("Security code is " + e.securityCode), e.cardNumber && n.push("Card number is " + e.cardNumber), e.expiryMonth && n.push("Expiration month is " + e.expiryMonth)) : n.push("Unexpected error, please try again later"), showErrorMessages(n)
}

function spinner() {
    var n = $(".spinner-backdrop"), i = $(".text-message-spinner");
    return {
        show: function (e) {
            i.hide(), n.show(), e && (i.empty(), i.append(e), i.show())
        }, hide: function () {
            i.hide(), n.hide()
        }
    }
}

function getFormElements() {
    return [$("#fullname"), $("#expMonth"), $("#expYear")]
}

function getFormValidationErrorMessags() {
    var e = getFormElements(), n = [];
    for (var i in e) e[i][0].checkValidity() ? e[i].data("count") && parseInt(e[i].data("count")) !== e[i].val().length && n.push(e[i].data("vm")) : n.push(e[i].data("vm"));
    return n
}

function getPaymentCompleteUrl() {
    return $("#complete-payment-url").val()
}

function getInitialSessionId() {
    return $("#initial-session-id").val()
}

function log(e) {
    console.log(e)
}

function fixUi(e) {
    setTimeout(function () {
        PaymentSession.setFocus("card.securityCode"), setTimeout(function () {
            PaymentSession.setFocus("card.number"), e && e()
        }, 100)
    })
}

function makeFinalPaymentRequest(e, n, i, t) {
    var o = JSON.parse(e.customData);
    e.customData = o, $.ajax(n, {
        data: JSON.stringify(e),
        contentType: "application/json",
        type: "POST"
    }).done(i).fail(t)
}

function buildFinalPaymentRequest(e) {
    return {
        total: $("#validate-total").val(),
        orderId: $("#validate-orderId").val(),
        orderCurrency: $("#validate-currency").val(),
        sessionId: e,
        customData: $("#custom-data").val()
    }
}

function createNewSession(e, n, i, t, o, a, s, r, c, u) {
    PaymentSession.configure({
        session: e,
        fields: {card: {number: n, securityCode: i, expiryMonth: t, expiryYear: o}},
        frameEmbeddingMitigation: ["javascript"],
        callbacks: {
            initialized: function (e) {
                u && u(e)
            }, formSessionUpdate: function (e) {
                e.status ? "ok" === e.status ? a && a(e.session.id) : "fields_in_error" === e.status ? s && s(e.errors) : "request_timeout" === e.status ? r && r(e.errors.message) : "system_error" === e.status && c && c(e.errors.message) : c && c("update failed")
            }
        }
    })
}

function payNow() {
    PaymentSession.updateSessionFromForm("card")
}

function listenOnChangeOfFields() {
    PaymentSession.onChange(["card.securityCode"], function (e) {
    }), PaymentSession.onBlur(["card.securityCode"], function (e) {
    }), PaymentSession.onChange(["card.number"], function (e) {
    })
}

function Notification() {
}

$(function () {
    $('[data-toggle="tooltip"]').tooltip(), spinner().show(), $(".pay-button").click(function (e) {
        0 < getFormValidationErrorMessags().length ? (e.preventDefault(), e.stopPropagation(), showErrorMessages()) : (spinner().show("Initiating payment request"), payNow(), spinner().show())
    }), createNewSession(getInitialSessionId(), "#cardNumber", "#cardCvv", "#expMonth", "#expYear", function (e) {
        spinner().show("completing payment.."), makeFinalPaymentRequest(buildFinalPaymentRequest(e), getPaymentCompleteUrl(), function (e) {
            spinner().hide(), log(e), e.status ? ($(".payment-complete").show(), $(".payment-make-view").hide(), Notification.paymentSuccess()) : ($(".payment-failed-view .reasonfor-failior").hide(), $(".payment-failed-view").show(), $(".payment-make-view").hide(), e.reason && ($(".payment-failed-view .reasonfor-failior").html(e.reason), $(".payment-failed-view .reasonfor-failior").show()), Notification.paymentFailed())
        }, function (e) {
        })
    }, function (e) {
        handleValidationErrors(e), log(e)
    }, function (e) {
        log(e)
    }, function (e) {
        log(e)
    }, function (e) {
        log(e), setTimeout(function () {
            fixUi(function () {
                spinner().hide(), Notification.uiLoaded()
            })
        }, 500)
    }), listenOnChangeOfFields(), $(".retry-button-payment").on("click", function () {
        $(".payment-failed-view").hide(), $(".payment-make-view").show()
    })
}), Notification.toAndroid = function (e, n) {
    "undefined" != typeof TrPayNow && null !== TrPayNow && TrPayNow[e](n)
}, Notification.toIOS = function (e, n) {
    try {
        webkit.messageHandlers[e].postMessage(n)
    } catch (e) {
        console.log("The native context does not exist yet")
    }
}, Notification.toWeb = function (e, n) {
    if (e === "paymentSuccess") {
        n = "_wapp_payment_success_";
    } else if (e === "paymentFailed") {
        n = "_wapp_payment_fail_";
    }
    window.parent.postMessage(n, '*');
}, Notification.toDevices = function (e, n) {
    Notification.toAndroid(e, n), Notification.toIOS(e, n), Notification.toWeb(e, n)
}, Notification.uiLoaded = function () {
    Notification.toDevices("uiLoaded", null)
}, Notification.paymentFailed = function () {
    Notification.toDevices("paymentFailed", null)
}, Notification.paymentSuccess = function () {
    Notification.toDevices("paymentSuccess", null)
};
