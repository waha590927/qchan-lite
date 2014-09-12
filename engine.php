<?php

/* Deny direct visit */
if (!defined('INDEX_RUN') && !defined('API_RUN') &&  !defined('MANAGE_RUN')) {
	header('HTTP/1.1 403 Forbidden');
	exit('This file must be loaded in flow.');
}

// Check if config.php is correct 
function check_config() {
	if (!(
		defined('UI_LANG') &&
		is_string(UI_LANG) &&
		preg_match('/[a-z]{2,3}(-[A-Z]{2})?|zh-Han[ts]/', UI_LANG)
	)) {
		exit('UI_LANG set incorrectly.');
	}
	if (!(
		defined('UI_THEME') &&
		is_string(UI_THEME) &&
		file_exists(ABSPATH . '/themes/' . UI_THEME)
	)) {
		exit('UI_THEME set incorrectly.');
	}
	if(!(
		defined('SITE_TITLE') &&
		is_string(SITE_TITLE)
	)) {
		exit('SITE_TITLE set incorrectly.');
	}
	if(!(
		defined('SITE_DESCRIPTION') &&
		is_string(SITE_DESCRIPTION)
	)) {
		exit('SITE_DESCRIPTION set incorrectly.');
	}
	if(!(
		defined('SITE_KEYWORDS') &&
		is_string(SITE_KEYWORDS)
	)) {
		exit('SITE_KEYWORDS set incorrectly.');
	}
	if(!(
		defined('ADMIN_EMAIL') &&
		is_string(ADMIN_EMAIL) &&
		preg_match('/(\w+\.)*\w+@(\w+\.)+[A-Za-z]+/', ADMIN_EMAIL)
	)) {
		exit('ADMIN_EMAIL set incorrectly.');
	}
	if(!(
		defined('MANAGE_NAME') &&
		is_string(MANAGE_NAME)
	)) {
		exit('MANAGE_NAME set incorrectly.');
	}
	if(!(
		defined('MANAGE_PASSWORD') &&
		is_string(MANAGE_PASSWORD)
	)) {
		exit('MANAGE_PASSWORD set incorrectly.');
	}
	if(!(
		defined('COPYRIGHT') &&
		is_string(COPYRIGHT)
	)) {
		exit('COPYRIGHT set incorrectly.');
	}
}

define('QCHAN_VER', 'lite-1.0pre build 20140912');
date_default_timezone_set('UTC');
define('ABSPATH', __DIR__);

if(!is_writable(ABSPATH . '/')) {
	exit(ABSPATH.' is not writable.');
}

/* Load Configurations or start installation */
if(file_exists( ABSPATH.'/config.php')) {
	require_once  ABSPATH.'/config.php';
}else {
	header("Location: install.php");
	exit();
}

$config_timestamp = 0;
$config_timestamp_now = filemtime(ABSPATH.'/config.php');
if(file_exists(ABSPATH.'/config.timestamp')) {
	$config_timestamp = file_get_contents(ABSPATH.'/config.timestamp');
}
if($config_timestamp != $config_timestamp_now) {
	check_config();
	file_put_contents(ABSPATH.'/config.timestamp', $config_timestamp_now);
}

define('SUPPORT_TYPE', 'jpg|jpeg|jpe|jfif|jfi|jif|gif|png|svg');
header("\x58\x2D\x51\x63\x68\x61\x6E\x2D\x49\x6E\x66\x6F\x3A\x20\x51\x63\x68\x61\x6E\x20\x69\x73\x20\x61\x6E\x20\x69\x6D\x61\x67\x65\x20\x68\x6F\x73\x74\x69\x6E\x67\x20\x66\x72\x65\x65\x77\x61\x72\x65\x2C\x20\x69\x73\x20\x64\x65\x76\x65\x6C\x6F\x70\x65\x64\x20\x62\x79\x20\x51\x75\x61\x64\x72\x61\x20\x53\x74\x75\x64\x69\x6F\x2C\x20\x61\x6E\x64\x20\x70\x75\x62\x6C\x69\x73\x68\x65\x64\x20\x75\x6E\x64\x65\x72\x20\x47\x50\x4C\x76\x33\x2E");

/* Load functions */
require_once ABSPATH.'/includes/functions.common.php';
require_once ABSPATH.'/includes/functions.language.php';
require_once ABSPATH.'/includes/functions.theme.php';
require_once ABSPATH.'/includes/functions.upload.php';

/* load classes */
require_once ABSPATH.'/includes/Service.class.php';
require_once ABSPATH.'/includes/HttpRequest.class.php';
Service::init();

$lang = load_lang();

