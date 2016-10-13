<?php
/**
 * Plugin Name: smule grab
 * Plugin URI: http://causo.info
 * Description: Plugin for grabbin smule data.
 * Version: 1.0.0
 * Author: rixlabs
 * Author URI: http://causo.info
 * License: GPL2
 */
function smule_grab($atts){
	
	$sgrab_atts = shortcode_atts( array(
        'query' => 'sound'
    ), $atts );

	
	
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => 'http://www.smule.com/search/by_type?q=%23'.$sgrab_atts['query'].'&type=recording',
		CURLOPT_USERAGENT => 'cURL Request'
	));
	
	$resp = curl_exec($curl);
	
	curl_close($curl);

	$parsed = json_decode($resp);

	$counter = 0;
	foreach($parsed ->{'list'} as $item):
		$counter = $counter +1;
		
        if($counter % 3 == 0){
            echo '<div class="row">';
        }
        
        echo '<div class="col-md-3">';
            echo '<div class="thumbnail"><br>';
                echo '<img src="'.$item->{'cover_url'}.'" style="height:150px; width:150px;"/>';
                echo '<div class="caption">';
                    echo '<div align="center"><h3>'.$item->{'title'}.'</h3>';
                        echo '<p>❤ '.$item->{'stats'}->{'total_loves'}.'</p>';
                        echo '<a target="_blank" href="http://www.smule.com'.$item->{'web_url'}.'"><h3><span class="label label-warning">Ascolta</span></h3></a>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';

        if($counter % 3 == 0){
            echo '</div>';
        }
	endforeach;
}
	
add_shortcode('smule-grab', 'smule_grab');
	
?>