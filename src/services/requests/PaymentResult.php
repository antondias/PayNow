<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 1/9/19
 * Time: 1:33 PM
 */

namespace Treinetic\Paynow\services\requests;


class PaymentResult implements \JsonSerializable
{

    private $status = false;
    private $result;
    private $reason;

    public function __construct($result = null)
    {
        $this->setStatus($this->isSuccess($result));
        $this->result = $result;
        if ($this->figureErrorMessage($result)) {
            $this->reason = $this->figureErrorMessage($result);
        }
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     */
    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result): void
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param mixed $reason
     */
    public function setReason($reason): void
    {
        $this->reason = $reason;
    }

    private function figureErrorMessage($message)
    {
        if ($message) {
            if (array_key_exists("error", $message) && array_key_exists("result", $message) && $message["result"] == "ERROR") {
                $errr = $message["error"];
                if (array_key_exists("field", $errr) && $errr["field"] == "sourceOfFunds.provided.card.securityCode") {
                    return "CVV value is required to complete the transaction";
                } else if (array_key_exists("explanation", $errr)) {
                    return $errr["explanation"];
                }
                return "Unexpected error, please check your card information";
            }else if(array_key_exists("result", $message) && $message["result"] == "FAILURE"){
                return $this->getErrorMessageBasedOnGatewayCode($message);
            }
        }
    }

    private function isSuccess($message)
    {
        return $message && (array_key_exists("result", $message)) && ($message["result"] === "SUCCESS");
    }

    private function getErrorMessageBasedOnGatewayCode($message)
    {
        if (array_key_exists("response", $message) && array_key_exists("gatewayCode", $message["response"])) {
            switch ($message["response"]["gatewayCode"]){
                case "DECLINED" :
                    return "Your payment request has declined.";
                    break;
                case "EXPIRED_CARD" :
                    return "Card you entered has expired.";
                    break;
                case "TIMED_OUT" :
                    return "We could not process your request due to internal timeout please retry.";
                    break;
                case "ACQUIRER_SYSTEM_ERROR" :
                case "UNSPECIFIED_FAILURE" :
                case "UNKNOWN" :
                    return "Internal system error occurred please try again later.";
                default : {
                    return null;
                }
            }
        }
    }


}
