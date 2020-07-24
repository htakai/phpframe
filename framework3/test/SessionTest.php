<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/SessionTestとしてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use PHPUnit\Framework\TestCase;
use framework3\mvc\Session;

define('TEST', 1);

class SessionTest extends TestCase
{
    protected $obj;

    /**
     * @test
     */
    public function getInstanceTest()
    {
        $this->expectOutputString('session start!');
        $this->obj = Session::getInstance();
    }
}
