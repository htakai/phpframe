<?php
/**
 * ワンタイムトークンを使ったcsrf対策クラス
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2020/07/
 */

namespace framework3\common;

use framework3\mvc\Session;

class Csrf
{
    private static $token = null;
    private static $session = null;

    /*
     * 初期化
     * @param Session $session
     */
    private static function init(Session $session)
    {
        self::$token = sha1(uniqid());
        self::$session = $session;
    }


    /*
     * CSRF用にトークンを生成する
     *
     * @param string $form_name
     * @param Session $session
     * @return string self::$token
     */
    public static function create_token(string $form_name, Session $session): string
    {
        if (is_null(self::$token)) {
            self::init($session);
        }

        self::$session->set($form_name, self::$token);

        return self::$token;
    }


    /*
     * CSRFをチェックする.
     *
     * @param string $form_name
     * @param Session $session
     * @param string $token F_util::hs()でエスケープされた$token.
     * @return boolean
     */
    public static function check(string $form_name, Session $session, string $token): bool
    {
        $csrf_token = $session->get($form_name);
        $session->remove($form_name);
        if ($token === F_util::hs($csrf_token)) {
            return true;
        }
        return false;
    }
}
