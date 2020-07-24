<?php

/**
 * Session class.
 *
 * @author Katsuhiro Ogawa <fivestar@nequal.jp>
 */

namespace framework3\mvc;


class Session
{
    private static $_instance;

    private static $sessionStarted = false;
    private static $sessionIdRegenerated = false;

    /*
     * コンストラクタ
     * セッションを自動的に開始する
     */
    private function __construct()
    {
        if (!self::$sessionStarted) {
            session_start();
print('session start!');
            self::$sessionStarted = true;
        }
    }


    /*
	 * クーロン禁止.
	 */
    private function __clone()
	{ 
	    try {
            $msg = 'this instance is singleton class!';
            throw new \LogicException($msg, LOGIC); // may not create class clone exception.
        } catch (\LogicException $e) {
//          ErrorFunc::catchAfter($e);
            F_util::catchfunc($e);
        }
	
	}


    /*
     * 常に同じインスタンスを返す。
     * 外部からインスタンスを取得する唯一の方法を提供する
	 * @return self::$_instance.
     */
    public static function getInstance(): self
	{  #final
        if (is_null(self::$_instance)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }


    /*
     * セッションに値を設定
	 * add ip address into session name.
     *
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value)
    {
        $_SESSION[$_SERVER['REMOTE_ADDR'] . $name] = $value;
    }


    /*
     * セッションから値を取得
     *
     * @param string $name
     */
    public function get($name)
    {
        if (isset($_SESSION[$_SERVER['REMOTE_ADDR'] . $name])) {
            return $_SESSION[$_SERVER['REMOTE_ADDR'] . $name];
			
        }
        return false;
    }


    /*
     * セッションから値を削除
     *
     * @param string $name
     */
    public function remove($name)
    {
        unset($_SESSION[$_SERVER['REMOTE_ADDR'] . $name]);
    }


    /*
     * セッションを空にする
     */
    public function clear()
    {
        $_SESSION = array();
    }


    /*
     * セッションIDを再生成する
     *
     * @param boolean $destroy trueの場合は古いセッションを破棄する
     */
    public function regenerate($destroy = true)
    {
        if (!self::$sessionIdRegenerated) {
            session_regenerate_id($destroy);
            self::$sessionIdRegenerated = true;
        }
    }


    /*
     * 認証状態を設定
     *
     * @param bool $bool
     */
    public function setAuthenticated(bool $bool)
    {
        $this->set('_authenticated', $bool);
        $this->regenerate();
    }


    /*
     * 認証済みか判定
     *
     * @return bool
     */
    public function isAuthenticated(): ?bool
    {
        return $this->get('_authenticated');
    }
}
