<?php

/* @var \Treinetic\Paynow\entities\ViewCustomizer $vc */

?>
<div class="col-md-6 col-sm-12" style="margin-bottom: 20px;">
    <div class="order-summery">
        <h5 class="order-summery-title">
            Order Summery
        </h5>
        @foreach ($order->getItems() as $orderItem)
            <div class="order-item">
                <div class="row">
                    <div class="col-10 item-name">
                        {{$orderItem->getItemName()}}
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <ul class="list-unstyled">
                            <li class="qty">Qty : {{$orderItem->getQty()}}</li>
                            @if($orderItem->getDiscountText() && $orderItem->getDiscount())
                                <li class="discount">{{$orderItem->getDiscountText()}}</li>
                            @endif
                        </ul>

                    </div>
                    <div class="col-5 itemcostbox">
                        <div>
                            <ul class="list-unstyled cost-list">
                                <li class="item-cost">{{$order->getOrderCurrency()." ".trToCurrency($orderItem->getItemCost())}}</li>
                                @if($orderItem->getDiscountText() && $orderItem->getDiscount())
                                    <li class="discount">
                                        ({{$order->getOrderCurrency()." ".trToCurrency($orderItem->getDiscount())}})
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <hr class="order-total-separator"/>
        <div class="row order-total">
            <div class="col">
                Order Total
            </div>
            <div class="col-6 text-right">
                {{$order->getOrderCurrency()." ".trToCurrency($order->getTotal())}}
            </div>
        </div>
    </div>
</div>