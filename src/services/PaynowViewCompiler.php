<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 1/7/19
 * Time: 3:34 PM
 */

namespace Treinetic\Paynow\services;


use Treinetic\Paynow\entities\CreateSessionConfig;
use Treinetic\Paynow\entities\OrderInterface;
use Treinetic\Paynow\entities\ViewCustomizer;

class PaynowViewCompiler
{


    public static function compilePayView(OrderInterface $order, MasterCardApiService $api, $customData = [], ViewCustomizer $customizer = null)
    {
        $customizer = $customizer == null ? new ViewCustomizer() : $customizer;
        try {
            $url = route('trCompletePayment');
        } catch (\InvalidArgumentException $e) {
            $url = null;
        }
        try {
            $sessionId = $api->createSessionId(
                $order->getId(),
                $order->getTotal(),
                $order->getOrderCurrency()
            );
            return view("paynow::paynow", [
                "order" => $order,
                "merchant_id" => $api->getMerchantId(),
                "completePayment" => $url,
                "customData" => \GuzzleHttp\json_encode($customData),
                "sessionId" => $sessionId,
                "active" => true,
                "vc" => $customizer
            ]);
        } catch (MasterCardApiException $e) {
            return view("paynow::paynow", [
                "active" => false,
                "vc" => $customizer
            ]);
        }
    }

}