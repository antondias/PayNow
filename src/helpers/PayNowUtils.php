<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 1/9/19
 * Time: 9:01 AM
 */

namespace Treinetic\Paynow\helpers;


class PayNowUtils
{

    public static function asCurrency($amount){
        return number_format($amount, 2, '.', ',');
    }

}