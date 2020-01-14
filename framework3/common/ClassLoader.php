<?php
/**
 * クラスのオートロードを実現するクラス
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/07/
 */ 
 
namespace framework3\common;


use function framework3\util\hs;
use framework3\mvc\BadRequestException;


class ClassLoader #chg final
{
    private $namespaces = array();
    
    public function __construct (array $namespaces)
    {
        $this->namespaces = $namespaces;        
    }
    
    
    /**
     * オートローダーするファイルをセットする
     * @param $namespace
     * @param $dir
     */
     public function registerNamespace($namespace, $dir)
    {
        $this->namespaces[$namespace] = $dir;
    }
    
    
    /**
     * 指定した関数を __autoload() の実装として登録する
     */
    public function register()
    {
        spl_autoload_register (array($this, 'loadClass'));
    }
    
    
    /**
     * autoloadを定義する。
     * @param $class
     * @return true
     */ 
    public function loadClass($class)  # examle: new framework\mvc\Db()
    {      
        $_class = ltrim($class, '\\'); # 一番左の「\」を取る。
        
        //名前空間に属するクラスの場合
        if (false !== ($pos = strrpos($_class, '\\'))) { # 一番最後にマッチした「\」文字のインデックスを取得する examle: $pos==13
            $namespace = substr($_class, 0, $pos);  # example: $namespace==framework\mvc\
            $_class = substr($_class, $pos + 1);     # example: $class==Db
            
            //登録されている名前空間に一致するものがあればファイルを読み込む
            foreach ($this->namespaces as $ns => $dir) { # namespaces set example: $dir = 
                if (0 === strpos($namespace, $ns)) {
                    $path = $dir . DS . str_replace('\\', DS, $namespace) . DS . $_class . '.php';
                      
                    if(is_file($path)) {
                        require_once $path;
                        return true;
                    }
                }               
            }
        }
        
        try {
        //  呼び出すclass fileが無い場合にthrowするexception定義
            $msg = hs($class) . ':load file not exist!';
            throw new BadRequestException ($msg, BADREQUEST);  
        } catch(BadRequestException $e) {
            ErrorFunc::catchAfter($e);  
        }              
    }
    
}
