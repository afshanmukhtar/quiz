<section class="quiz-forms" >
	<div class="row justify-content-center">
		<div class="col-12 animated fadeInDown visible" data-animation="fadeInDown" data-animation-delay="100">
			<div id="spider-chart"></div>
		</div>

		<div class="col-12 mx-auto fadeInTop visible" data-animation="fadeInTop" data-animation-delay="400">
			<div class="chart-details">
				<h3 class="chart-title">Dimension Scores:</h3>
				<ul>
					<?php foreach($score_arr as $cat_name => $score){
						echo '<li><p>'.$cat_name.': <span class="float-right text-right">'.$score.'</span></p></li>';
					} ?>
					<li>
						<p>Overall Dimension Score: <span class="float-right text-right"><?php echo $total; ?></span></p>
					</li>
				</ul>
			</div>
		</div>

		<div class="col-12">
			<p class="chart-bottom  txt-center">Are you ready to take strategic relationships to the next level?<br/>Do you desire to have effective, fulfilling connections with orders?<br/>If so, click below to get your full SCP Report and Workbook for only $<?php echo get_option('tdq_price', '1'); ?>.</p>

			<div class="decide-part">
				<?php global $wpdb;
				$table_result = $wpdb->prefix . 'quiz_results';
                $paypal_mode = get_option('tdq_paypal_mode', 'test');
                $paypal_link = 'https://www.paypal.com/cgi-bin/webscr';;
                if($paypal_mode == 'test'){
                    $paypal_link = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
                }
                $email = $_SESSION['quiz']['email'];
                $user_id = $wpdb->get_var( "SELECT id FROM $table_result WHERE email = '$email'" );

$page_id= get_option('tdq_page_id');
               $current_page_url =  get_the_permalink($page_id); 
              ?>
				<form action="<?php echo $paypal_link; ?>" method="post" target="_top">
                    <input type='hidden' name='business' value='<?php echo get_option('tdq_paypal_email'); ?>'> 
                    <input type='hidden' name='payer_email' value='<?php echo $email; ?>'>

                    <input type='hidden' name='item_name' value='Upgrade Relationships'> 
                    <input type='hidden' name='item_number' value='M<?php echo $user_id; ?>'> 
                    <input type='hidden' name='amount' value='<?php echo get_option('tdq_price', '1'); ?>'> 
                    <input type='hidden' name='no_shipping' value='1'> 
                    <input type='hidden' name='currency_code' value='USD'> 
                    <input type='hidden' name='notify_url'  value='<?php echo add_query_arg( 'action', 'notify', $current_page_url  ); ?>'>
                    <input type='hidden' name='cancel_return' value='<?php echo  add_query_arg( 'action', 'cancel', $current_page_url  ); ?>'>
                    <input type='hidden' name='return' value='<?php echo  add_query_arg( array( 'action' => 'return', 'email' => $email), $current_page_url ) ; ?>'>
                    <input type="hidden" name="cmd" value="_xclick"> 
                    <input type="submit" name="pay_now" id="pay_now" class="paypal-go" value="Yes, I'm Ready to Maximize My Relationships!">
                </form>
                <span>($<?php echo get_option('tdq_price1', '1'); ?> Value)</span>
				<a class="skip-paypal" id="thanks" href="<? echo site_url();?>">No, I want My Relationships to stay the Same</a>
			</div>
		</div>
	</div>
</section>
<style>
.txt-center
{
text-align:center;
}
.spider-chart
{
float:left;
}
</style>