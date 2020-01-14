<?php
/**
 * post変数格納クラス
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2018/07/
 */
 
 
namespace framework3\mvc;


class Post extends RequestVariables #chg final
{
 
    protected static $_instance; # 唯一のインスタンスを保持する
    private static $flg = 0; # setValuea()が呼び出されたことを示すフラグ、いらない？
    
    const POST_SEND = 2;
    
    
    /**
     * postリクエストを_value,_postメンバーにセット
     * @param $posts post送信データ
     * @return int セットされている=2, セットされていない=0
     */
    protected function setValues(array $posts) : int
    {
        //初めて呼び出されたときのみpostデータをセットする。
        if ($posts !== null && self::$flg === 0) {
            foreach ($posts as $key => $value) {
                $this->_values[$key] = $value;
                $this->_posts[$key] = $value;
            }
            self::$flg = self::POST_SEND;
        }
        
        return self::$flg;      
    }
}