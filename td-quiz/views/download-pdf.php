<section class="quiz-forms" >
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="decided-part">
                <?php if( isset($_GET['payment_step2']) &&  $_GET['payment_step2']==1) { ?>

                    <?php echo get_option('tdq_thankyou_content'); ?>
                    <form id="download-form" method="POST" action="<?php echo TDQ_PLUGIN_URI; ?>/inc/download.php" >
                        <div id="results-chart" style="display: none;"></div>
                        <input type="hidden" name="chart_image" id="chart_image" value="" />
                        <input type="hidden" name="email" value="<?php echo $email; ?>" />
                        <input type="button" class="button-primary" id="download-pdf" value="Download pdf" />
                    </form>

                <?php } else { ?>

                    <?php echo get_option('tdq_upgrade_content'); ?>
                    <?php
                        $paypal_mode = get_option('tdq_paypal_mode', 'test');
                        $paypal_link = 'https://www.paypal.com/cgi-bin/webscr';;
                        if($paypal_mode == 'test'){
                            $paypal_link = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
                        }
						if(empty($_POST['page_id']))
							 $_POST['page_id']= $page_id= get_option('tdq_page_id');
                        $current_page_url = get_the_permalink($_POST['page_id']); 
                    ?>
                    <form action="<?php echo $paypal_link; ?>" method="post" target="_top">
                        <input type='hidden' name='business' value='<?php echo get_option('tdq_paypal_email'); ?>'> 
                        <input type='hidden' name='payer_email' value='<?php echo $email; ?>'>  

                        <input type='hidden' name='item_name' value='Upgrade Relationships'> 
                        <input type='hidden' name='item_number' value='M<?php echo "upgrade"; ?>'> 
                        <input type='hidden' name='amount' value='<?php echo get_option('tdq_upgrade_price', '1'); ?>'> 
                        <input type='hidden' name='no_shipping' value='1'> 
                        <input type='hidden' name='currency_code' value='USD'> 
                        <input type='hidden' name='notify_url'  value='<?php echo add_query_arg( 'action', 'notify', $current_page_url  ); ?>'>
                        <input type='hidden' name='cancel_return' value='<?php echo add_query_arg( 'action', 'cancel', $current_page_url  ); ?>'>
                        <input type='hidden' name='return' value='<?php echo add_query_arg( array( 'action' => 'return', 'email' => $email,'payment_step2'=>1), $current_page_url ) ; ?>'>
                        <input type="hidden" name="cmd" value="_xclick"> 
                        <input type="submit" name="pay_now" id="pay_now" class="paypal-go  txtgreen" value="Yes ,I want to go to next level in relationship">
                    </form>

                    <form id="download-form" method="POST" action="<?php echo TDQ_PLUGIN_URI; ?>/inc/download.php" >
                        <div id="results-chart" style="display: none;"></div>
                        <input type="hidden" name="chart_image" id="chart_image" value="" />
                        <input type="hidden" name="email" value="<?php echo $email; ?>" />
                        <input type="button" class="button-primary" id="download-pdf" value="Download Report" />
                    </form>

                    <canvas id="canvas" width="5" height="5" ></canvas>

                <?php }  ?>

            </div>
        </div>
    </div>
</section>
 
<script>
    var cats = ['<?php echo implode("','", $cat_names); ?>']; 
    var scores = [<?php echo implode(',', $score_arr); ?>];
    (function ($) { 
    //code here
    })(jQuery);
</script>