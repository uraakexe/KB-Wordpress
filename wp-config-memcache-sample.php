<?php
define('WP_CACHE_KEY_SALT', md5(DB_NAME . __FILE__));
//define('FORCE_SSL_ADMIN', true);
$memcached_servers = array(
'default' => array(
	'10.10.10.116:11211',
)
);

?>