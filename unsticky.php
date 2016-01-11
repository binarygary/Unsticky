<?php
/**
 * Plugin Name: Unsticky
 * Version: 0.1-alpha
 * Description: PLUGIN DESCRIPTION HERE
 * Author: YOUR NAME HERE
 * Author URI: YOUR SITE HERE
 * Plugin URI: PLUGIN SITE HERE
 * Text Domain: unsticky
 * Domain Path: /languages
 * @package Unsticky
 */

require_once( ABSPATH . "wp-includes/pluggable.php" );

//this is for testing only
unsticky_unstick();

register_activation_hook ( __FILE__, 'unsticky_scheduler' );
function unsticky_scheduler () {
	
	wp_schedule_event(time(), 'hourly', 'unsticky_unstick' );
	
}

register_deactivation_hook (__FILE__, 'unsticky_unscheduler' );
function unsticky_unscheduler() {
	wp_clear_scheduled_hook( 'unsticky_unstick' );
}

function unsticky_unstick() {
	$args = array(
	   'post__in' => get_option('sticky_posts')
   	);
	$my_query = new WP_Query($args);
	//print_r($my_query);
	while ($my_query->have_posts()) {
		//the_post();
		//echo the_ID();
		//print_r($my_query->posts);
		//print_r($myquery);
	}
	//Pull the meta
	//if unstick is set and age is <time()

	//unstick_post($post_id);
}

add_action( 'post_submitbox_misc_actions', 'unsticky' );

function unsticky() {
	global $post;
		
    if (get_post_type($post) == 'post' && is_sticky($post->ID) ) {
		
        echo '<div class="misc-pub-section misc-pub-section-last" style="border-top: 1px solid #eee;">';
        $offset = get_option( 'gmt_offset' ) * HOUR_IN_SECONDS;
		$whenToUnstick=time()+$offest;
		if ( true == get_post_meta( $post->ID, '_unsticky_time') ) {
        	$whenToUnstick = get_post_meta( $post->ID, '_unsticky_time', true );
		}
		$month=date('F',$whenToUnstick);
		$year=date('Y',$whenToUnstick);
		$day=date('j',$whenToUnstick);
		$hour=date('G',$whenToUnstick);
		$minute=date('i',$whenToUnstick);
		$second=date('s',$whenToUnstick);
		?>
		<h4>Schedule When to Unsticky:</h4>
		<span class="screen-reader-text">Scheduled Unsticky Date and Time</span>
		<fieldset id="timestampdiv">
		<legend class="screen-reader-text">Scheduled Unsticky Date and Time</legend>
		<div class="timestamp-wrap"><label><span class="screen-reader-text">Month</span>
		<select id="month" name="month">
		<?php
		for ($i=1; $i<13; $i++) {
			$numberMonth=$i;
			if (strlen($numberMonth)<2) {
				$numberMonth="0"."$numberMonth";
			}
			echo "<option value=$numberMonth ";
			if ((int)$month === (int)$numberMonth) {
				echo "selected";
			}
			echo ">$numberMonth</option>";
		}
		?>
		</select></label> <label><span class="screen-reader-text">Day</span>
		<input type="text" id="day" name="day" value="<?php echo $day; ?>" size="2" maxlength="2" autocomplete="off" /></label>, <label><span class="screen-reader-text">Year</span>
		<input type="text" id="year" name="year" value="<?php echo $year; ?>" size="4" maxlength="4" autocomplete="off" /></label> @ <label><span class="screen-reader-text">Hour</span>
		<input type="text" id="hour" name="hour" value="<?php echo $hour; ?>" size="2" maxlength="2" autocomplete="off" /></label>:<label><span class="screen-reader-text">Minute</span>
		<input type="text" id="minute" name="minute" value="<?php echo $minute; ?>" size="2" maxlength="2" autocomplete="off" /></label></div>
		<input type="hidden" id="second" name="second" value="<?php echo $second; ?>" />
		<?php
		//if it's not set then display standard format
		
        echo '</div>';
    }
}

add_action( 'save_post', 'save_unsticky' );
function save_unsticky( $post_id ) {

	//print_r($_POST);
	
    //if (!isset($_POST['post_type']) )
    //    return $post_id;

    //if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
    //    return $post_id;

    //if ( 'post' == $_POST['post_type'] && !current_user_can( 'edit_post', $post_id ) )
    //    return $post_id;
    
    //if (!isset($_POST['unsticky_nonce'])) {
	//	return $post_id;
	//} else {
		$unstickyTime=strtotime("$_POST[month]/$_POST[day]/$_POST[year] $_POST[hour]:$_POST[minute]:$_POST[second]");
		update_post_meta( $post_id, '_unsticky_time', $unstickyTime );
		//print_r($_POST);
		return $post_id;
		
		//}

}
	
	