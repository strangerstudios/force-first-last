=== Force First and Last Name as Display Name ===
Contributors: strangerstudios
Tags: display name, force, firstname, first name, lastname, last name, display_name
Requires at least: 3.0
Tested up to: 5.2.2
Stable tag: 1.0

Force the "display_name" of all users to be the user's first and last name. If those fields are empty, display name falls back to their username.

== Description ==

The display name dropdown is hidden from users. Instead, it is always set to their first and last name, or username if those fields are empty.

Display names are updated at registration or when a user profile is updated. To update existing users, visit Settings --> Force First Last and click on the link to run an initial update on your users.

== Installation ==

= Download, Install and Activate! =
1. Upload `force-first-last` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Visit Settings --> Force First Last to run an initial update of all of your users.

== Frequently Asked Questions ==

None yet.

== Changelog == 

= 1.0 =
* Change priority of the user_register hook to 20 so it will run after plugins setting first/last name etc.
* Let's call this official at 1.0

= .2 =
* Added settings page to update existing users.
* Hiding display name dropdown on profile page.

= .1 =
* Initial version.
