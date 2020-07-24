<?php

/**
 * グローバルな設定.
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2020/03/
 */

namespace framework3;


class ApGlobal
{
    // constants define.
    private static function set_define()
    {
        //define global variable for check.
        if (!array_key_exists('not_defined', $GLOBALS)) {
            $GLOBALS['not_defined'] = "";
            if (defined('TEST')) {
                print('not_defined set!');
            }
        } else {
            $msg = 'check global variable [not_defined]!';
            if (defined('TEST')) {
                print($msg);
            }
            trigger_error($msg, E_USER_NOTICE);
            return false;
        }

        //run for debug
        if (!defined('DBG')) {
            define("DBG", 1);
        } else {
            $GLOBALS['not_defined'] .= "DBG, ";
        }


        //setting cache on or off
        if (!defined('NOCACHE')) {
            define("NOCACHE", 1);
        } else {
            $GLOBALS['not_defined'] .= 'NOCACHE, ';
        }

        if (defined('DBG')) {
            $create = 0;

            if (!array_key_exists('exceptions', $GLOBALS)) {
                $GLOBALS['exceptions'] = "";
                $create ++;
            }

            if (!array_key_exists('ret_url', $GLOBALS)) {
                $GLOBALS['ret_url'] = "";
                $create ++;
            }

            if (2 !== $create) {
                $GLOBALS['not_defined'] .= "exceptions or ret_url global variable alredy defined, ";
            }
        }

        if (!defined('U_MODE')) { # set unit test mode
            define('U_MODE',1); # test set=1,off=0
        } else {
            $GLOBALS['not_defined'] .= 'U_MODE, ';
        }

        if (!defined('DS')) {
            define('DS', DIRECTORY_SEPARATOR);
        }

        // URLの階層設定。document rootよりどの階層からをパラメータとして解釈するか。1以上をセット、 /hoge/以下に置くなら1, /hoge/piyo/以下に置くなら2
        if (!defined('PLEVEL')) {
            define('PLEVEL', 1);
        } else {
            $GLOBALS['not_defined'] .= 'PLEVEL, ';
        }

        if (!defined('SKM')) {
            define('SKM', 'http://');
        } else {
            $GLOBALS['not_defined'] .= 'SKM, ';
        }


        if (!defined('SYSROOT')) {
            define('SYSROOT', 'C:\xampp'); # case SYSROOT/DOCROOT
        } else {
            $GLOBALS['not_defined'] .= 'SYSROOT, ';
        }


        if (!defined('DOCROOT')) {
            define('DOCROOT', 'C:\xampp\htdocs');
        } else {
            $GLOBALS['not_defined'] .= 'DOCROOT, ';
        }


        //画像ファイル格納場所の定義
        if (!defined("IMG_DIR")) {
            define( "IMG_DIR", DOCROOT. "./img/" );  # upload dir
        } else {
            $GLOBALS['not_defined'] .= 'IMG_DIR, ';
        }

        if (!defined("IMG_DIR_S")) {
            define( "IMG_DIR_S", DOCROOT. "/img_s/" );  # 縮小画像s　dir
        } else {
            $GLOBALS['not_defined'] .= 'IMG_DIR_S, ';
        }

        if (!defined("IMG_DIR_M")) {
            define( "IMG_DIR_M", DOCROOT. "/img_m/" );   # 縮小画像m　dir
        } else {
            $GLOBALS['not_defined'] .= 'IMG_DIR_M, ';
        }
    }

    // グローバル設定実行.
    public static function do_init()
    {
        self::set_define();

        try {
            $msg = $GLOBALS['not_defined'];
            if (!empty($msg)) {
                $msg = $msg . 'alredy defined!';
                throw new \LogicException($msg);
            }
        } catch (\LogicException $e) {
            if (defined('TEST')) {
                print($e->getCode() . '#' . $e->getMessage());
                throw $e;
            }
            header('Content-Type: text/plain; charset=UTF-8');
            if (defined('DBG')) {
                exit(htmlspecialchars($e->getMessage(), ENT_QUOTES));
            } else {
                exit('system error!');
            }
        } finally {
            unset($GLOBALS['not_defined']);
            if (defined('TEST')) {
                print(' unset!');
            }
        }
        return true;
    }
}
