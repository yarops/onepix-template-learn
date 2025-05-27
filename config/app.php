<?php

declare(strict_types=1);

use function OnePix\WordPress\env;

$id = 'br-one';
$appPath = dirname(__DIR__);

return [
    'id' => $id,
    'version' => '0.1.0',
    'appPath' => $appPath,
    'translationsPath' => $appPath . '/languages',
    'templatesPath' => $appPath . '/resources/templates/',
    'isDev' => env('WP_ENV', 'development') === 'development'
];