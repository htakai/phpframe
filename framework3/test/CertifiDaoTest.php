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
use framework3\common\Csrf;
use news3\models\CertifiDao;

define('TEST', 1);

class CertifiDaoTest extends TestCase
{
    protected $mock_session_obj;
    protected $dao_obj;
    protected $ret_url;

    public function setUp()
    {
        $this->mock_session_obj = Phake::mock(Session::class);
        $this->ret_url = 'http://localhost/news3/';
        $this->dao_obj = new CertifiDao($this->mock_session_obj, $this->ret_url);
    }


    /**
     * @test
     */
    public function admin_execute成功Test()
    {
        $name = 'account';
        $password = 'password';
        $bool = $this->dao_obj->admin_execute($name, $password);
        $this->assertEquals(true, $bool);
    }

    /**
     * @test
     */
    public function admin_execute失敗Test2()
    {
        $name = 'miss_account';
        $password = 'miss_password';
        $this->expectExceptionCode(MYVALID);
        $this->expectOutputString('5000#[news3\common\MyvalidExceptionChild]user not find!');
        $this->expectExceptionMessage('user not find!');

        $ret = $this->dao_obj->admin_execute($name, $password);

    }

    /**
     * @test
     */
    public function admin_execute失敗Test3()
    {
        $name = 'account';
        $password = 'miss_password';
        $this->expectExceptionCode(MYVALID);
        $this->expectOutputString('5000#[news3\common\MyvalidExceptionChild]password mismatch!');
        $this->expectExceptionMessage('password mismatch!');

        $this->dao_obj->admin_execute($name, $password);
    }

    /**
     * @test
     */
    public function addUser正常Test4()
    {
        $newname = 'account2';
        $newpass = 'password2';

        $bool = $this->dao_obj->addUser($newname, $newpass);
        $this->assertEquals(true, $bool);
    }


    /**
     * @test
     */
    public function chgPass正常Test6()
    {
        $name = 'account2';
        $chgpass = 'chgpass';
        $bool = $this->dao_obj->chgPass($name, $chgpass);
        $this->assertEquals(true, $bool);

    }

    /**
     * @test
     */
    public function deleteUser正常Test7()
    {
        $del_name = 'account2';

        $bool = $this->dao_obj->deleteUser($del_name);
        $this->assertEquals(true, $bool);
    }
}
