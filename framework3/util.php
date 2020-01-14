<?php

/**
 *アプリケーションnewsユーティリティ関数
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2018/07/
 */ 

namespace framework3;

use framework3\common\ErrorFunc;

/*
 * HTMLでのエスケープ処理をする関数
 *
 * @param array or string int $var
 * @return array or string int $ret
 */
function hs($var)  
{
    if (is_array($var)) {
        $ret = array();
        foreach ($var as $v) {
            $ret[] = htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
        }
        return $ret;
    } else {
		
        return htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
    }
}


/**
 * check phone number
 *
 * @param string number --->000-0000-0000
 * @return string number or false
 */
function is_valid_phone_number($number)
{
	if (is_string($number) && 1 === preg_match('/\A\d{2,4}+-\d{2,4}+-\d{4}\z/', $number)){
			return $number;
	}
	return false;
}

//urlチェック
function is_valid_url($url)
{
	if (filter_var($url, FILTER_VALIDATE_URL)){
		if(1 === preg_match('@^https?+://@i', $url)){
			return $url;
		}
	}
	return false;
}


/**
 * URLとしての属性値(href,src)のみを出力
 * @param $str url
 * @return $url
 */ 
function url_attr($str) 
{
    //「http:」「https:」「/」で始まる文字列のみを出力します。
    if (preg_match('/\Ahttp(s?):/', $str) || preg_match('#\A/#', $str)) {
		$str = 	str_replace("&amp;", "&", hs($str)); # &はエスケープしない
		if (!strstr($str, ";")) {
            return $str;
		} else {
			return "";
		}
	}
	//「http:」「https:」「/」で始まらない文字列は例外処理へ
    try {
			throw new \RuntimeException("unfair url defined!", RUNTIME);
			
		} catch (\RuntimeException $e) { 
print('url_attr error!');		
			ErrorFunc::catchAfter($e);
		}
	return false;
}
