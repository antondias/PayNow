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
        if($message){
            if (array_key_exists("error", $message) && array_key_exists("result", $message) && $message["result"] == "ERROR") {
                $errr = $message["error"];
                if(array_key_exists("field",$errr) && $errr["field"] == "sourceOfFunds.provided.card.securityCode"){
                    return "CVV value is required to complete the transaction";
                }else if(array_key_exists("explanation",$errr)){
                    return $errr["explanation"];
                }
                return "Unexpected error, please check your card information";
            }
        }
    }

    private function isSuccess($message){
        return $message && (array_key_exists("result", $message))  && ($message["result"] === "SUCCESS");
    }



}