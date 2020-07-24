<?php

/**
 * ログを書き込むクラス
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2020/05/
 */

namespace framework3\common;


class Log
{
    const FILEPATH = __DIR__ . '/../log';

    /*
     * ログを書き込む.
     *
     *@param string $msg
     */
    public static function logwrite(string $msg)
    {
        if (is_dir(self::FILEPATH)) {
            // create file name.
            $dateObj = new \DateTime();
            $date = $dateObj->format('Ymd');
            $fileName = realpath(self::FILEPATH) . '/' . $date . '.log';

            // create sentence
            $accessTime = $dateObj->format('Y-m-d H:i:s');
            $accessFile = $_SERVER['SCRIPT_FILENAME'];
            $sentence = '【' . $accessTime . $accessFile . '】' .$msg;

            // ファイルを追記モードで開きます。
            $fp = fopen($fileName, 'ab');
            if (is_resource($fp)) {
                // ファイルをロックします（排他的ロック）。
                flock($fp, LOCK_EX);
                // ログを書き込みます。
                fwrite($fp, F_util::hs($sentence) . "\n");
                // ファイルのロックを解除します。
                fflush($fp);
                flock($fp, LOCK_UN);
                // ファイルを閉じます。
                fclose($fp);
            } else {
                try {
                    $msg = 'can not write up this file!';
                    throw new \RuntimeException($msg, RUNTIME);
                } catch (\RuntimeException $e) {
                    F_util::catchfunc($e);
//                  ErrorFunc::catchAfter($e);
                }
            }
        }

    }
}
