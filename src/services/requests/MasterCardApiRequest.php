<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 1/8/19
 * Time: 4:32 PM
 */

namespace Treinetic\Paynow\services\requests;


class MasterCardApiRequest implements \JsonSerializable
{
    public static $APIOP_CREATE_CHECKOUT_SESSION = "CREATE_CHECKOUT_SESSION";
    public static $APIOP_PAY = "PAY";

    public static $SF_CARD = "CARD";

    private $session;
    private $order;
    private $apiOperation;
    private $interaction;
    private $risk;
    private $sourceOfFunds;

    /**
     * @param mixed $apiOperation
     */
    public function setApiOperation($apiOperation)
    {
        $this->apiOperation = $apiOperation;
        return $this;
    }

    public function addOrder($orderId, $amount, $currancy)
    {
        $this->order = [
            "id" => $orderId,
            "amount" => $amount,
            "currency" => $currancy
        ];
        return $this;
    }

    public function addPartialOrder($amount, $currancy)
    {
        $this->order = [
            "amount" => $amount,
            "currency" => $currancy
        ];
        return $this;
    }


    public function disableSecure3D()
    {
        $this->interaction = [
            "action" => [
                "3DSecure" => "BYPASS"
            ]
        ];
        $this->risk = [
            "bypassMerchantRiskRules" => "ALL"
        ];
        return $this;
    }

    public function addSourceOfFunds($source)
    {
        $this->sourceOfFunds = [
            "type" => $source
        ];
        return $this;
    }

    public function setSessionId($sessionId)
    {
        $this->session = [
            "id" => $sessionId
        ];

        return $this;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }


}