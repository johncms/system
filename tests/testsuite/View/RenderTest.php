<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Test\Suite\View;

use Johncms\System\View\Render;
use PHPUnit\Framework\TestCase;

class RenderTest extends TestCase
{
    /** @var Render */
    private $render;

    public function setUp(): void
    {
        $this->render = new Render();
    }

    public function testCanCreateInstance(): void
    {
        $this->assertInstanceOf(Render::class, $this->render);
    }

    public function testAddFolderWithDefaultTheme(): void
    {
        $this->render->setTheme('default');
        $this->render->addFolder('folder', THEMES_PATH);
        $this->assertEquals($this->render->getFolder('folder')[0], THEMES_PATH);
    }

    public function testAddFolderWithExampleTheme(): void
    {
        $this->render->setTheme('example');
        $this->render->addFolder('folder', THEMES_PATH);
        $this->assertEquals($this->render->getFolder('folder')[0], THEMES_PATH);
    }

    public function testRenderTemplate()
    {
        $this->render->addFolder('system', THEMES_PATH . 'default/templates/system');
        $this->assertStringContainsString('default-system-template', $this->render->render('system::template'));
    }

    public function testRenderInvalidTemplateName()
    {
        $this->render->addFolder('system', THEMES_PATH . 'default/templates/system');
        $this->assertEquals('The template "system::error" does not exist.', $this->render->render('system::error'));
    }
}
