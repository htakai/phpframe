<?php
/**
 * カスタムバリデーションに係わるカスタム例外クラスを定義する(parent class)
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/07/
 */
 
namespace framework3\mvc;

 
abstract class MyvalidException extends \RuntimeException
{
    const V_DELIMITER = "@";  #  separeter due to created idname from message
    const ID_PREFIX = "e";
    
    protected $ret_url; # linked return url address
    protected $id_name; # use to rendering
    
    
    /**
     * 例外を再定義し、メッセージをオプションではなくする
     * @param string message
     * @param int code
     * @param Exception previous
     */
    public function __construct(string $message, int $code = 0, Exception $previous = null) 
    {
        // 全てを正しく確実に代入する
        parent::__construct($message, $code, $previous);
        
    }
    
    
    /**
     *　pickup exception message
     *
     * @param string msg  --->MyvalidException $e->getMessage()
     * @return string msg --->formatted message
     */
    protected static function trimDelimiter (string $msg) : string
    {
        return ltrim(strstr($msg, self::V_DELIMITER), self::V_DELIMITER);
    }
    
    
    /**
     *  pickup id_name into msg and set 
     *
     * @param string msg --->MyvalidException $e->getMessage()
     * msg is for example 303743@phone mistake! email mistake! url mistake! 
     * and id_name is e303743
     */
    protected function setIdName($msg) : void
    {
        $this->id_name = self::ID_PREFIX. strstr($msg, self::V_DELIMITER, true);
    }
    
    
    /**
     * get $ret_url
     *
     * @return string ret_url
     */
    public function getRetUrl() : string
    { 
        return $this->ret_url;
        
    }
    
    
    /**
     * get $id_name
     *
     * @return string id_name
     */
    public function getIdName() : string 
    {
        return $this->id_name;
    }
    
    
    /**
     * abstruct function extended by child class
     */
    abstract public function customFunction(); 
    
    
    public static function createMsg($num, $errors) 
    {
        return $num. self::V_DELIMITER. $errors;
    }
    
}
