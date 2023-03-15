=== Force First and Last Name as Display Name ===
Contributors: strangerstudios, kimannwall
Tags: display name, user, force, first name, last name
Requires at least: 5.2
Tested up to: 6.2
Stable tag: 1.2.1

Force the user field "display_name" to be set as the user's first and last name.

== Description ==

This plugin hides the "Display Name" field on the Edit Profile screen for all users. Instead of allowing users to set this field, the plugin will always set the User field display_name to their first and last name. If these field are empty, display_name will be set to their username.

Display names are set when the user registers as well as when a user's profile is updated via the WordPress admin.

The plugin includes a batch process to update the display name for existing users. Navigate to Settings > Force First Last in the WordPress admin to run the update.

= Paid Memberships Pro Compatibility =

This plugin is now compatible with Paid Memberships Pro. The "Display Name" field is hidden from the frontend Member Profile Edit page. Display Name is automatically set when this form is saved. Display Name will also be updated at membership checkout if you are capturing the member's first and last name via a [Register Helper field](https://www.paidmembershipspro.com/add-ons/pmpro-register-helper-add-checkout-and-profile-fields/) or when using the [Add Name to Checkout Add On](https://www.paidmembershipspro.com/add-ons/add-first-last-name-to-checkout/).

== Installation ==

= Download, Install and Activate! =

1. Upload `force-first-last` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Visit Settings > Force First Last to run an initial update for all of your users.

== Frequently Asked Questions ==

= How do I update existing display names on my site? =
Navigate to Settings > Force First Last to run a script that will update all existing users.

= In my location, names are formatted as LAST FIRST. How do I switch the order? =
You will need to use a custom filter to adjust the display order. See this code for an example: https://gist.github.com/kimcoleman/dc3227b9cebec79fa983261827df7485.

== Screenshots ==

1. Display Name field is removed from the User Profile in WordPress admin.
2. Navigate to Settings > Force First Last in the WordPress admin to run a batch update on all users.
3. Paid Memberships Pro's frontend Member Profile Edit page with Display Name field removed.

== Changelog == 

= 1.2.1 - 2023-03-14
* SECURITY: Added nonce to bulk "Update Existing Users" admin page to protect from CSRF vulnerability. (Thanks, @mikhail-net)

= 1.2 - 2021-03-12
* ENHANCEMENT: Added `ffl_display_name_order` filter to allow custom code to change display name to last first.
* ENHANCEMENT: Tested up to WordPress 5.7.

= 1.1 - 2020-08-13 =
* ENHANCEMENT: Adding support for the Paid Memberships Pro frontend member profile edit screen.
* ENHANCEMENT: Improving the settings page appearance.
* ENHANCEMENT: Tested up to WordPress 5.5.
* ENHANCEMENT: Added pmpro_ffl_hide_display_name_profile filter. Set to return false if you'd like the display name field to show up on the edit user page in the WP dashboard.

= 1.0 =
* Change priority of the user_register hook to 20 so it will run after plugins setting first/last name etc.
* Let's call this official at 1.0

= .2 =
* Added settings page to update existing users.
* Hiding display name dropdown on profile page.

= .1 =
* Initial version.
