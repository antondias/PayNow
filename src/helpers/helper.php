<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 1/9/19
 * Time: 9:14 AM
 */

function trToCurrency($amount){
    return number_format($amount, 2, '.', ',');
}