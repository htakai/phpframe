<?php
/**
 * 独自エラー例外処理クラス(child class).
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/07/
 */

namespace news3\common;


use framework3\common\ErrorFunc;
use framework3\common\F_util;

//define('TEST', 1);

class AppErrorFunc extends ErrorFunc
{
    protected static $_instance;


    /*
     * 例外エラーキャッチ後のモード別（dbg,production）振り分け処理.
     * @param \Throwable $e
     */
    public static function catchAfter(\Throwable $e)
    {
        if (!defined('DBG')) {
            parent::catchAfter($e);
        }
        F_util::catchfunc($e);
    }


    /*
     * production mode 独自振り分け処理.
     * @param \Throwable
     */
    protected function funcByCode(\throwable $e)
    {
        if ($e->getCode() === MYVALID) {
            if (get_class($e) === MyvalidExceptionChild::class) {
                self::case_myvalidChild($e);
            }
        }
        try {
            $msg = 'not defined error code set!';
            throw new \DomainException($msg, DOMAIN);
        } catch (\DomainException $e) {
            parent::catchAfter($e);
        }
    }


    /*
     * MyvalidExceptionChild例外キャッチ後の処理、メッセージとリターンアドレスの表示.
     * @param MyvalidExceptionChild $e
     */
    private static function case_myvalidChild(MyvalidExceptionChild $e)
    {
        $ret_url = $e->getRetUrl();
        $id_name = $e->getIdName();
        $dts = [];
        $list = [$e->getMessage(),
                 $ret_url,
                ];
        for ($i = 0; $i < count($list); $i++ ) {
            $dts[] = $list[$i];
        }
        parent::display($id_name, $dts);
        exit();
    }
}
