function Notification() {
}


Notification.toAndroid = function (funcName,message) {
    if(typeof TrPayNow !== "undefined" && TrPayNow !== null) {
        TrPayNow[funcName](message);
    }
};

Notification.toIOS = function (funcName,message) {
    try {
        webkit.messageHandlers[funcName].postMessage(message);
    } catch (err) {
        console.log('The native context does not exist yet');
    }
};

Notification.toWeb = function (funcName,message) {
    if (funcName === "paymentSuccess") {
        message = "_wapp_payment_success_";
    } else if (funcName === "paymentFailed") {
        message = "_wapp_payment_fail_";
    }
    window.parent.postMessage(message, '*');
};

Notification.toDevices = function (funcName,message) {
    Notification.toAndroid(funcName,message);
    Notification.toIOS(funcName,message);
    Notification.toWeb(funcName,message);
};



Notification.uiLoaded = function () {
  Notification.toDevices("uiLoaded",null);
};

Notification.paymentFailed = function () {
    Notification.toDevices("paymentFailed",null);
};

Notification.paymentSuccess = function () {
    Notification.toDevices("paymentSuccess",null);
};

