Sample Code

```
 public function __construct()
    {
        $this->masterCardApi = \Treinetic\Paynow\services\MasterCardApiService::createInstance(
            "username",
            "password",
            "merchantId",
            "baseendpoint"
        );
    }
```

Crete Payment View

```

 return PaynowViewCompiler::compilePayView($order, $this->masterCardApi,[]);

```


Complete Payment

```

$this->masterCardApi->securePayFromCard($request, $db_currency, $db_total, $transactionId);

```

make sure to publish

```

php artisan vendor:publish --tag=paynow --force



```

and select `publish` tag 



### For devs 

* `gulp build` to create final js files
