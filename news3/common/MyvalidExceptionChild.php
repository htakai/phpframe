<?php
/**
 * バリデーションに係わるカスタム例外クラスを定義する(child class).
 * 
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/07/
 */


namespace news3\common;


use framework3\mvc\MyvalidException;


class MyvalidExceptionChild extends MyvalidException
{
    /*
     * construct.
     *
     * @param string message
     * @param int code  --->throurable の分類用
     * @param Exception previous
     */
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        // messageからid_nameを取り出す.
        // for example 'message=303743@phone mistake! email mistake! url mistake!'
        // result e303743
        $this->setIdName($message);

        // message for display.
        $message = parent::trimDelimiter($message);

        // message for display in debug mode.
        //message is [MyvalidExceptionChild] phone mistake! email mistake! url mistake!
        if (defined("DBG")) {
            $message = '[' . __CLASS__ . ']' . $message;
        }

        // 全てを正しく確実に代入する
        parent::__construct($message, $code, $previous);
    }


    /*
     * set linked url address.
     * @param string url
     */
    public function customFunction(string $url = ""): void
    {
        if (!empty($url)) {
            $this->ret_url = $url;
        }
    }
}
