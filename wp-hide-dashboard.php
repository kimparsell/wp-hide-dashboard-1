<?php
/*
Plugin Name: WP Hide Dashboard
Plugin URI: http://www.kpdesign.net/wp-plugins/wp-hide-dashboard/
Description: Simple plugin that removes the dashboard link and prevents dashboard access to users assigned to the <em>Subscriber</em> role. Useful if you allow your subscribers to edit their own profiles, but don't want them wandering around your WordPress admin section. Based on the <a title="IWG Hide Dashboard" href="http://www.im-web-gefunden.de/wordpress-plugins/iwg-hide-dashboard/">IWG Hide Dashboard</a> plugin by Thomas Schneider.
Author: Kim Parsell
Author URI: http://www.kpdesign.net/
Version: 1.0
License: MIT License - http://www.opensource.org/licenses/mit-license.php

Copyright (c) 2008 Kim Parsell

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

*/

if (basename($_SERVER['PHP_SELF']) == basename ( __FILE__ ) ) {
die("Sorry, but you can't access this page directly.");
}

/* Hide dashboard link and redirect unauthorized users to their profile page */
function wphd_hide_dashboard() {
	global $menu, $parent_file, $current_user;

	if ($current_user->wp_capabilities['subscriber'] == 1) {
		unset($menu[0]);
		if ($parent_file == 'index.php') {
			if ( !headers_sent() ) {
				wp_redirect('profile.php');
				exit();
			} else {
				$wphd_hide_dashboard_url = get_option('siteurl') . "/wp-admin/profile.php";
?>
<meta http-equiv="refresh" content="0; url=<?php echo $wphd_hide_dashboard_url; ?>">
<script type="text/javascript">document.location.href = "<?php echo $wphd_hide_dashboard_url; ?>"</script>
</head>
<body>
</body>
</html>
<?php
				exit();
			}
		}
	}
}

add_action('admin_head', 'wphd_hide_dashboard', 0);

?>