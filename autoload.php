<?php

spl_autoload_register(function ($class) {

	$prefix = 'PS\\Source\\';
	$base_dir = __DIR__ . '/src/';
	$len = strlen($prefix);

	if (strncmp($prefix, $class, $len) !== 0) {
		return;
	}

	$class_name = str_replace($prefix, '', $class);
	$file = $base_dir . str_replace('\\', '/', $class_name) . '.php';

	if (file_exists($file)) {
		require $file;
	}
});
