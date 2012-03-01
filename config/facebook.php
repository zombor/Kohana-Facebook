<?php defined('SYSPATH') or die('No direct access allowed.');

return array(

	'app_id'          => '368292339872170',
	'secret'          => 'e8a869ef12924d885ce9d91fe2c51c63',
    'cookie'          => true,
    'next'            => 'http://localhost:8888/kohana/HelloWorld/auth/login',
    'cancel_url'      => 'http://localhost:8888/kohana/HelloWorld/',
    'req_perms'       => 'email,publish_stream',
    // Full list of permission available here: https://developers.facebook.com/docs/reference/api/permissions/
);