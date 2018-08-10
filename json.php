<?php

include 'vendor/autoload.php';

if (!is_dir(__DIR__.'/cache/')) {
	mkdir(__DIR__.'/cache/', 0755, true);
}

$cache = new Instagram\Storage\CacheManager(__DIR__.'/cache/');
$api   = new Instagram\Api($cache);
$api->setUserName('permanenttourist');

$feed = $api->getFeed();

header('Content-Type: application/json; charset=UTF-8');
if ($feed && $feed instanceof Instagram\Hydrator\Component\Feed && property_exists($feed, 'id')) {
	print_r(json_encode($feed));
} else {
	print_r(json_encode([
		'message' => 'IG feed collection failed',
		'status' => 500
	]));
}
exit;
