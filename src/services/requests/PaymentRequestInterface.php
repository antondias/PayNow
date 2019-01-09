<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 1/8/19
 * Time: 7:06 PM
 */

namespace Treinetic\Paynow\services\requests;


interface PaymentRequestInterface
{

    public function getOrderId();
    public function getTotal();
    public function getCurrency();
    public function getSessionId();
    public function getCustomData();

}