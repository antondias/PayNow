<?php

/* @var \Treinetic\Paynow\entities\ViewCustomizer $vc */

?>

<div class="@if ($vc->isResponsive()) col-md-6 col-sm-12 @else col-lg-12 col-md-12 col-sm-12 @endif">
    <div class="order-paymentinfo">
        <h5 class="order-paymentinfo-title">
            Payment Information
        </h5>
        <div class="provider-brandings">
            <img class="provider-logo"
                 src="{{ URL::asset($vc->getProviderBrandings()) }}">
        </div>
        <form role="form" novalidate="" class="payment-form">
            <div class="form-group">
                <label>Name on the card</label>
                <input id="fullname" type="text" class="form-control" required="required"
                       data-vm="Name on the card is required"
                />
            </div>

            <div class="form-group">
                <label>Card number</label>
                <input id="cardNumber" type="number" class="form-control" required="required" readonly
                       data-vm="Card number is required"
                />
            </div>

            <div class="row">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label><span class="hidden-xs">Expiration</span> </label>
                        <div class="input-group">
                            <input type="number" class="form-control" placeholder="MM"
                                   id="expMonth"
                                   required
                                   data-vm="Valid card expiration month is required",
                                   data-count="2"
                            />
                            <span class="slash"> / </span>
                            <input type="number" class="form-control" placeholder="YY"
                                   id="expYear"
                                   required
                                   data-vm="Valid card expiration year is required"
                                   data-count="2"
                            />
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group text-right">
                        <label data-toggle="tooltip" title=""
                               data-original-title="3 digits code on back side of the card">CVV
                            <i class="fa fa-question-circle cvvtootltip"></i>
                        </label>
                        <input type="text" placeholder="CVV" class="form-control" id="cardCvv"
                               required readonly
                               data-vm="CVV is required"
                        />
                    </div>
                    <input type="hidden" value="{{$sessionId}}" id="initial-session-id" />
                    <input type="hidden" value="{{$order->getTotal()}}" id="validate-total" />
                    <input type="hidden" value="{{$order->getOrderCurrency()}}" id="validate-currency" />
                    <input type="hidden" value="{{$order->getId()}}" id="validate-orderId" />
                    <input type="hidden" value="{{$completePayment}}" id="complete-payment-url" />
                    <input type="hidden" value="{{$customData}}" id="custom-data" />
                </div>
            </div>


            <div class="alert alert-warning validation-wrapper" role="alert">
                <ul class="list-unstyled validation-errors">
                </ul>
            </div>

            <button class="subscribe btn btn-primary btn-block pay-button mx-auto" type="button">
                CONFIRM PAYMENT
            </button>
        </form>
    </div>
</div>