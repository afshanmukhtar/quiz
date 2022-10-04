<?php
function td_quiz_plugin_activation()
{
    WP_Filesystem();
    global $wp_filesystem;
    global $wpdb;
    $table_quiz = $wpdb->prefix . 'quiz';
    $table_result = $wpdb->prefix . 'quiz_results';
    $charset_collate = $wpdb->get_charset_collate(); 
    
	
     $sql = "DROP TABLE IF EXISTS $table_quiz;";
     $wpdb->query($sql);
	   $sql = "DROP TABLE IF EXISTS $table_result;";
     $wpdb->query($sql);
   //  delete_option("my_plugin_db_version");
	
    $sql = "CREATE TABLE IF NOT EXISTS " . $table_quiz . " ( 
        id int(11) NOT NULL AUTO_INCREMENT,
        question VARCHAR(255) NOT NULL,
        category VARCHAR(255) NOT NULL,
        quiz_group VARCHAR(10) DEFAULT NULL,
        page tinyint(4) NOT NULL,
        PRIMARY KEY  (id)
      ) $charset_collate;";
      
    $sql2 = "CREATE TABLE IF NOT EXISTS " . $table_result . " ( 
        id int(11) NOT NULL AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        results text DEFAULT NULL, 
        PRIMARY KEY  (id)
      ) $charset_collate;";
        
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);
    dbDelta($sql2);
    $sample_data = TDQ_PLUGIN_DIR."/sql/data.sql";
      
    $sql_insert = $wp_filesystem->get_contents( $sample_data );
    
    $sql_insert = str_replace( '#__quiz' , $table_quiz, $sql_insert);
     
    $rows_affected = $wpdb->query( $sql_insert );

    update_option( 'tdq_upgrade_content', '<h3>Wait, before you leave, you have one more step to leave before finalizing the order</h3>&nbsp;<center><iframe src="https://www.youtube.com/embed/QrLdabLKOBU" width="560" height="315" frameborder="0" allowfullscreen="allowfullscreen"></iframe></center>' );
}

function td_quiz_admin_enqueue_scripts() { 
    //wp_enqueue_script( 'bootstrap-bundle',  plugins_url( '/assets/js/bootstrap.bundle.min.js', TDQ_PLUGIN_DIR.'/td-quiz.php' ), array('jquery'), false, true);
    wp_enqueue_script( 'highcharts',  plugins_url( '/assets/js/highcharts.js', TDQ_PLUGIN_DIR.'/td-quiz.php' ), array('jquery'), false, false);
    wp_enqueue_script( 'highcharts-more',  plugins_url( '/assets/js/highcharts-more.js', TDQ_PLUGIN_DIR.'/td-quiz.php' ), array('jquery','highcharts'), false, false);
    wp_enqueue_script( 'tdq-admin-js',  plugins_url( '/assets/js/admin.js', TDQ_PLUGIN_DIR.'/td-quiz.php' ), array('jquery','highcharts','highcharts-more'), false, true);
   
}
 
add_action( 'admin_enqueue_scripts', 'td_quiz_admin_enqueue_scripts' );

function td_quiz_enqueue_scripts() {
    global $post;
             
    wp_enqueue_script( 'bootstrap-bundle',  plugins_url( '/assets/js/bootstrap.bundle.min.js', TDQ_PLUGIN_DIR.'/td-quiz.php' ), array('jquery'), false, true);
    wp_enqueue_script( 'skill-bars',  plugins_url( '/assets/js/skill.bars.jquery.js', TDQ_PLUGIN_DIR.'/td-quiz.php' ), array('jquery'), false, true);
    wp_enqueue_script( 'highcharts',  plugins_url( '/assets/js/highcharts.js', TDQ_PLUGIN_DIR.'/td-quiz.php' ), array('jquery'), false, true);
    wp_enqueue_script( 'highcharts-more',  plugins_url( '/assets/js/highcharts-more.js', TDQ_PLUGIN_DIR.'/td-quiz.php' ), array('jquery','highcharts'), false, true);
    
    wp_enqueue_script( 'tdq-js',  plugins_url( '/assets/js/custom.js', TDQ_PLUGIN_DIR.'/td-quiz.php' ), array('jquery','bootstrap-bundle','skill-bars','highcharts','highcharts-more'), false, true);
   
   // wp_enqueue_style( 'jquery-ui-css', plugins_url('/assets/css/jquery-ui.css', TDQ_PLUGIN_DIR.'/td-quiz.php'), false, false, 'all'); 
    
    wp_enqueue_style( 'animate-css', plugins_url('/assets/css/animate.css', TDQ_PLUGIN_DIR.'/td-quiz.php'), false, false, 'all');
    wp_enqueue_style( 'tdq-css', plugins_url('/assets/css/style.css', TDQ_PLUGIN_DIR.'/td-quiz.php'), false, false, 'all');
    
    wp_localize_script( 'tdq-js', 'tdq_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'page_id' => $post->ID ) );
        
}
 
add_action( 'wp_enqueue_scripts', 'td_quiz_enqueue_scripts' );

add_action('init', 'tdq_StartSession', 1);
function tdq_StartSession() {
    if(!session_id()) {
        session_start();
    }
}

function td_quiz_main_shortcode( $atts ) {
    ob_start();
    if(isset($_GET['action'])){
        switch ($_GET['action']){
            case 'cancel':
                include (TDQ_PLUGIN_DIR . "views/payment-cancel.php");
            break;
            case 'return':
            
                global $wpdb;
                $table_name = $wpdb->prefix . 'quiz_results'; // do not forget about tables prefix
                $email = $_GET['email'];
                $rs = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE email = %s", $email), ARRAY_A); 
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
                $score_arr['Aspirant and Subordinate'] = $Aspirant_Subordinate_score;
                
                 
                include (TDQ_PLUGIN_DIR . "views/download-pdf.php");  
                 
            break;
            case 'notify':
                 
            break;
        }
          
         
    }
    else{
        $_SESSION['quiz'] = array(); 
    
        //ob_start();
?>
        <div class="td-quiz">
            <div class="loading-status"></div>
            <div class="td-quiz-main-area">
<?php
           include (TDQ_PLUGIN_DIR . "views/user-info.php");
?>          </div>
        </div>
<?php
    }
    return ob_get_clean();
}
add_shortcode( 'TDQuiz', 'td_quiz_main_shortcode' );

function td_load_quiz_form(){
    global $wpdb,$post;
    $table_quiz = $wpdb->prefix . 'quiz';  
    $table_result = $wpdb->prefix . 'quiz_results';    
    $form = $_POST['form'];
    
    if(isset($_POST['email']) && isset($_POST['name'])){
        $_SESSION['quiz']['email'] = $_POST['email'];
        $_SESSION['quiz']['name'] = $_POST['name'];
    } 
    
	  if(isset($_POST['quiz_data'])){
    $quiz_data = $_POST['quiz_data'];
    $url = urldecode($quiz_data);
    $url_components = parse_url($url); 
    parse_str($url_components['path'], $params); 
    $categories = $params['cat'];
    
    foreach($categories as $group_name => $cats){
        foreach($cats as $cat_name => $val){
            foreach($val as $v){
                $_SESSION['quiz']['cat'][$group_name][$cat_name][] = $v;
            }
        }
    }
	  }
    /**
    ob_start();
    
    echo '<pre>';
    print_r( $_SESSION['quiz']['cat'] );
    echo '</pre>'; 
    **/
    
    //$form='finish';
    $form_html = NULL;
    ob_start();
    
    if($form !='finish'){
        $quiz_list = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_quiz WHERE page = %d", $form));



        include (TDQ_PLUGIN_DIR . "views/quiz-$form.php");
        $form_html = ob_get_clean();
        $data = array('form' => $form_html);
    }
    else{
        $email = $_SESSION['quiz']['email'];
        $name = $_SESSION['quiz']['name'];
        if(!empty($_SESSION['quiz']['cat'])){
            $cat_names = array();
            $score_arr = array();
            $group_arr = array();
            $total = 0;
            $Aspirant_Subordinate_score = 0;
            foreach($_SESSION['quiz']['cat'] as $group_name => $categories){
                foreach($categories as $cat_name => $v){
                    $score = 0;
                    foreach($v as $val){
                        $score +=$val;
                    }
                    $group_arr[$group_name][$cat_name] = $score;
                    
                    if($cat_name !='Aspirant' && $cat_name !='Subordinate'){
                        $cat_names[] = $cat_name;
                        $score_arr[$cat_name] = $score;
                    }
                    else{
                        $Aspirant_Subordinate_score += $score;
                    }
                    
                    $total += $score;
                }
            }
            $cat_names[] = 'Aspirant and Subordinate';
             
            $score_arr['Aspirant and Subordinate'] = $Aspirant_Subordinate_score;
            
            if(!isset($_POST['page_id']))
            $_POST['page_id']= get_option('tdq_page_id'); 
             $current_page_url = get_the_permalink($_POST['page_id']); 
            include (TDQ_PLUGIN_DIR . "views/quiz-results.php");
            $form_html = ob_get_clean();
            
            $cat_names = implode(',', $cat_names);
            $scores = implode(',', $score_arr);
        }
        
        
        
        $data = array('form' => $form_html, 'categories'=>$cat_names, 'score' => $scores);
        
        $results = serialize( array('score' => $group_arr, 'total' => $total) );
        
        $user_id = $wpdb->get_var(  "SELECT id FROM $table_result WHERE email = '$email'" );
        
        if($user_id){
            $wpdb->update( 
                $table_result, 
                array( 
                    'name' => $name,
                    'results' => $results
                ), 
                array( 'email' => $email ), 
                array( 
                    '%s',
                    '%s'
                ), 
                array( '%s' ) 
            );
        }
        else{
            $wpdb->insert( 
                $table_result, 
                array( 
                    'name' => $name, 
                    'email' => $email,
                    'results' => $results
                ), 
                array( 
                    '%s', 
                    '%s', 
                    '%s' 
                ) 
            );
        }
        
        
        $data1 = array(
            'inf_form_xid' => 'f0e17f6c149e7d64723629a6f0108064',
            'inf_form_name' => 'Web Form submitted',
            'infusionsoft_version' => '1.70.0.110576', 
            'inf_field_FirstName' => $name,
            'inf_field_Email' => $email
        );
          
        $endpoint_url = 'https://ru606.infusionsoft.com/app/form/process/f0e17f6c149e7d64723629a6f0108064';
        // Sets our options array so we can assign them all at once
        $options = [
            CURLOPT_URL        => $endpoint_url,
            CURLOPT_POST       => true,
            CURLOPT_POSTFIELDS => $data1,
        CURLOPT_RETURNTRANSFER=>true
        ];
        
        // Initiates the cURL object
        $curl = curl_init();
        
        // Assigns our options
        curl_setopt_array($curl, $options);
          //     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
          
            //curl_setopt($ch, CURLOPT_RETURNTRANSFER, );
        
        // Executes the cURL POST
        $results = curl_exec($curl);
        
        // Be kind, tidy up!
       curl_close($curl);
        
    }
    
    echo json_encode($data);
    wp_die();
}
add_action( 'wp_ajax_nopriv_td_load_quiz_form', 'td_load_quiz_form' );
add_action( 'wp_ajax_td_load_quiz_form', 'td_load_quiz_form' );

function td_load_thnaks_form(){
    ob_start();
    include (TDQ_PLUGIN_DIR . "views/quiz-thanks.php");
    echo ob_get_clean();
    wp_die();
}
add_action( 'wp_ajax_nopriv_td_load_thnaks_form', 'td_load_thnaks_form' );
add_action( 'wp_ajax_td_load_thnaks_form', 'td_load_thnaks_form' );