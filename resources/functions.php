<?php

declare(strict_types=1);

require_once __DIR__ . '/../app.php';

use function OnePix\WordPress\di as container;

if (!function_exists('get_container')) {
    function get_container() {
        return container();
    }
}
