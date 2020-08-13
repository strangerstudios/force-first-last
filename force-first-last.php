<?php
/*
Plugin Name: Force First and Last Name as Display Name
Plugin URI: https://www.strangerstudios.com/wordpress-plugins/force-first-last/
Description: Force the user field display_name to be set as the user's first and last name.
Version: 1.1
Author: Stranger Studios
Author URI: https://www.strangerstudios.com
*/
/*
	Copyright 2011	Stranger Studios	(email : jason@strangerstudios.com)
	GPLv2 Full license details in license.txt
*/

define( 'FFL_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Hide Display Name field on profile page.
 *
 */
function ffl_show_user_profile( $user ) { ?>
	<script>
		jQuery(document).ready(function() {
			jQuery('#display_name').parent().parent().hide();
		});
	</script>
	<?php
}
add_action( 'show_user_profile', 'ffl_show_user_profile' );
add_action( 'edit_user_profile', 'ffl_show_user_profile' );

/**
 * Fix first last on profile saves.
 *
 */
function ffl_save_extra_profile_fields( $user_id ) {
	if ( ! current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}

	if ( isset( $_POST['first_name'] ) && isset( $_POST['last_name'] ) ) {
		$display_name = trim($_POST['first_name'] . " " . $_POST['last_name']);
	} else {
		$info = get_userdata( $user_id );
		$display_name = trim($info->first_name . ' ' . $info->last_name);
		if ( ! $display_name ) {
			$display_name = $info->user_login;
		}
	}
		
	$_POST['display_name'] = $display_name;
	
	$args = array(
		'ID' => $user_id,
		'display_name' => $display_name
	);   
	wp_update_user( $args ) ;
}
add_action( 'personal_options_update', 'ffl_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'ffl_save_extra_profile_fields' );
add_action( 'pmpro_personal_options_update', 'ffl_save_extra_profile_fields' );

/**
 * Removes the "Display Name" field on the Paid Memberships Pro frontned profile.
 *
 */
function ffl_pmpro_member_profile_edit_user_object_fields( $user_fields ) {
	unset( $user_fields['display_name'] );
	return $user_fields;
}
add_filter( 'pmpro_member_profile_edit_user_object_fields', 'ffl_pmpro_member_profile_edit_user_object_fields' );

/**
 * Fix first last on register.
 *
 */
function ffl_fix_user_display_name( $user_id ) {
	//set the display name
	$info = get_userdata( $user_id );
               
	$display_name = trim($info->first_name . ' ' . $info->last_name);
	if ( ! $display_name ) {
		$display_name = $info->user_login;
	}
			   
	$args = array(
		'ID' => $user_id,
		'display_name' => $display_name
	);
   
	wp_update_user( $args ) ;
}
add_action( 'user_register', 'ffl_fix_user_display_name', 20 );

/**
 * Add Settings Page
 *
 */
function ffl_settings_menu_item() {
	add_options_page('Force First Last', 'Force First Last', 'manage_options', 'ffl_settings', 'ffl_settings_page');
}
add_action( 'admin_menu', 'ffl_settings_menu_item', 20 );

/**
 * Settings Page Content
 *
 */
function ffl_settings_page() { ?>
	<style>
		/* Admin Header */
		.stranger_studios_banner {
			background-color: #2c3e50;
			display: grid;
			grid-column-gap: 20px;
			grid-template-areas: "logo meta";
			grid-template-columns: 360px auto;
			margin-bottom: 20px;
			padding: 0 20px;
		}
		.stranger_studios_banner .stranger_studios_logo img {
			height: auto;
			width: 100%;
		}
		.stranger_studios_banner .stranger_studios_meta {
			align-self: center;
			grid-area: meta;
			font-size: 18px;
			font-weight: 700;
			line-height: 1.5;
		}
		.stranger_studios_banner .stranger_studios_meta a {
			color: #FFF;
			opacity: 75%;
			padding: 5px 10px;
			text-decoration: none;
			text-transform: uppercase;
		}
		.stranger_studios_banner .stranger_studios_meta a:hover {
			opacity: 100%;
		}
		.ffl_admin {
			padding: 20px;
		}
	</style>
	<div class="wrap">
		<div class="stranger_studios_banner">
			<a class="stranger_studios_logo" title="Stranger Studios" target="_blank" href="https://www.strangerstudios.com/?utm_source=plugin&utm_medium=force-first-last&utm_campaign=homepage"><img src="<?php echo esc_url( plugins_url( 'images/Stranger-Studios.png', FFL_BASENAME ) ); ?>" border="0" alt="Stranger Studios(c) - All Rights Reserved"></a>
			<div class="stranger_studios_meta">
				<a href="https://www.strangerstudios.com/wordpress-plugins/?utm_source=plugin&utm_medium=force-first-last&utm_campaign=wordpress-plugins" target="_blank" title="Stranger Studios WordPress Plugins">Plugins</a>
				<a href="https://www.strangerstudios.com/wordpress-themes/?utm_source=plugin&utm_medium=force-first-last&utm_campaign=wordpress-themes" target="_blank" title="Stranger Studios WordPress Themes">Themes</a>
				<a href="https://www.strangerstudios.com/blog/?utm_source=plugin&utm_medium=force-first-last&utm_campaign=blog" target="_blank" title="Stranger Studios Blog">Blog</a>
			</div>
		</div>
		<div class="ffl_admin">
			<h1 class="wp-heading-inline">Force First and Last Name</h1>
			<?php if ( ! empty($_REQUEST['updateusers']) && current_user_can( 'manage_options' ) ) {
				global $wpdb;
				$user_ids = $wpdb->get_col("SELECT ID FROM $wpdb->users");

				foreach ( $user_ids as $user_id ) {
					ffl_fix_user_display_name($user_id);
					set_time_limit(30);
				} ?>
				<div class="notice inline updated"><p><?php echo count($user_ids);?> users updated.</p></div>
			<?php } ?>
			<p>The <em>Force First and Last Name as Display Name</em> plugin will only fix display names at registration or when a profile is updated. If you just activated this plugin, please click on the button below to update the display names of your existing users.</p>
			<p><a href="?page=ffl_settings&updateusers=1" class="button button-hero button-primary">Update Existing Users</a></p>
			<p><strong>WARNING:</strong> This process may take a long time for sites with many users or hosted on a slow server. <strong>Running this script may hang up or cause other issues with your site.</strong> Use at your own risk.</p>
		</div>
	</div> <!-- end ffl_admin -->
	<?php
}
