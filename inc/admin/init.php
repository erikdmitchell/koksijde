<?php
define('THEME_ADMIN_PATH',dirname(__FILE__));
define('THEME_ADMIN_URL',get_template_directory_uri().'/inc/admin');

get_template_part('inc/admin/functions');
get_template_part('inc/admin/theme-options','default');
?>