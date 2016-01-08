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
    if (get_post_type($post) == 'post') {
        echo '<div class="misc-pub-section misc-pub-section-last" style="border-top: 1px solid #eee;">';
        wp_nonce_field( plugin_basename(__FILE__), 'unsticky_nonce' );
        if ( true === get_post_meta( $post->ID, '_unsticky_time') ) {
        	$unstickyTime = get_post_meta( $post->ID, '_unsticky_time', true );
        }
		
		//if unstickyTime is set display in the same format as the satandard time setting
		
		//if it's not set then display standard format
		
        echo '</div>';
    }
}

add_action( 'save_post', 'save_unsticky' );

function save_unsticky($post_id) {

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
	
	