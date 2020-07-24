<?php

/**
 * create instance of class.
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2020/05/
 */
 
namespace framework3\common;

class FactoryClass
{
	/*
	 * 指定クラスのインスタンスを生成する。
	 * 以下、同様のスタティックメソッドがある。
	 * これは、単体テストにおける、モック用に使われる。
	 *
	 * @param string classname 完全修飾形式クラス名
	 * @param array 生成クラスのコンストラクタの引数を格納した配列
	 * @return 指定クラスのインスタンス
	 */
    public static function createClass0($classname = null, $params = null)
    {
        return self::logic($classname, $params);
    }


    public static function createClass1($classname, $params = null)
    {
        return self::logic($classname, ...$params);
    }
 
 
    public static function createClass2($classname, $params = null)
    {
        return self::logic($classname, $params);
    }


    public static function createClass3($classname, $params = null)
    {
        return self::logic($classname, $params);
    }


    public static function createClass4($classname, $params = null)
    {
        return self::logic($classname, $params);
    }


    public static function createClass5($classname, $params = null)
    {
        return self::logic($classname, $params);
    }


    public static function createClass6($classname, $params = null)
    {
        return self::logic($classname, $params)
    }


    public static function createClass7($classname, $params = null)
    {
        return self::logic($classname, $params);
    }


    public static function createClass8($classname, $params = null)
    {
        return self::logic($classname, $params);
    }


    public static function createClass9($classname, $params = null)
    {
        return self::logic($classname, $params);
    }

	/*
	 * create self instance.
	 *
	 * @return self
	 */
	public static function getNew()
	{
		return new self;
	}


	/*
	 * インスタンス実行.
	 *
	 * @param string classname 完全修飾形式クラス名
	 * @param array 生成クラスのコンストラクタの引数を格納した配列
	 * @return 指定クラスのインスタンス
	 */
    private static function logic(string $classname, array $params = null)
    {
		if ($params) {
			return new $classname(...$params);
		} else {
			return new $classname();
		}
	}
}
