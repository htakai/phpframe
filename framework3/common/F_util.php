<?php

/**
 *アプリケーション・ユーティリティ関数
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/07/
 */

namespace framework3\common;

use framework3\mvc\BadRequestException;

class F_util
{

    /*
     * HTMLでのエスケープ処理をする関数.
     *
     * @param array or string int $var
     * @return array or string int $ret
     */
    public static function hs($var)
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


    /*
     * check phone number.
     *
     * @param string number --->000-0000-0000
     * @return string number or false
     */
    public static function is_valid_phone_number($number)
    {
        if (is_string($number) && 1 === preg_match('/\A\d{2,4}+-\d{2,4}+-\d{4}\z/', $number)){
            return $number;
        }
        return false;
    }


    //urlチェック.
    public static function is_valid_url($url)
    {
        return false !== filter_var($url, FILTER_VALIDATE_URL) && preg_match('@^https?+://@i', $url);
    }


    /*
     * URLとしての属性値(href,src)のみを出力.
     * @param $str url
     * @return $url
     */
    public static function url_attr($str)
    {
        $str = trim($str);
        //「http:」「https:」「/」で始まる文字列のみを出力します。
        if (preg_match('/\Ahttp(s?):/', $str) || preg_match('#\A/#', $str)) {
            $str =  str_replace("&amp;", "&", self::hs($str)); # &はエスケープしない
            if (!strstr($str, ";")) {
                return $str;
            } else {
                return "";
            }
        }
        //「http:」「https:」「/」で始まらない文字列は例外処理へ.
        try {
            throw new \RuntimeException("unfair url defined!", RUNTIME);
        } catch (\RuntimeException $e) {
            self::catchfunc($e);
//            ErrorFunc::catchAfter($e);
        }
        return false;
    }


    /*
     * http httpsスキームのみurlを安全にフィルタリングする.
     *
     * @param string $url
     * @return escaped url  urlとしてふさわしくない場合は空文字列を返す。
     */
    public static function esc_url(string $url) :string
    {
        $url = trim($url);
        if (false !== filter_var($url, FILTER_VALIDATE_URL)
            && 1 === preg_match('@^https?+://@i', $url)) { # http or https only.
            if (strpbrk($url, '?')) { # have query.
                $strs = explode('?', $url);
                $query = '?' ;
                if (strpbrk($strs[1], '&')) { # have multiple parameters.
                    $strs_params = explode('&', $strs[1]);
                    for ($i = 0; $i < count($strs_params); $i++) {
                        if (strpbrk($strs_params[$i], '=')) { # parameterが=で区切られている.
                            $keyvalue = explode('=', $strs_params[$i]);
                            if (count($keyvalue) === 2) { # valid '=' setting.
                                $key = $keyvalue[0];
                                $value = $keyvalue[1];
                                if (!empty($key) && !empty($value)) { # key, valueにそれぞれ値がセットされている。
                                    $query .= self::hs(rawurlencode($key)). '='. self::hs(rawurlencode($value));
                                }
                            } else {
                            return self::hs($strs[0]); # queryなしで出力.
                            }
                        } else { # parameterが=で区切られていない.
                            $query = rtrim($query, '&');
                            $query .= self::hs(rawurlencode('&' . $strs_params[$i]));
                            continue;
                        }
                        $query .= '&';
                    } # $strs_params loop end.
                    $query = rtrim($query, '&');
                    return self::hs($strs[0]) . $query;
                } else { # have mono parameter.
                    if (strpbrk($strs[1], '=')) { # parameterが=で区切られている.
                        $keyvalue = explode('=', $strs[1]);
                        if (count($keyvalue) === 2) { # valid '=' setting
                            $key = $keyvalue[0];
                            $value = $keyvalue[1];
                            if (!empty($key) && !empty($value)) { # key, valueにそれぞれ値がセットされている。
                                $query .= self::hs(rawurlencode($key)) . '='. self::hs(rawurlencode($value));
                                return self::hs($strs[0]) .$query;
                            }
                        }
                    }
                    # queryなしで出力
                }
            }
            return self::hs(rtrim($url, '?')); # have not query.
        }
//print('can not encoding!');
        return "";
    }


    /*
     * テスト用にException オブジェクトを投げなおす。
     *
     *@param Exception $e.
     */
    public static function catchfunc(\Exception $e)
    {
        if (defined('TEST')) { # for test
            print($e->getCode() . '#' . $e->getMessage());
            throw $e;
        } else { // # for usual case.
            ErrorFunc::catchAfter($e);
        }
    }


    /*
     * テスト用にBadRequestExceptionオブジェクトをRuntimeExceptionオブジェクトに付け替える.
     * phpunitにおいて、BadRequestExceptionオブジェクトは認識しない為.
     *
     * @param BadRequestException $e-
     */
    public static function catchfunc4001(BadRequestException $e)
    {
        if (defined('TEST')) {
            throw new \RuntimeException($e->getMessage(), $e->getCode());
        } else {
            ErrorFunc::catchAfter($e);
        }
    }
}
