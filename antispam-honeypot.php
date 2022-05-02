<?php
/**
 * @package Antispam Honeypot by nexTab
 * @version 0.9
 */
/*
Plugin Name: Antispam-Honeypot
Plugin URI: http://www.nextab.de
Description: This plugin adds two honeypots to the default WordPress Comments Module that successfully fool 99% of all spam bots. Additional credit goes to David Keulert who introduced this technique on his blog at https://fastwp.de/9497/
Author: nexTab - Oliver Gehrmann
Version: 1.1
Author URI: http://nexTab.de/
*/

function nextab_widget_enqueue_script() {   
	wp_enqueue_script( 'antispam_honeypot_script', plugin_dir_url( __FILE__ ) . 'js/antispam-honeypot.js', array(), '1.1', true );
}
add_action('wp_enqueue_scripts', 'nextab_widget_enqueue_script');

function honeypot_comment_inputs($comment_data)
{
	if ( is_user_logged_in() /* && current_user_can('edit_posts') */ ) return $comment_data;
	if (!empty($_POST['honigtoepfchen1'])) {
		die('Try again, spambot, I dare you!');
	}
	if (empty($_POST['honigtoepfchen2'])) {
		die('I double dare you!');
	}
	return $comment_data;
}
add_action('preprocess_comment', 'honeypot_comment_inputs');

function add_honigtoepfchen()
{
	echo '<p style="background-color:transparent;border:0;float:right;height:0;padding:0;width:0;"><input name="honigtoepfchen1" type="text" maxlength="245" autocomplete="off" style="background-color:transparent;border:0;float:right;height:0;padding:0;width:0;"><input id="nxt_comment_input_2" name="honigtoepfchen2" type="text" maxlength="245" autocomplete="off" style="background-color:transparent;border:0;float:right;height:0;padding:0;width:0;"></p>';
}
add_action('comment_form_after_fields', ('add_honigtoepfchen'));