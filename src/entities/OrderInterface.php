<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 1/7/19
 * Time: 3:22 PM
 */

namespace Treinetic\Paynow\entities;


interface OrderInterface
{

    public function getId(): string;

    public function getItems();

    public function getTotal(): float ;

    public function getOrderCurrency(): string;

    public function getOrderDiscountText(): string;

    public function getOrderDiscount(): float;

}
