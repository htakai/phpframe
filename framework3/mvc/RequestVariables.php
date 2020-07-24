<?php
/**
 * リクエスト変数格納親クラス.
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2018/07/
 */


namespace framework3\mvc;


// リクエスト変数抽象クラス.
abstract class RequestVariables
{
    protected $_values;
    protected $_posts;
    protected $_gets;

    //リクエスト種別定義.
    const REQCLS = 1;  # post,getデータ合わせて
    const POSTCLS = 2;  # postデータ
    const GETCLS = 3;  # getデータ


    /*
     * construct
     *
     *@parma array $reqs request datas
     */
    protected function __construct(array $reqs)
    {
        $this->setValues($reqs);
    }


    /*
     * 常に同じインスタンスを返す。
     * 外部からインスタンスを取得する唯一の方法を提供する
     * @return static::$_instance
     */
    final public static function getInstance($reqs)
    {
        if (is_null(static::$_instance)) {
            static::$_instance = new static($reqs);
        }
        return static::$_instance;
    }


    /*
     * クーロンは禁止する.
     */
    protected function __clone() { }


    /*
     * パラメータ値設定.
     * @param array $reqs 送信データ
     */
    abstract protected function setValues(array $reqs);


    /*
     * 指定キーのパラメータを取得.
     * @param cl cl==REQCLS リクエストデータすべてを対象, cl==POSTCLS postデータ対象, cl==GETCLS getデータ対象
     * @param string key　取得データのkey
     * @return array _values, _value, false
     */
    public function get($cl, $key = null)
    {
        $ret = false;

        switch ($cl) {
            case self:: REQCLS :
                if (isset($this->_values)) {
                    $dt = $this->_values;
                }
                break;

            case self:: POSTCLS :
                if (isset($this->_posts)) {
                    $dt = $this->_posts;
                }
                break;

            case self:: GETCLS :
                if (isset($this->_gets)) {
                    $dt = $this->_gets;
                }
                break;

            default :
        }

        if (isset($cl)) {
            //key指定が無い場合はgetまたはpostデータすべてを返す
            if (null === $key && isset($dt)) {
                $ret = $dt;
            } elseif ((isset($key)) && (true === $this->has($key, $cl))) {
                    $ret = $dt[$key];
            }
        }

        return $ret;
    }


    /*
     * 指定のキーが存在するか確認
     * @paran key
     * @param cl リクエスト種別
     * @return true, false
     */
    public function has($key, $cl): bool
    {
        switch ($cl) {
            case self:: REQCLS :
                $dt = $this->_values;
                break;

            case self:: POSTCLS :
                $dt = $this->_posts;
                break;

            case self:: GETCLS :
                $dt = $this->_gets;
                break;
            case self:: SESSIONCLS :
                $dt = $this->_session;
                break;

            default :
        }

        if (isset($key) && isset($dt)) {
            if (false == array_key_exists($key, $dt)) {
                return false;  # key not found
            }
            return true;
        }

        return false;  #value not set
    }
}
