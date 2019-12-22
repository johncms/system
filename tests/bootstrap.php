<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

defined('DEBUG') || define('DEBUG', true);

defined('_IN_JOHNCMS') || define('_IN_JOHNCMS', true);
defined('DS') || define('DS', DIRECTORY_SEPARATOR);
defined('ROOT_PATH') || define('ROOT_PATH', __DIR__ . DS);
defined('ASSETS_PATH') || define('ASSETS_PATH', __DIR__ . DS);
defined('CONFIG_PATH') || define('CONFIG_PATH', __DIR__ . '/_data/config/');
defined('DATA_PATH') || define('DATA_PATH', __DIR__ . DS);
defined('UPLOAD_PATH') || define('UPLOAD_PATH', __DIR__ . DS);
defined('UPLOAD_PUBLIC_PATH') || define('UPLOAD_PUBLIC_PATH', __DIR__ . DS);
defined('CACHE_PATH') || define('CACHE_PATH', __DIR__ . '/_data/cache/');
defined('LOG_PATH') || define('LOG_PATH', __DIR__ . DS);
defined('THEMES_PATH') || define('THEMES_PATH', __DIR__ . '/_data/themes/');

$handler = new \Tests\Unit\FakeSessionHandler();
session_set_save_handler(
    [$handler, 'open'],
    [$handler, 'close'],
    [$handler, 'read'],
    [$handler, 'write'],
    [$handler, 'destroy'],
    [$handler, 'gc']
);
session_start();
