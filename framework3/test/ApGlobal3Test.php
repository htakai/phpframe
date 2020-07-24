<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/ApGlobal3Test.phpとしてテスト.
 */

require_once __DIR__ .'/../../framework3/ApGlobal.php';

use framework3\ApGlobal;
use PHPUnit\Framework\TestCase;

define('TEST', 1);
define("DBG", 10);
define("NOCACHE", 10);
define('U_MODE',10);
define('PLEVEL', 10);
define('SKM', 'http://');
define('SYSROOT', 'C:\xampp');
define('DOCROOT', 'C:\xampp\htdocs');


class  ApGlobal3Test extends TestCase
{
    /**
     * @test
     * @expectedException \LogicException
     */
    public function ApGlobal異常2()
    {
        $this->expectExceptionMessage('DBG, NOCACHE, U_MODE, PLEVEL, SKM, SYSROOT, DOCROOT, alredy defined!');
        ApGlobal::do_init();
    }
}
