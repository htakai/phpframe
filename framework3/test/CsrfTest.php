<?php

/**
 * phpunit test.
 *
 * Windows10環境で、コマンドプロンプトで
 * C:\xampp\vendor\bin>phpunit ../../framework3/test/CsrfTestとしてテスト.
 */

require_once __DIR__ . '/../../news3/config.php';
require_once __DIR__ .'/../../framework3/runfirst.php';

use PHPUnit\Framework\TestCase;
use framework3\mvc\Session;
use framework3\common\Csrf;

define('TEST', 1);

class CsrfTest extends TestCase
{
    protected $mock_session_obj;

    public function setUp()
    {
        $this->mock_session_obj = Phake::mock(Session::class);
    }

    /**
     * @test
     */
    public function create_tokenTest()
    {
        $form_name = 'form1';
        Phake::whenStatic($this->mock_session_obj)->set()->thenReturn(true);

        $created_token = Csrf::create_token($form_name, $this->mock_session_obj);

        $this->assertEquals(40, strlen($created_token));

        $created_token2 = Csrf::create_token($form_name, $this->mock_session_obj);

        $this->assertEquals($created_token, $created_token2);
    }
}
