<?php
/**
 * get変数格納クラス
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2018/07/
 */
 
namespace framework3\mvc;


class QueryString extends RequestVariables #chg final
{
    // 唯一のインスタンスを保持する
    protected static $_instance;  
    private static $flg = 0; # setValuea()が呼び出されたことを示すフラグ
    
    const GET_SEND = 1;
    
    
    /**
     * getリクエストを_value, _getsメンバーにセット
     * @param $gets get送信データ
     * @return int セットされている=2, セットされていない=0   
     */
    protected function setValues(array $gets) : int
    {
        //初めて呼び出されたときのみpostデータをセットする。
        if (count($gets) > 0 && self::$flg === 0){
            foreach ($gets as $key => $value) {
                $this->_values[$key] = $value;
                $this->_gets[$key] = $value;
            }
            self::$flg = self::GET_SEND;
        }           
        
        return self::$flg;
    }
}
