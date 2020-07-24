<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/DBTest2としてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use PHPUnit\Framework\TestCase;
use framework3\mvc\DB;

define('TEST', 1);

class DBTest2 extends TestCase
{
// APPNAMEディレクトリーのconfig.php LITE定義をはずしてテストする。
    /**
     * @test
     */
    // public function getDB失敗Test2()
    // {
        // // $dnsは定義されてはいるものの設定内容に誤りがある場合.
        // $this->expectExceptionCode(LOGIC);
        // $this->expectExceptionMessage('set dsn mistake!');
        // $obj = DB::getDB(DNS1);
    // }

}
