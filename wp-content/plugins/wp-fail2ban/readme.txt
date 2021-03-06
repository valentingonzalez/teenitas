=== WP fail2ban ===
Contributors: invisnet
Author URI: https://charles.lecklider.org/
Plugin URI: https://charles.lecklider.org/wordpress/wp-fail2ban/
Tags: fail2ban, login, security, syslog
Requires at least: 3.4.0
Tested up to: 4.8.0
Stable tag: 3.5.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Write a myriad of WordPress events to syslog for integration with fail2ban.

== Description ==

[fail2ban](http://www.fail2ban.org/) is one of the simplest and most effective security measures you can implement to prevent brute-force password-guessing attacks.

*WP fail2ban* logs all login attempts - including via XML-RPC, whether successful or not, to syslog using LOG_AUTH. For example:

    Oct 17 20:59:54 foobar wordpress(www.example.com)[1234]: Authentication failure for admin from 192.168.0.1
    Oct 17 21:00:00 foobar wordpress(www.example.com)[2345]: Accepted password for admin from 192.168.0.1

*WPf2b* comes with two `fail2ban` filters, `wordpress-hard.conf` and `wordpress-soft.conf`, designed to allow a split between immediate banning and the traditional more graceful approach.

Requires PHP 5.3 or later.

= Other Features =

**CloudFlare and Proxy Servers**

*WPf2b* can be configured to work with CloudFlare and other proxy servers. See `WP_FAIL2BAN_PROXIES` in the FAQ.

**Comments**

*WPf2b* can log comments. See `WP_FAIL2BAN_LOG_COMMENTS`.

**Pingbacks**

*WPf2b* logs failed pingbacks, and can log all pingbacks. See `WP_FAIL2BAN_LOG_PINGBACKS` in the FAQ.

**Spam**

*WPf2b* can log comments marked as spam. See `WP_FAIL2BAN_LOG_SPAM` in the FAQ.

**User Enumeration**

*WPf2b* can block user enumeration. See `WP_FAIL2BAN_BLOCK_USER_ENUMERATION` in the FAQ.

**Work-Arounds for Broken syslogd**

*WPf2b* can be configured to work around most syslogd weirdness. See `WP_FAIL2BAN_SYSLOG_SHORT_TAG` and `WP_FAIL2BAN_HTTP_HOST` in the FAQ.

**Blocking Users**

*WPf2b* can be configured to short-cut the login process when the username matches a regex. See `WP_FAIL2BAN_BLOCKED_USERS` in the FAQ.



== Installation ==

1. Upload the plugin to your plugins directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Copy `wordpress-hard.conf` and `wordpress-soft.conf` to your `fail2ban/filters.d` directory
1. Edit `jail.local` to include something like:
~~~
[wordpress-hard]
enabled = true
filter = wordpress-hard
logpath = /var/log/auth.log
maxretry = 1
port = http,https

[wordpress-soft]
enabled = true
filter = wordpress-soft
logpath = /var/log/auth.log
maxretry = 3
port = http,https
~~~
5. Reload or restart `fail2ban`

You may want to set `WP_FAIL2BAN_BLOCK_USER_ENUMERATION`, `WP_FAIL2BAN_PROXIES` and/or `WP_FAIL2BAN_BLOCKED_USERS`; see the FAQ for details.

== Frequently Asked Questions ==

= wordpress-hard.conf vs wordpress-soft.conf =

There are some things that are almost always malicious, e.g. blocked users and pingbacks with errors. `wordpress-hard.conf` is designed to catch these so that you can ban the IP immediately.

Other things are relatively benign, like a failed login. You can't let people try forever, but banning the IP immediately would be wrong too. `wordpress-soft.conf` is designed to catch these so that you can set a higher retry limit before banning the IP.

For the avoidance of doubt: you should be using *both* filters.

= WP_FAIL2BAN_HTTP_HOST – what’s it for? =

This is for some flavours of Linux where `WP_FAIL2BAN_SYSLOG_SHORT_TAG` isn't enough.

If you configure your web server to set an environment variable named `WP_FAIL2BAN_SYSLOG_SHORT_TAG` on a per-virtual host basis, *WPf2b* will use that in the syslog tag. This allows you to configure a unique tag per site in a way that makes sense for your configuration, rather than some arbitrary truncation or hashing within the plugin.

**NB:** This feature has not been tested as extensively as others. While I'm confident it works, FreeBSD doesn't have this problem so this feature will always be second-tier.

= WP_FAIL2BAN_SYSLOG_SHORT_TAG – what’s it for? =

Some flavours of Linux come with a `syslogd` that can't cope with the normal message format *WPf2b* uses; basically, they assume that the first part of the message (the tag) won't exceed some (small) number of characters, and mangle the message if it does. This breaks the regex in the *fail2ban* filter and so nothing gets blocked.

Adding:

	define('WP_FAIL2BAN_SYSLOG_SHORT_TAG',true);

to `functions.php` will make *WPf2b* use `wp` as the syslog tag, rather than the normal `wordpress`. This buys you 7 characters which may be enough to work around the problem, but if it's not enough you should look at `WP_FAIL2BAN_HTTP_HOST` or `WP_FAIL2BAN_TRUNCATE_HOST` too.

= WP_FAIL2BAN_TRUNCATE_HOST =

If you've set `WP_FAIL2BAN_SYSLOG_SHORT_TAG` and defining `WP_FAIL2BAN_HTTP_HOST` for each virtual host isn't appropriate, you can set `WP_FAIL2BAN_TRUNCATE_HOST` to whatever value you need to make syslog happy:

  define('WP_FAIL2BAN_TRUNCATE_HOST',8);

This does exactly what the name suggests: truncates the host name to the length you specify. As a result there's no guarantee that what's left will be enough to identify the site.

= WP_FAIL2BAN_BLOCKED_USERS – what’s it all about? =

The bots that try to brute-force WordPress logins aren't that clever (no doubt that will change), but they may only make one request per IP every few hours in an attempt to avoid things like `fail2ban`. With large botnets this can still create significant load.

Based on a suggestion from *jmadea*, *WPf2b* now allows you to specify a regex that will shortcut the login process if the requested username matches.

For example, putting the following in `wp-config.php`:

	define('WP_FAIL2BAN_BLOCKED_USERS','^admin$');

will block any attempt to log in as `admin` before most of the core WordPress code is run. Unless you go crazy with it, a regex is usually cheaper than a call to the database so this should help keep things running during an attack.

*WPf2b* doesn't do anything to the regex other than make it case-insensitive.

If you're running PHP 7, you can now specify an array of users instead:

  define('WP_FAIL2BAN_BLOCKED_USERS',['admin','another','user']);

= WP_FAIL2BAN_PROXIES – what’s it all about? =

The idea here is to list the IP addresses of the trusted proxies that will appear as the remote IP for the request. When defined:

* If the remote address appears in the `WP_FAIL2BAN_PROXIES` list, *WPf2b* will log the IP address from the `X-Forwarded-For` header
* If the remote address does not appear in the `WP_FAIL2BAN_PROXIES` list, *WPf2b* will return a 403 error
* If there's no X-Forwarded-For header, *WPf2b* will behave as if `WP_FAIL2BAN_PROXIES` isn't defined

To set `WP_FAIL2BAN_PROXIES`, add something like the following to `wp-config.php`:

	define('WP_FAIL2BAN_PROXIES','192.168.0.42,192.168.42.0/24');

*WPf2b* doesn't do anything clever with the list - beware of typos!

= WP_FAIL2BAN_BLOCK_USER_ENUMERATION – what’s it all about? =

Brute-forcing WP requires knowing a valid username. Unfortunately, WP makes this all but trivial.

Based on a suggestion from *geeklol* and a plugin by *ROIBOT*, *WPf2b* can now block user enumeration attempts. Just add the following to `wp-config.php`:

	define('WP_FAIL2BAN_BLOCK_USER_ENUMERATION',true);

= WP_FAIL2BAN_LOG_PINGBACKS – what’s it all about? =

Based on a suggestion from *maghe*, *WPf2b* can now log pingbacks. To enable this feature, add the following to `wp-config.php`:

	define('WP_FAIL2BAN_LOG_PINGBACKS',true);

By default, *WPf2b* uses LOG_USER for logging pingbacks. If you'd rather it used a different facility you can change it by adding something like the following to `wp-config.php`:

	define('WP_FAIL2BAN_PINGBACK_LOG',LOG_LOCAL3);

= WP_FAIL2BAN_LOG_COMMENTS =

*WPf2b* can now log comments. To enable this feature, add the following to `wp-config.php`:

  define('WP_FAIL2BAN_LOG_COMMENTS',true);

By default, *WPf2b* uses LOG_USER for logging comments. If you'd rather it used a different facility you can change it by adding something like the following to `wp-config.php`:

	define('WP_FAIL2BAN_COMMENT_LOG',LOG_LOCAL3);

= WP_FAIL2BAN_LOG_SPAM =

*WPf2b* can now log spam comments. To enable this feature, add the following to `wp-config.php`:

  define('WP_FAIL2BAN_LOG_SPAM',true);

The comment ID and IP will be written to `WP_FAIL2BAN_AUTH_LOG` and matched by `wordpress-hard`.

= WP_FAIL2BAN_AUTH_LOG – what’s it all about? =

By default, *WPf2b* uses LOG_AUTH for logging authentication success or failure. However, some systems use LOG_AUTHPRIV instead, but there's no good run-time way to tell. If your system uses LOG_AUTHPRIV you should add the following to `wp-config.php`:

	define('WP_FAIL2BAN_AUTH_LOG',LOG_AUTHPRIV);

== Changelog ==

= 3.5.3 =
* Bugfix for `wordpress-hard.conf`.

= 3.5.1 =
* Bugfix for `WP_FAIL2BAN_BLOCK_USER_ENUMERATION`.

= 3.5.0 =
* Add `WP_FAIL2BAN_OPENLOG_OPTIONS`.
* Add `WP_FAIL2BAN_LOG_COMMENTS` and `WP_FAIL2BAN_COMMENT_LOG`.
* Add `WP_FAIL2BAN_LOG_PASSWORD_REQUEST`.
* Add `WP_FAIL2BAN_LOG_SPAM`.
* Add `WP_FAIL2BAN_TRUNCATE_HOST`.
* `WP_FAIL2BAN_BLOCKED_USERS` now supports an array of users with PHP 7.

= 3.0.3 =
* Fix regex in `wordpress-hard.conf`

= 3.0.2 =
* Prevent double logging in WP 4.5.x for XML-RPC authentication failure

= 3.0.1 =
* Fix regex in `wordpress-hard.conf`

= 3.0.0 =
* Add `WP_FAIL2BAN_SYSLOG_SHORT_TAG`.
* Add `WP_FAIL2BAN_HTTP_HOST`.
* Log XML-RPC authentication failure.
* Add better support for MU deployment.

= 2.3.2 =
* Bugfix `WP_FAIL2BAN_BLOCKED_USERS`.

= 2.3.0 =
* Bugfix in *experimental* `WP_FAIL2BAN_PROXIES` code (thanks to KyleCartmell).

= 2.2.1 =
* Fix stupid mistake with `WP_FAIL2BAN_BLOCKED_USERS`.

= 2.2.0 =
* Custom authentication log is now called `WP_FAIL2BAN_AUTH_LOG`
* Add logging for pingbacks
* Custom pingback log is called `WP_FAIL2BAN_PINGBACK_LOG`

= 2.1.1 =
* Minor bugfix.

= 2.1.0 =
* Add support for blocking user enumeration; see `WP_FAIL2BAN_BLOCK_USER_ENUMERATION`
* Add support for CIDR notation in `WP_FAIL2BAN_PROXIES`.

= 2.0.1 =
* Bugfix in *experimental* `WP_FAIL2BAN_PROXIES` code.

= 2.0.0 =
* Add *experimental* support for X-Forwarded-For header; see `WP_FAIL2BAN_PROXIES`
* Add *experimental* support for regex-based login blocking; see `WP_FAIL2BAN_BLOCKED_USERS`

= 1.2.1 =
* Update FAQ.

= 1.2 =
* Fix harmless warning.

= 1.1 =
* Minor cosmetic updates.

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 3.5.3 =
You will need up update your `fail2ban` filters.

= 3.5.1 =
Bugfix: disable `WP_FAIL2BAN_BLOCK_USER_ENUMERATION` in admin area....

= 3.5.0 =
You will need up update your `fail2ban` filters.

= 3.0.3 =
You will need up update your `fail2ban` filters.

= 3.0.0 =
BREAKING CHANGE: The `fail2ban` filters have been split into two files. You will need up update your `fail2ban` configuration.

= 2.3.0 =
Fix for `WP_FAIL2BAN_PROXIES`; if you're not using it you can safely skip this release.

= 2.2.1 =
Bugfix.

= 2.2.0 =
BREAKING CHANGE:  `WP_FAIL2BAN_LOG` has been renamed to `WP_FAIL2BAN_AUTH_LOG`

Pingbacks are getting a lot of attention recently, so *WPf2b* can now log them.
The `wordpress.conf` filter has been updated; you will need to update your `fail2ban` configuration.

= 2.1.0 =
The `wordpress.conf` filter has been updated; you will need to update your `fail2ban` configuration.

= 2.0.1 =
Bugfix in experimental code; still an experimental release.

= 2.0.0 =
This is an experimental release. If your current version is working and you're not interested in the new features, skip this version - wait for 2.1.0. For those that do want to test this release, note that `wordpress.conf` has changed - you'll need to copy it to `fail2ban/filters.d` again.
