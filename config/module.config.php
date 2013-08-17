<?php
return array(
	'ze_theme' => array(
		'default_theme' => null,
		'custom_theme_path' => false,
		'theme_paths' => array(
			__DIR__ . '/../themes/'
		),
		'split_theme' => false,
		'split_theme_folders' => array(
			'frontend',
			'backend'
		),
		'split_theme_default' => 'frontend',
		'adapters' => array(
			'ZeTheme\Adapter\Configuration',
		),
	),
);