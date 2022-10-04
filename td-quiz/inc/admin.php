<?php
add_action('admin_menu', 'td_quiz_plugin_create_menu');

function td_quiz_plugin_create_menu() {
	add_menu_page(__('Quiz', 'tdq'), __('Quiz', 'tdq'), 'activate_plugins', 'td-quiz', 'td_quiz_list');
    add_submenu_page('td-quiz', __('Add new', 'tdq'), __('Add new', 'tdq'), 'activate_plugins', 'td-quiz-form', 'td_quiz_form');
    add_submenu_page('td-quiz', __('Quiz Users', 'tdq'), __('Quiz Users', 'tdq'), 'activate_plugins', 'td-quiz-results', 'td_quiz_results');
    
    add_submenu_page( 'td-quiz', __('Settings', 'tdq'), __('Settings', 'tdq'), 'activate_plugins', 'td-quiz-settings', 'td_quiz_settings');
    add_submenu_page( null, 'Report', 'Report', 'activate_plugins', 'td-quiz-report', 'td_quiz_report');
    
}
 
function td_quiz_list(){
    global $wpdb;

    $table = new TDQ_QUIZ_Table();
    $table->prepare_items();

    $message = '';
    if ('delete' === $table->current_action()) {
        $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Quiz deleted: %d', 'tdq'), count($_REQUEST['id'])) . '</p></div>';
    }
    ?>
    <div class="wrap">
    
        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2><?php _e('Quiz', 'tdq')?> <a class="add-new-h2"
                                     href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=td-quiz-form');?>"><?php _e('Add new', 'tdq')?></a>
        </h2>
        <?php echo $message; ?>
    
        <form id="persons-table" method="GET">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
            <?php 
            $table->search_box( __( 'Search Question' ), 'question' ); 
            $table->display();
            
             ?>
        </form>
    
    </div>
    <?php
}

function td_quiz_form()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'quiz'; // do not forget about tables prefix

    $message = '';
    $notice = '';

    // this is default $item which will be used for new records
    $default = array(
        'id' => 0,
        'question' => '',
        'category' => '',
        'quiz_group' => '',
        'page' => '',
         
    );
     
    // here we are verifying does this request is post back and have correct nonce
    if (isset($_POST['tdq_nonce'])) {
        if(!wp_verify_nonce($_POST['tdq_nonce'], 'tdq_form')){
            $notice = __('Security Error!', 'tdq');
        }
        else{
            
            // combine our default item with request params
            $item = shortcode_atts($default, $_REQUEST);
            // validate data, and if all ok save item to database
            // if id is zero insert otherwise update
         
            
            if ($item['id'] == 0) {
                $result = $wpdb->insert($table_name, $item);
                
                $item['id'] = $wpdb->insert_id;
                if ($result) {
                    $message = __('Quiz saved', 'tdq');
                } else {
                    $notice = __('There was an error while saving Quiz', 'tdq');
                }
            } else {
                $result = $wpdb->update($table_name, $item, array('id' => $item['id']));
                
                if ($result == 0 || $result > 0) {
                    $message = __('Quiz was successfully updated', 'tdq');
                } else {
                    $notice = __('There was an error while updating Quiz', 'tdq');
                }
            }
        }
         
    }
    else {
        // if this is not post back we load item to edit or give new one to create
         
        $item = $default;
        if (isset($_REQUEST['id'])) {
            $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $_REQUEST['id']), ARRAY_A);
            if (!$item) {
                $item = $default;
                $notice = __('Quiz not found', 'tdq');
            }
            
        }
    }
    $categories = array('Accountability','Aspirant','Global','Mentor','Personal','Professional','Subordinate','Toxic');
    $groups = array('Primary', 'Secondary'); 
    $pages = array(1,2,3,4);
    ?>
    <div class="wrap">
        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2><?php _e('Quiz', 'tdq')?> <a class="add-new-h2"
                                    href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=td-quiz');?>"><?php _e('back to list', 'tdq')?></a>
        </h2>
    
        <?php if (!empty($notice)): ?>
        <div id="notice" class="error"><p><?php echo $notice ?></p></div>
        <?php endif;?>
        <?php if (!empty($message)): ?>
        <div id="message" class="updated"><p><?php echo $message ?></p></div>
        <?php endif;?>
    
        <form id="form" method="POST">
            <?php wp_nonce_field( 'tdq_form', 'tdq_nonce' ); ?>
            <input type="hidden" name="id" value="<?php echo $item['id'] ?>"/>
    
            <div class="metabox-holder" id="poststuff">
                <div id="post-body">
                    <div id="post-body-content">
                        <?php 
                        include (TDQ_PLUGIN_DIR . 'views/admin/quiz-form.php');
                        ?>
                        
                        <input type="submit" value="<?php _e('Save', 'tdq')?>" id="submit" class="button-primary" name="submit"> <a class="button-primary" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=td-quiz');?>">Back to list</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php

}

function td_quiz_results(){

    $table = new TDQ_Results_Table();
    $table->prepare_items();
    if(isset($_REQUEST['id']))
    $count = (is_array($_REQUEST['id']) || is_object($_REQUEST['id'])) ? count($_REQUEST['id']) : 1 ;
	
	else 
		$count=1;
    $message = '';
    if ('delete' === $table->current_action()) {
        $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('User deleted: %d', 'tdq'), $count) . '</p></div>';
    } ?>
    <div class="wrap">
    
        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2><?php _e('Quiz', 'tdq')?></h2>
        <?php echo $message; ?>
    
        <form id="persons-table" method="GET">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
            <?php 
            $table->search_box( __( 'Search Name or Email' ), 'question' ); 
            $table->display(); ?>
        </form>
    
    </div>
    <?php

}


function td_quiz_report(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'quiz_results'; // do not forget about tables prefix
    $user_id = $_REQUEST['id'];
    $rs = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $user_id), ARRAY_A); 
    $email = $rs['email'];
    $results = unserialize( $rs['results'] );
     
    $score_arr = array();
    $score_separate = array();
    $cat_names = array();
    $total = 0;
    $Aspirant_Subordinate_score = 0;
    foreach($results['score'] as $group_name => $categories){
        $score = 0;
        foreach($categories as $cat_name => $v){
           
            $score_separate[$cat_name] = $v;
            
            if($cat_name !='Aspirant' && $cat_name !='Subordinate'){
                $cat_names[] = $cat_name;
                $score_arr[$cat_name] = $v;
            }
            else{
                $Aspirant_Subordinate_score += $v;
            }
            $total += $v;
        }
    }
    $cat_names[] = 'Aspirant and Subordinate';
    $score_arr['Aspirant and Subordinate'] = $Aspirant_Subordinate_score; ?>

    <div class="wrap">
        <h2>Report</h2>
        <?php include (TDQ_PLUGIN_DIR . 'views/admin/report.php'); ?>
    </div>
<?php
}


add_action( 'admin_init', 'register_tdq_settings' );
function register_tdq_settings() {
	 
register_setting( 'tdq-settings', 'tdq_page_id' ); 
	register_setting( 'tdq-settings', 'tdq_upgrade_content' ); 
    register_setting( 'tdq-settings', 'tdq_thankyou_content' ); 
    register_setting( 'tdq-settings', 'tdq_paypal_email' ); 
    register_setting( 'tdq-settings', 'tdq_paypal_mode' ); 
    register_setting( 'tdq-settings', 'tdq_price' ); 
	register_setting( 'tdq-settings', 'tdq_price1' ); 
	register_setting( 'tdq-settings', 'tdq_upgrade_txt' ); 
    register_setting( 'tdq-settings', 'tdq_upgrade_price' ); 
    register_setting( 'tdq-settings', 'tdq_phone' ); 
}
function td_quiz_settings(){
?>
    <div class="wrap">
        <h2>Settings</h2>
        
        <form method="post" action="options.php">
            <?php settings_fields( 'tdq-settings' ); ?>
            <?php do_settings_sections( 'tdq-settings' ); ?>
            <table class="form-table">
  <tr valign="top">
                    <th scope="row">Page ID:</th>
                    <td>  
                        <?php 
                        $page_id= get_option('tdq_page_id');
                      ?>  
                
      <input type="text" name="tdq_page_id" placeholder="0" value="<?php echo $page_id; ?>" style="width: 100%;" />
                      </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Upgrade Page Content:</th>
                    <td>  
                        <?php 
                        $upgrade_content = get_option('tdq_upgrade_content');
                        wp_editor( $upgrade_content, 'tdq_upgrade_content', array("textarea_rows" => 8) ); ?>  
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Thankyou/Download Page Content:</th>
                    <td>  
                        <?php 
                        $thankyou_content = get_option('tdq_thankyou_content');
                        wp_editor( $thankyou_content, 'tdq_thankyou_content', array("textarea_rows" => 8) ); ?>  
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Paypal Mode:</th>
                    <td>  
                    
                        <?php 
                        $tdq_paypal_mode = get_option('tdq_paypal_mode');
                        ?>  
                        <input type="radio" name="tdq_paypal_mode" value="live" <?php if($tdq_paypal_mode == 'live'){ echo 'checked'; } ?> /> Live
                        <input type="radio" name="tdq_paypal_mode" value="test" <?php if($tdq_paypal_mode == 'test'){ echo 'checked'; } ?> /> Test Mode (Sandbox)
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Paypal Email:</th>
                    <td>  
                    
                        <?php 
                        $tdq_paypal_email = get_option('tdq_paypal_email');
                        ?>  
                        <input type="text" name="tdq_paypal_email" value="<?php echo $tdq_paypal_email; ?>" style="width: 100%;" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Phone number:</th>
                    <td>   
                        <?php 
                        $tdq_phone = get_option('tdq_phone');
                        ?>  
                        <input type="text" name="tdq_phone" placeholder="561-329-LEAD" value="<?php echo $tdq_phone; ?>" style="width: 100%;" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Price ($):</th>
                    <td>   
                        <?php 
                        $tdq_price = get_option('tdq_price');
                        ?>  
                        <input type="text" name="tdq_price" placeholder="00.00" value="<?php echo $tdq_price; ?>" style="width: 100%;" />
                    </td>
                </tr>
				  <tr valign="top">
                    <th scope="row">Price (result page) ($):</th>
                    <td>   
                        <?php 
                        $tdq_price = get_option('tdq_price1');
                        ?>  
                        <input type="text" name="tdq_price1" placeholder="00.00" value="<?php echo $tdq_price; ?>" style="width: 100%;" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Upgrade Price ($):</th>
                    <td>   
                        <?php 
                        $tdq_upgrade_price = get_option('tdq_upgrade_price');
                        ?>  
                        <input type="text" name="tdq_upgrade_price" placeholder="00.00" value="<?php echo $tdq_upgrade_price; ?>" style="width: 100%;" />
                    </td>
                </tr>
				     <tr valign="top">
                    <th scope="row">Upgrade Text :</th>
                    <td>   
                        <?php 
                        $tdq_upgrade_price = get_option('tdq_upgrade_txt');
                        ?>  
                        <input type="text" name="tdq_upgrade_txt" placeholder="" value="<?php echo $tdq_upgrade_price; ?>" style="width: 100%;" />
                    </td>
                </tr>
            </table>
            
            <?php submit_button(); ?>
        
        </form>
    </div>
    <?php    
}