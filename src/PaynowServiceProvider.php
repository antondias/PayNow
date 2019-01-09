<?php
/**
 * Created by PhpStorm.
 * User: imal365
 * Date: 1/7/19
 * Time: 6:21 AM
 */

namespace Treinetic\Paynow;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class PaynowServiceProvider extends ServiceProvider
{

    public function boot(){
        $this->registerHelpers();
        $this->loadRoutesFrom(__DIR__."/routes/web.php");
        $this->loadViewsFrom(__DIR__.'/views','paynow');
        $this->publishes([
            __DIR__.'/assets' => public_path('treinetic/paynow'),], 'public');
    }

    public function register(){

    }

    private function registerHelpers()
    {
        if (file_exists($file = __DIR__.'/helpers/helper.php'))
        {
            require_once $file;
        }
    }

}