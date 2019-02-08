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


Notification.toDevices = function (funcName,message) {
    Notification.toAndroid(funcName,message);
    Notification.toIOS(funcName,message);
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

