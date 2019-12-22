<?php

/**
 * This file is part of JohnCMS Content Management System.
 *
 * @copyright JohnCMS Community
 * @license   https://opensource.org/licenses/GPL-3.0 GPL-3.0
 * @link      https://johncms.com JohnCMS Project
 */

declare(strict_types=1);

namespace Tests\Unit;

class FakeSessionHandler
{
    public $data;

    public function close()
    {
        return true;
    }

    public function destroy($session_id)
    {
        $this->data[$session_id] = null;
        return true;
    }

    public function gc($maxlifetime)
    {
        return true;
    }

    public function open($save_path, $session_id)
    {
        return true;
    }

    public function read($session_id)
    {
        return isset($this->data[$session_id]) ? $this->data[$session_id] : '';
    }

    public function write($session_id, $session_data)
    {
        $this->data[$session_id] = $session_data;
        return true;
    }
}
