<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 1/7/19
 * Time: 4:17 PM
 */

namespace Treinetic\Paynow\services;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Treinetic\Paynow\services\requests\MasterCardApiRequest;
use Treinetic\Paynow\services\requests\PaymentRequestInterface;
use Treinetic\Paynow\services\requests\PaymentResult;

class MasterCardApiService
{

    private $baseendporint;  //https://cbcmpgs.gateway.mastercard.com.
    private $merchantId;
    private $clent;

    private $endpoints = [
        "create_session" => "/api/rest/version/50/merchant/{merchantId}/session",
        "pay" => "/api/rest/version/50/merchant/{merchantId}/order/{orderId}/transaction/{transactionId}"
    ];


    private function __construct($username, $password, $merchantId, $baseendporint)
    {
        $this->merchantId = $merchantId;
        $this->baseendporint = $baseendporint;
        $this->clent = new Client([
            'auth' => [$username, $password],
        ]);
    }

    public static function createInstance($username, $password, $merchantId, $baseendpoint)
    {
        return new MasterCardApiService($username, $password, $merchantId, $baseendpoint);
    }


    public function createSessionId(string $orderid, float $amount, string $currency)
    {
        $body = (new MasterCardApiRequest())
            ->addOrder($orderid, $amount, $currency)
            ->disableSecure3D()
            ->setApiOperation(MasterCardApiRequest::$APIOP_CREATE_CHECKOUT_SESSION)
            ->jsonSerialize();
        $res = null;
        try {

            $res = $this->clent->request("POST", $this->getUrl("create_session"), $body);
            $status_code = $res->getStatusCode();
            if ($status_code >= 200 && $status_code < 300) {
                $result = \GuzzleHttp\json_decode($res->getBody(), true);
                return $result["session"]["id"];
            } else {
                \Log::error($res->getBody(),[ "Place"=>"Create Session ID" ]);
                throw new MasterCardApiException($res->getBody(), 500);
            }
        } catch (\Exception $e) {
            \Log::error($e,[ "Place"=>"Create Session ID" ]);
            throw new MasterCardApiException($res->getBody(), 500);
        }
    }


    public function payFromCard($orderId, $currancy, $amount, $transactionId, $sessionId)
    {
        $body = (new MasterCardApiRequest())
            ->setSessionId($sessionId)
            ->setApiOperation(MasterCardApiRequest::$APIOP_PAY)
            ->addPartialOrder($amount, $currancy)
            ->addSourceOfFunds(MasterCardApiRequest::$SF_CARD)
            ->jsonSerialize();
        $url = $this->getPayUrl($orderId, $transactionId);
        \Log::debug(\GuzzleHttp\json_encode($body));
        \Log::debug($url);

        try{
            $result =  $this->clent->request("PUT", $url, ['json' => $body]);
            $message = \GuzzleHttp\json_decode($result->getBody()->getContents(),true);
            return new PaymentResult($message);
        }catch (ClientException $response) {
            $message = \GuzzleHttp\json_decode($response->getResponse()->getBody()->getContents(),true);
            return new PaymentResult($message);
        }
    }

    public function securePayFromCard(PaymentRequestInterface $requestData, $currancy, $amount, $transactionId)
    {
        \Log::debug(($requestData->getTotal()) . " == $amount &&  $currancy  == " . $requestData->getCurrency());
        if ($requestData->getTotal() == $amount && $requestData->getCurrency() == $currancy) {
            return $this->payFromCard($requestData->getOrderId(), $currancy, $amount, $transactionId, $requestData->getSessionId());
        } else {
            $paresult =  new PaymentResult();
            $paresult->setReason("Data mismatch error");
            return $paresult;
        }
    }

    private function getUrl($endpoint_name)
    {
        $url = $this->baseendporint . $this->endpoints[$endpoint_name];
        return str_replace("{merchantId}", $this->merchantId, $url);
    }

    private function getPayUrl($orderId, $transactionId)
    {
        $url = $this->getUrl("pay");
        $url = str_replace("{orderId}", $orderId, $url);
        $url = str_replace("{transactionId}", $transactionId, $url);
        return $url;
    }

    public function getMerchantId()
    {
        return $this->merchantId;
    }
}
