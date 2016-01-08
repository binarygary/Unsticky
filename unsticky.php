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


add_action( 'post_submitbox_misc_actions', 'unsticky' );

function unsticky() {
    global $post;
    if (get_post_type($post) == 'post' && is_sticky($post->ID) ) {
		
        echo '<div class="misc-pub-section misc-pub-section-last" style="border-top: 1px solid #eee;">';
        wp_nonce_field( plugin_basename(__FILE__), 'unsticky_nonce' );
        if ( true === get_post_meta( $post->ID, '_unsticky_time') ) {
        	$unstickyTime = get_post_meta( $post->ID, '_unsticky_time', true );
        }
		
		echo "<label class=\"selectit\"><input id=\"in-popular-category-1\" type=\"checkbox\" ";
		
		//checked="checked" 
		echo "value=\"1\"  /> Unsticky Date </label>";
		
		//if unstickyTime is set display in the same format as the satandard time setting
		
		?>
		<span class="screen-reader-text">Edit date and time</span></a>
					<fieldset id="timestampdiv">
					<legend class="screen-reader-text">Date and time</legend>
					<div class="timestamp-wrap"><label><span class="screen-reader-text">Month</span><select id="mm" name="mm">
					<option value="01" data-text="Jan"  selected='selected'>01-Jan</option>
					<option value="02" data-text="Feb" >02-Feb</option>
					<option value="03" data-text="Mar" >03-Mar</option>
					<option value="04" data-text="Apr" >04-Apr</option>
					<option value="05" data-text="May" >05-May</option>
					<option value="06" data-text="Jun" >06-Jun</option>
					<option value="07" data-text="Jul" >07-Jul</option>
					<option value="08" data-text="Aug" >08-Aug</option>
					<option value="09" data-text="Sep" >09-Sep</option>
					<option value="10" data-text="Oct" >10-Oct</option>
					<option value="11" data-text="Nov" >11-Nov</option>
					<option value="12" data-text="Dec" >12-Dec</option>
		</select></label> <label><span class="screen-reader-text">Day</span><input type="text" id="jj" name="jj" value="08" size="2" maxlength="2" autocomplete="off" /></label>, <label><span class="screen-reader-text">Year</span><input type="text" id="aa" name="aa" value="2016" size="4" maxlength="4" autocomplete="off" /></label> @ <label><span class="screen-reader-text">Hour</span><input type="text" id="hh" name="hh" value="02" size="2" maxlength="2" autocomplete="off" /></label>:<label><span class="screen-reader-text">Minute</span><input type="text" id="mn" name="mn" value="07" size="2" maxlength="2" autocomplete="off" /></label></div><input type="hidden" id="ss" name="ss" value="22" />
		<?php
		//if it's not set then display standard format
		
        echo '</div>';
    }
}

add_action( 'save_post', 'save_unsticky' );

function save_unsticky( $post_id ) {

    if (!isset($_POST['post_type']) )
        return $post_id;

    if ( !wp_verify_nonce( $_POST['unsticky_nonce'], plugin_basename(__FILE__) ) )
        return $post_id;

    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
        return $post_id;

    if ( 'post' == $_POST['post_type'] && !current_user_can( 'edit_post', $post_id ) )
        return $post_id;
    
    if (!isset($_POST['']))
        return $post_id;
    else {
        $mydata = $_POST['article_or_box'];
        update_post_meta( $post_id, '_article_or_box', $_POST['article_or_box'], get_post_meta( $post_id, '_article_or_box', true ) );
    }

}
	
	