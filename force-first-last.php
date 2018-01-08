<?php
/*
Plugin Name: Force First and Last Name as Display Name
Plugin URI: http://www.strangerstudios.com/wordpress-plugins/force-first-last/
Description: Forces all users' display name to be "First Last".
Version: 1.0
Author: Stranger Studios
Author URI: http://www.strangerstudios.com
*/
/*
	Copyright 2011	Stranger Studios	(email : jason@strangerstudios.com)
	GPLv2 Full license details in license.txt
*/

/*
	Hide Display Name field on profile page.
*/
function ffl_show_user_profile($user)
{
?>
<script>
	jQuery(document).ready(function() {
		jQuery('#display_name').parent().parent().hide();
	});
</script>
<?php
}
add_action( 'show_user_profile', 'ffl_show_user_profile' );
add_action( 'edit_user_profile', 'ffl_show_user_profile' );

/*
	Fix first last on profile saves.
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

/*
	Fix first last on register.
*/
function ffl_fix_user_display_name($user_id)
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
add_action("user_register", "ffl_fix_user_display_name", 20);

/*
	Settings Page
*/
function ffl_settings_menu_item()
{
	add_options_page('Force First Last', 'Force First Last', 'manage_options', 'ffl_settings', 'ffl_settings_page');
}
add_action('admin_menu', 'ffl_settings_menu_item', 20);

//affiliates page (add new)
function ffl_settings_page()
{
	if(!empty($_REQUEST['updateusers']) && current_user_can("manage_options"))
	{
		global $wpdb;
		$user_ids = $wpdb->get_col("SELECT ID FROM $wpdb->users");
		
		foreach($user_ids as $user_id)
		{
			ffl_fix_user_display_name($user_id);		 
			set_time_limit(30);			
		}
		
		?>
		<p><?php echo count($user_ids);?> users(s) fixed.</p>
		<?php
	}
	
	?>
	<p>The <em>Force First and Last Name as Display Name</em> plugin will only fix display names at registration or when a profile is updated.</p>
	<p>If you just activated this plugin, please click on the button below to update the display names of your existing users.</p>
	<p><a href="?page=ffl_settings&updateusers=1" class="button-primary">Update Existing Users</a></p>
	<p><strong>WARNING:</strong> This may take a while! If you have a bunch of users or a slow server, <strong>this may hang up or cause other issues with your site</strong>. Use at your own risk.</p>	
	<?php
}
