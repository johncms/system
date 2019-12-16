<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Johncms\System\Http;

use GuzzleHttp\Psr7\ServerRequest;
use Psr\Container\ContainerInterface;

class ServerRequestFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return ServerRequest::fromGlobals();
    }
}
