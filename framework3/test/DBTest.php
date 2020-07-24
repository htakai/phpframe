<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/DBTestとしてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use PHPUnit\Framework\TestCase;
use framework3\mvc\DB;

define('TEST', 1);

class DBTest extends TestCase
{
    protected $obj;

    /**
     * @test
     */
    public function getDB正常Test()
    {
        // 正しく登録されているdns情報を示すdns名DNS1(APPNAMEディレクトリ内のconfig.phpに定義されている。)
        $obj = DB::getDB(DSN1);
        $this->assertTrue($obj instanceof \PDO);
    }


    /**
     * @test
     */
    public function getDB失敗Test()
    {
        // 定義されてない$dns指定.
        $this->expectExceptionCode(LOGIC);
        $this->expectExceptionMessage('DSN3-->Unknown database!');
        $obj = DB::getDB(DSN3);
    }
	
}
