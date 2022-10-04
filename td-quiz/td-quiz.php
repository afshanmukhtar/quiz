<?php
/**
Plugin Name: TD Quiz
Plugin URI: 
Description: 
Version: 1.0
Author: TDTeam - afshan.mukhtar@gmail.com
Author URI: mailto:Afshan.mukhtar@gmail.com
License: GPLv2 or later
Text Domain: TDQ
*/
define( 'TDQ_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define('TDQ_PLUGIN_URI', plugin_dir_url(__FILE__));
//define('_MPDF_PATH', TDQ_PLUGIN_DIR.'inc/mpdf/');
//define('_MPDF_URI', TDQ_PLUGIN_URI.'inc/mpdf/');
require_once( TDQ_PLUGIN_DIR . '/inc/mpdf/vendor/autoload.php' ); 
require_once( TDQ_PLUGIN_DIR . '/inc/class.quiz-admin-table.php' ); 
require_once( TDQ_PLUGIN_DIR . '/inc/class.quiz-results-table.php' );
require_once( TDQ_PLUGIN_DIR . '/inc/admin.php' );
require_once( TDQ_PLUGIN_DIR . '/inc/functions.php' ); 
register_activation_hook(__FILE__, 'td_quiz_plugin_activation');