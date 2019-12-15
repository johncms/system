<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Johncms\System\View;

use Mobicms\Render\Engine;

class Render extends Engine
{
    private $theme;

    public function setTheme(string $theme): void
    {
        $this->theme = $theme;
    }

    public function addFolder(string $name, string $directory, array $search = []): Engine
    {
        $searchFolder = $this->theme !== 'default'
            ? [realpath(ROOT_PATH . 'themes/' . $this->theme . '/templates/' . $name)]
            : [];

        return parent::addFolder($name, $directory, $searchFolder);
    }

    /**
     * @param string $name
     * @param array $data
     * @return string
     */
    public function render(string $name, array $data = []): string
    {
        try {
            return parent::render($name, $data);
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
