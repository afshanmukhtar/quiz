<?php
include_once('../../../../wp-load.php'); 
global $wpdb;
$table_name = $wpdb->prefix . 'quiz_results';
$email = $_POST['email'];
$rs = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE email = '%s' ", $email), ARRAY_A); 
$results = unserialize( $rs['results'] );
$user_id = $rs['id'];

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

if(isset($_POST['chart_image'])){

    $image = ( $_POST['chart_image'] );
    $data = explode(',', $image); 
    $chart_img = TDQ_PLUGIN_DIR.'tmp/chart-'.$user_id.'.png';
    $img = $data[1];
    $data = base64_decode($img);
    
    $im = imagecreatefromstring($data);
    if ($im !== false) { 
        imagepng($im, $chart_img); 
    }
      
    ob_clean();
    ob_start();
    $uname = $rs['name'];
    include (TDQ_PLUGIN_DIR . 'views/pdf.php'); 
    $html = ob_get_clean();
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->AddPage('P');
    $mpdf->WriteHTML($html);
    $mpdf->Output('report.pdf', 'D'); 
    unlink($chart_img);

}