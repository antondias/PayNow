
<?php

/* @var \Treinetic\Paynow\entities\ViewCustomizer $vc */

?>
<div class="row">
    <div class="col-10 col-md-8 col-lg-5 col-sm-10 mx-auto text-center pt-5">
        <h2 class="unable-to-handle-title">Sorry...</h2>
        <img style="margin-top: 10px; margin-bottom: 10px" class="img-fluid" src="{{ URL::asset($vc->getServiceUnavailable()) }}" />
        <h3 class="unable-to-handle">We are unable to process payments at the moment please try again later.</h3>
    </div>
</div>