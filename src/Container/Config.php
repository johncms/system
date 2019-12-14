<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Johncms\System\Container;

use Johncms\System\ConfigProvider;
use Zend\ConfigAggregator\ArrayProvider;
use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\PhpFileProvider;

class Config
{
    private $cacheFile = 'system-config.cache';

    public function __invoke(): array
    {
        $aggregator = new ConfigAggregator(
            [
                // Include cache configuration
                new ArrayProvider(['config_cache_path' => $this->cacheFile]),

                // Include packages configuration
                ConfigProvider::class,

                // Load application config in a pre-defined order
                new PhpFileProvider(CONFIG_PATH . 'autoload/{{,*.}global,{,*.}local}.php'),
            ],
            $this->cacheFile
        );

        return $aggregator->getMergedConfig();
    }
}
