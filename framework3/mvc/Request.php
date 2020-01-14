<?php
/**
 * request処理、バリデーション親クラス
 * <script src="https://gist.github.com/htakai/ec73b118172bfecd80c17bfc9bf66a0b.js"></script>
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2018/07/
 */

 
namespace framework3\mvc;


class Request
{
    // Postクラスのインスタンス
    private $post;
    
    // Queryクラスのインスタンス
    private $query;
    
    // コンストラクタ
    public function __construct(array $reqs = NULL)
    {
        if (count($_POST) > 0) {
            $vals = $_POST;
            $this->post = Post::getInstance($vals);
        }
        
        if (count($_GET) > 0) {
            $vals = $_GET;
            $this->query = QueryString::getInstance($vals);
        }
        
        //for test of post case or get case
        if ($reqs !== null) {   
            if (isset($reqs['get']) && $reqs['get'] === 1) {
                $this->query = QueryString::getInstance($reqs);
            }
            if (isset($reqs['post']) && $reqs['post'] === 1) {
                $this->post = Post::getInstance($reqs);
            }
        }           
    }
    
    
    /**
     * POST変数取得
     * @param $key
     * @return array $this->post->get(), $this->post->get($key)
     * @return データが無い場合はfalse
     */ 
    public function getPost($key = null)
    {
        try {
            //keyを指定しない場合は格納されているpostデータすべてをかえす
            if (null === $key) {        
                return $this->post->get(Post::POSTCLS );
            }      
            //指定keyガ無い
            else if ( !isset($key) || false === $this->post->has($key, Post::POSTCLS)) {        
                $msg = $key. '-->request post key not exist!';
                throw new BadRequestException($msg, BADREQUEST);
            }
        } catch(BadRequestException $e) {
            ErrorFunc::catchAfter($e);  
        }   
        
        return $this->post->get(Post::POSTCLS, $key);
    }
  
  
    /**
     * GET変数取得
     * @param key
     * @return array $this->post->get(), $this->post->get($key)
     * @return データが無い場合はfalse
     */ 
    public function getQuery($key = null) 
    {  
        try { //keyを指定しない場合は格納されているgetデータすべてをかえす
            if (null === $key) {    
                return $this->query->get( QueryString::GETCLS);
            }    
            //指定keyが無い
            else if (!isset($key) || false === $this->query->has($key, QueryString::GETCLS)) {
                $msg = $key. '-->request query key not exist!';
                throw new BadRequestException($msg, BADREQUEST);
            }
        } catch(BadRequestException $e) {
            ErrorFunc::catchAfter($e);  
        }       
    
        return $this->query->get(QueryString::GETCLS, $key);
    }
    
    
    /**
     * リクエストクエリーが予約されているパラメータであるか
     * この関数利用にはリクエストされるであろうkeyをすべてピックアップし$keysに定義する必要あり
     * @param array keys 存在すべきkey
     * @return true, false
     */
    public function chkDefindedKey(array $keys) : bool
    {
        $reqKeys = array();
        $definedKeys = &$keys;       
        //リクエストされたkeyを$req_keysにすべて入れる。
        if (isset($this->query)) {
            $queryDt = $this->getQuery();
            if ( (false !== $queryDt) && is_array($queryDt) ) {         
                foreach ($queryDt as $key => $value) {
                    $reqKeys[] = $key;
                }                       
            }
        }
        if (isset($this->post)) {
            $postDt = $this->getPost();
            if ((false !== $postDt) && is_array($postDt) ) {            
                foreach ($postDt as $key => $value) {
                    $reqKeys[] = $key;
                }                       
            }  
        }
        
        if (count($reqKeys) === count($definedKeys)) {
            //送信されたリクエストが存在すべきkeyであるかチェックする
            foreach ($definedKeys as $value) {      
                $find = array_search($value, $reqKeys);                 
                if ($find === false) {
                    return false;
                }           
            }
            return true;            
        }
        return false;
    }
 
 
    /**
     * URLとしての属性値(href,src)のみを出力
     * @param $str url
     */ 
    public static function url_attr($str) 
    {
        try {
            //「http:」「https:」「/」で始まる文字列のみを出力します。
            if (preg_match('/\Ahttp(s?):/', $str) || preg_match('#\A/#', $str)) {
                return $str;
            } else {
            //「http:」「https:」「/」で始まらない文字列はログに記録します。
                $msg = $str. '-->request must start http or https!';
                throw new BadRequestException($msg, BADREQUEST);
            }
        } catch(BadRequestException $e) {
            ErrorFunc::catchAfter($e);  
        }            
    }
    
 
    /**
     * 半角数字のみを出力(css style要素内でのエスケープ)
     * @param $str
     */
    public static function num($str)
    {
        try {
            if (preg_match('/\A[0-9]+\z/u', $str)) {
                return $str;
            } else {
                $msg = $str. '-->request must small num only!';
                throw new BadRequestException($msg, BADREQUEST);
            }
        } catch(BadRequestException $e) {
            ErrorFunc::catchAfter($e);  
        }           
    }
    
    
    /**
     * 半角英数のみを出力 (css style要素内でのエスケープ)
     * @param $str
     */
    public static function alnum($str)
    {
        try {
            if (preg_match('/\A[0-9a-z]+\z/ui', $str)) {
                return $str;
            } else {
                $msg = $str. '-->request must small alnum only!';
                throw new BadRequestException($msg, BADREQUEST);
            }
        } catch(BadRequestException $e) {
            ErrorFunc::catchAfter($e);  
        }       
    }
 
 
    /**
     * 英数字とマイナス、ピリオド以外をUnicodeエスケープして出力
     *イベント要素内、script要素内でのエスケープ
     * @param $str
     * @return $str
     */
    public static function js($str)
    {
        $str = preg_replace_callback(
        '/[^-\.0-9a-zA-Z]+/u', 
        'static::unicode_escape', 
        $str
        );
        return $str;
    }
  
  
    /**
     * 文字列をすべて \uXXXX 形式に変換
     * @param $matches
     * @return str
     */
    private static function unicode_escape($matches)
    {
        $u16 = mb_convert_encoding($matches[0], 'UTF-16');
        return preg_replace('/[0-9a-f]{4}/', '\u$0', bin2hex($u16));
    }
}
