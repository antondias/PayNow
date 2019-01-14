function showErrorMessages(e){var n=$(".validation-wrapper").hide(),t=$(".validation-errors").empty(),i=getFormValidationErrorMessags();if(i&&0<i.length)for(var a in n.show(),i)t.append("<li><i class='fa fa-exclamation-circle error-iconx' ></i>"+i[a]+"</li>");if(e&&0<e.length)for(var o in n.show(),e)t.append("<li><i class='fa fa-exclamation-circle error-iconx' ></i>"+e[o]+"</li>")}function handleValidationErrors(e){var n=[];e.securityCode||e.cardNumber||e.expiryMonth?(spinner().hide(),e.securityCode&&n.push("Security code is "+e.securityCode),e.cardNumber&&n.push("Card number is "+e.cardNumber),e.expiryMonth&&n.push("Expiration month is "+e.expiryMonth)):n.push("Unexpected error, please try again later"),showErrorMessages(n)}function spinner(){var n=$(".spinner-backdrop"),t=$(".text-message-spinner");return{show:function(e){t.hide(),n.show(),e&&(t.empty(),t.append(e),t.show())},hide:function(){t.hide(),n.hide()}}}function getFormElements(){return[$("#fullname"),$("#expMonth"),$("#expYear")]}function getFormValidationErrorMessags(){var e=getFormElements(),n=[];for(var t in e)e[t][0].checkValidity()?e[t].data("count")&&parseInt(e[t].data("count"))!==e[t].val().length&&n.push(e[t].data("vm")):n.push(e[t].data("vm"));return n}function getPaymentCompleteUrl(){return $("#complete-payment-url").val()}function getInitialSessionId(){return $("#initial-session-id").val()}function log(e){console.log(e)}function fixUi(e){setTimeout(function(){PaymentSession.setFocus("card.securityCode"),setTimeout(function(){PaymentSession.setFocus("card.number"),e&&e()},100)})}function makeFinalPaymentRequest(e,n,t,i){var a=JSON.parse(e.customData);e.customData=a,$.ajax(n,{data:JSON.stringify(e),contentType:"application/json",type:"POST"}).done(t).fail(i)}function buildFinalPaymentRequest(e){return{total:$("#validate-total").val(),orderId:$("#validate-orderId").val(),orderCurrency:$("#validate-currency").val(),sessionId:e,customData:$("#custom-data").val()}}function createNewSession(e,n,t,i,a,o,r,s,u,c){PaymentSession.configure({session:e,fields:{card:{number:n,securityCode:t,expiryMonth:i,expiryYear:a}},frameEmbeddingMitigation:["javascript"],callbacks:{initialized:function(e){c&&c(e)},formSessionUpdate:function(e){e.status?"ok"===e.status?o&&o(e.session.id):"fields_in_error"===e.status?r&&r(e.errors):"request_timeout"===e.status?s&&s(e.errors.message):"system_error"===e.status&&u&&u(e.errors.message):u&&u("update failed")}}})}function payNow(){PaymentSession.updateSessionFromForm("card")}function listenOnChangeOfFields(){PaymentSession.onChange(["card.securityCode"],function(e){}),PaymentSession.onBlur(["card.securityCode"],function(e){}),PaymentSession.onChange(["card.number"],function(e){})}$(function(){$('[data-toggle="tooltip"]').tooltip(),spinner().show(),$(".pay-button").click(function(e){0<getFormValidationErrorMessags().length?(e.preventDefault(),e.stopPropagation(),showErrorMessages()):(spinner().show("Initiating payment request"),payNow(),spinner().show())}),createNewSession(getInitialSessionId(),"#cardNumber","#cardCvv","#expMonth","#expYear",function(e){spinner().show("completing payment.."),makeFinalPaymentRequest(buildFinalPaymentRequest(e),getPaymentCompleteUrl(),function(e){spinner().hide(),log(e),e.status?($(".payment-complete").show(),$(".payment-make-view").hide()):($(".payment-failed-view .reasonfor-failior").hide(),$(".payment-failed-view").show(),$(".payment-make-view").hide(),e.reason&&($(".payment-failed-view .reasonfor-failior").html(e.reason),$(".payment-failed-view .reasonfor-failior").show()))},function(e){})},function(e){handleValidationErrors(e),log(e)},function(e){log(e)},function(e){log(e)},function(e){log(e),setTimeout(function(){fixUi(function(){spinner().hide()})},500)}),listenOnChangeOfFields(),$(".retry-button-payment").on("click",function(){$(".payment-failed-view").hide(),$(".payment-make-view").show()})});