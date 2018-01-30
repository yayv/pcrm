<?php

$CONFIG = array();
$CONFIG['theme'] = 'v/default';
$CONFIG['compiled_template'] = 'v/_run';

$CONFIG['database'] = array(
	'host' 		=> '127.0.0.1',
	'port' 		=> '3307',
	'username' 	=> 'root',
	'password' 	=> '1234',
	'database' 	=> 'pcrm',
	);

$CONFIG['title'] = '我的客户们';
$CONFIG['facepath'] = '/upload';

// 功能开关
$CONFIG['features'] = array(
	);

$CONFIG['plugins'] = array(
		// 插件怎么考虑呢？
	'personinfo'=>array("mlog","mpersoninfoex",'mlifestage','mrelationship','minsurance'),
	);
