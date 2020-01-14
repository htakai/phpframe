<?php
/**
 * 不正リクエスト送信。file not found に係わるカスタム例外クラスを定義する
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2018/07/
 */
 
namespace framework3\mvc;
 
 
class BadRequestException extends \RuntimeException
{
    // 例外を再定義し、メッセージをオプションではなくする
    public function __construct($message, $code = 0, Exception $previous = null) {
        
    
        // 全てを正しく確実に代入する
        parent::__construct($message, $code, $previous);
    }
}
