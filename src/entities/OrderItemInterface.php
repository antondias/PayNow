<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 1/7/19
 * Time: 3:23 PM
 */

namespace Treinetic\Paynow\entities;


interface OrderItemInterface
{
    public function getItemName(): string;

    public function getQty(): string;

    public function getDiscount(): float;

    public function getDiscountText();

    public function getItemCost(): float;

    public function getItemTotal(): float;

}