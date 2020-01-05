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
defined('ROOT_PATH') || define('ROOT_PATH', dirname(__DIR__) . DS . 'filesystem' . DS);
defined('CONFIG_PATH') || define('CONFIG_PATH', ROOT_PATH . 'config' . DS);
defined('DATA_PATH') || define('DATA_PATH', ROOT_PATH . 'data' . DS);
defined('UPLOAD_PATH') || define('UPLOAD_PATH', ROOT_PATH . 'upload' . DS);
defined('CACHE_PATH') || define('CACHE_PATH', DATA_PATH . 'cache' . DS);
defined('LOG_PATH') || define('LOG_PATH', DATA_PATH . 'logs' . DS);
defined('THEMES_PATH') || define('THEMES_PATH', ROOT_PATH . 'themes' . DS);

define('SQL_DUMPS', dirname(__DIR__) . DS . 'sql' . DS);
