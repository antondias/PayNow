<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 1/9/19
 * Time: 4:43 PM
 */

namespace Treinetic\Paynow\entities;


class ViewCustomizer
{

    private $clientLogo = "images/clientLogo.jpg";
    private $providerBrandings = "images/providerBranding.jpg";
    private $serviceUnavailable = "images/page/wentwrong.jpg";

    private $packageBase = "treinetic/paynow/";


    /**
     * @return mixed
     */
    public function getClientLogo()
    {
        return $this->packageBase.$this->clientLogo;
    }

    /**
     * @param mixed $clientLogo
     */
    public function setClientLogo($clientLogo): void
    {
        $this->clientLogo = $clientLogo;
    }

    /**
     * @return mixed
     */
    public function getProviderBrandings()
    {
        return $this->packageBase.$this->providerBrandings;
    }

    /**
     * @param mixed $providerBrandings
     */
    public function setProviderBrandings($providerBrandings): void
    {
        $this->providerBrandings = $providerBrandings;
    }

    /**
     * @return string
     */
    public function getServiceUnavailable(): string
    {
        return $this->packageBase.$this->serviceUnavailable;
    }

    /**
     * @param string $serviceUnavailable
     */
    public function setServiceUnavailable(string $serviceUnavailable): void
    {
        $this->serviceUnavailable = $serviceUnavailable;
    }



    /*
     * other customizings will come later
     *
     * */



}