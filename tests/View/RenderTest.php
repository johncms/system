<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace JohncmsTests\System\View;

use Johncms\System\View\Render;
use LogicException;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

class RenderTest extends TestCase
{
    /** @var Render */
    private $render;

    public function setUp(): void
    {
        vfsStream::setup('templates');
        $this->render = new Render();
    }

    public function testCanCreateInstance(): void
    {
        $this->assertInstanceOf(Render::class, $this->render);
    }

    public function testAddFolderWithDefaultTheme(): void
    {
        $this->render->setTheme('default');
        vfsStream::create(['folder' => ['template.php' => '']]);
        $this->render->addFolder('folder', vfsStream::url('templates/folder'));
        $this->assertEquals($this->render->getFolder('folder')[0], 'vfs://templates/folder');
    }

    public function testAddFolderWithExampleTheme(): void
    {
        $this->render->setTheme('example');
        vfsStream::create(['folder' => ['template.php' => '']]);
        $this->render->addFolder('folder', vfsStream::url('templates/folder'));
        $this->assertEquals($this->render->getFolder('folder')[0], 'vfs://templates/folder');
    }

    public function testRenderTemplate()
    {
        $this->render->addFolder('tmp', vfsStream::url('templates'));
        vfsStream::create(['template.phtml' => 'Hello!']);
        $this->assertEquals($this->render->render('tmp::template'), 'Hello!');
    }

    public function testRenderInvalidTemplateName()
    {
        $this->render->addFolder('tmp', vfsStream::url('templates'));
        vfsStream::create(['template.phtml' => 'Hello!']);
        $this->assertEquals($this->render->render('tmp::error'), 'The template "tmp::error" does not exist.');
    }
}
