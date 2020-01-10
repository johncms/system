<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Johncms\System\i18n;

use Gettext\Translator as Gettext;

class Translator extends Gettext
{
    private $locale = 'ru';

    public function addTranslationFilePattern(string $pattern)
    {
        $path = sprintf($pattern, $this->locale);

        if (is_file($path)) {
            $this->loadTranslations($path);
        }
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }
}
