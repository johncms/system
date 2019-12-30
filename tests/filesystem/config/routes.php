<?php

declare(strict_types=1);

/*
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

use FastRoute\RouteCollector;
use Johncms\System\Users\User;

return function (RouteCollector $map, User $user) {
    $map->get('/', 'modules/homepage/index.php');
};
