<?php
/*
Plugin Name: Force First and Last Name as Display Name
Plugin URI: http://www.strangerstudios.com/wordpress-plugins/force-first-last/
Description: Forces all users' display name to be "First Last".
Version: .1
Author: Stranger Studios
Author URI: http://www.strangerstudios.com
*/
/*
	Copyright 2011	Stranger Studios	(email : jason@strangerstudios.com)
	GPLv2 Full license details in license.txt
*/

function ffl_save_extra_profile_fields( $user_id ) 
{
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	//set the display name
	$display_name = trim($_POST['first_name'] . " " . $_POST['last_name']);
	if(!$display_name)
		$display_name = $_POST['user_login'];
		
	$_POST['display_name'] = $display_name;
	
	$args = array(
			'ID' => $user_id,
			'display_name' => $display_name
	);   
	wp_update_user( $args ) ;
}
add_action( 'personal_options_update', 'ffl_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'ffl_save_extra_profile_fields' );

function ffl_user_register($user_id)
{
	//set the display name
	$info = get_userdata( $user_id );
               
	$display_name = trim($info->first_name . ' ' . $info->last_name);
	if(!$display_name)
		$display_name = $info->user_login;
			   
	$args = array(
			'ID' => $user_id,
			'display_name' => $display_name
	);
   
	wp_update_user( $args ) ;
}
add_action("user_register", "ffl_user_register");
