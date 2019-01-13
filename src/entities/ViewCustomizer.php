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

    private $tech_solution_branding = "Technology solution by Treinetic (pvt) Ltd.";
    private $tech_solution_branding_url = "";


    private $packageBase = "treinetic/paynow/";


    public function __construct()
    {
        $this->providerBrandings = $this->packageBase . $this->providerBrandings;
        $this->serviceUnavailable = $this->packageBase . $this->serviceUnavailable;
        $this->clientLogo = $this->packageBase . $this->clientLogo;
    }

    /**
     * @return mixed
     */
    public function getClientLogo()
    {
        return $this->clientLogo;
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
        return $this->providerBrandings;
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
        return $this->serviceUnavailable;
    }

    /**
     * @param string $serviceUnavailable
     */
    public function setServiceUnavailable(string $serviceUnavailable): void
    {
        $this->serviceUnavailable = $serviceUnavailable;
    }

    /**
     * @return string
     */
    public function getTechSolutionBranding(): string
    {
        return $this->tech_solution_branding;
    }

    /**
     * @param string $tech_solution_branding
     */
    public function setTechSolutionBranding(string $tech_solution_branding): void
    {
        $this->tech_solution_branding = $tech_solution_branding;
    }

    /**
     * @return string
     */
    public function getTechSolutionBrandingUrl(): string
    {
        return $this->tech_solution_branding_url;
    }

    /**
     * @param string $tech_solution_branding_url
     */
    public function setTechSolutionBrandingUrl(string $tech_solution_branding_url): void
    {
        $this->tech_solution_branding_url = $tech_solution_branding_url;
    }


    public function hasTechSolutionBranding(): bool
    {
        return $this->tech_solution_branding != null && $this->tech_solution_branding != "";
    }

    /*
     * other customizings will come later
     *
     * */


}