<?php

/* @var \Treinetic\Paynow\entities\OrderItemInterface $orderItem */
/* @var \Treinetic\Paynow\entities\OrderInterface $order */
/* @var \Treinetic\Paynow\entities\ViewCustomizer $vc */
?>


<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Viditure ee whitelabled application">
    <link href="{{ URL::asset('treinetic/paynow/vendor/treinetic-bundle.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('treinetic/paynow/vendor/treinetic-design.css') }}" rel="stylesheet">
    <style>

        {{$vc->getStyle()}}
        {!!  $vc->getStyle() !!}
    </style>
</head>
<body>
<div class="container-fluid vertical-center">
    @if($active)
        <div class="row payment-make-view">
            <div class="col-12 col-md-10 col-lg-10 col-sm-12 mx-auto">
                <article class="card m-t-10 card-wrapp-box">
                    @if(!$completePayment)
                        <div class="missing-onfirmationRoute">Error : Unable to find confirmation route, please create a
                            route named 'trCompletePayment'
                        </div>
                    @endif

                    <div class="card-body p-4">
                        <div class="text-center merchant-branding">
                            <img src="{{ URL::asset($vc->getClientLogo()) }}">
                        </div>
                        <div class="row">
                            @include("paynow::separations.order.order")
                            <br/>
                            @include("paynow::separations.payment.pay")
                        </div>
                    </div>
                </article>
            </div>
        </div>
    @endif

    @if(!$active)
        @include("paynow::separations.payment.unable")
    @endif

    @include("paynow::separations.payment.complete")
    @include("paynow::separations.payment.failed")


</div>

@if($vc->hasTechSolutionBranding())
    <div class="solution-provider">
        @if($vc->getTechSolutionBrandingUrl() != null && $vc->getTechSolutionBrandingUrl() != "")
            <a href="{{$vc->getTechSolutionBrandingUrl()}}" target="_blank">
                {{$vc->getTechSolutionBranding()}}
            </a>
        @else
            {{$vc->getTechSolutionBranding()}}
        @endif
    </div>
@endif

<!--Loader code-->
@include("paynow::separations.loader.loader")
</body>
<script src="{{ URL::asset('treinetic/paynow/vendor/treinetic-bundle.js') }}"></script>
@if($active)
    <script src="https://cbcmpgs.gateway.mastercard.com/form/version/50/merchant/{{$merchant_id}}/session.js"></script>
    <script src="{{ URL::asset('treinetic/paynow/vendor/treinetic-script.js') }}"></script>

@endif
</html>







