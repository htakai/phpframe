<?php
/**
 * urlから処理を振り分けるクラス.
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2018/07/
 */

namespace framework3\mvc;

use framework3\common\ErrorFunc;
use framework3\common\F_util;

class Dispatcher  # chg final
{
    /**
     * urlから処理を振り分け、例外をキャッチする。.
     * @param $req_url $_SERVER['REQUEST_URI'].
     * @param $plevel domain以下urlのどの階層からcontroller名/action名として認識させるか.
     *   example domainname/appname/controller名->$plevel==1.
     *           domainname/folder/appname/controller名->$plevel==2.
     * @return array $ret  $ret[0]->呼び出すcontroller名、$ret[1]->呼び出すaction名.
     */
    public function dispatch(string $req_url, int $plevel): array # chg ()-->($req_url)
    {
        $ret = array();

        $params_tmp = array();

        try {
            //$plevelは1以上でないとconfig.phpでセットされたAPPNAMEが反映されない.
            if ($plevel < 1) {
                $msg = 'plevel must set over 1';
                throw new \DomainException($msg, DOMAIN);
            }
        } catch(\DomainException $e) {
//            ErrorFunc::catchAfter($e);
            F_util::catchfunc($e);
        }

        //URI（ドメイン以下のパス）を?で分割。GETパラータを無視するため.
        $params_tmp = explode('?', $req_url); # chg $req_url=$_SERVER['REQUEST_URI']

        // パラメーター取得（末尾,先頭の / は削除）.
        $params_tmp[0] = ltrim($params_tmp[0], '/');
        $params_tmp[0] = rtrim($params_tmp[0], '/');

        $params = array();

        if ('' !== $params_tmp[0]) {
            // パラメーターを / で分割.
            $params = explode('/', $params_tmp[0]);
        }


        //正しくplevelが設定されているかを判定.
        try {
            if (!isset($params[$plevel - 1]) || strcmp($params[$plevel - 1], APPNAME) !== 0) {
                $msg = "plevel:" . $plevel . " setting mistake!";
                throw new \LogicException($msg, LOGIC);
            }
        } catch (\LogicException $e) {
//            ErrorFunc::catchAfter($e);
            F_util::catchfunc($e);
        }

        // PLEVEL+１番目のパラメーターをコントローラーとして取得.
        $controller = "index"; #　初期設定はindex

        if ( $plevel < count($params)) {
            $controller = $params[$plevel];
        }

        //PLEVEL+１番目のパラメーターをもとにコントローラークラスインスタンス取得.
        $controllerInstance = $this->getControllerInstance($controller); #chg

        $ret['cont_nm'] = $controller;

        // 2番目のパラメーターをアクションとして取得.
        $action = 'index'; # 初期設定はindex
        if ( ($plevel + 1) < count($params)) {
            $action = $params[($plevel + 1)];
        }

        // アクションメソッドの存在確認.
        try {
            if (false === method_exists($controllerInstance, $action . 'Action')) {
                $msg = $action . ':Action can not found!';
                throw new \RuntimeException($msg, RUNTIME);
            }
        } catch (\RuntimeException $e) {
//            ErrorFunc::catchAfter($e);
            F_util::catchfunc($e);
        }

        $ret['act_nm'] = $action;

        //リクエストクラスのインスタンス生成.、
        $requestInstance = $this->getRequestInstance($controller); #chg

        // コントローラー初期設定.
        $this->setController($controllerInstance, $action, $requestInstance);

        // 処理実行.
        if (!defined('TEST')) {
            $this->controllerRun($controllerInstance);
        }

        return $ret;  # chg $ret['con_nm']==$controller, $ret['act_nm']==$action
                      # $req['req_obj']==$requestObj
    }


    /**
     * コントローラークラス生成、インスタンスを取得.
     * @param String controller
     * @return controllerInstance
     */
    public function getControllerInstance(string $controller): ControllerBase #chg private->public
    {
        // 一文字目のみ大文字に変換＋"Controller".
        $className = ucfirst(strtolower($controller)). 'Controller';

        // 名前空間名付controllerクラス名を定義.
        $fullControllerName = '\\' . APPNAME . '\\controllers\\' . $className;

        // ファイル存在チェック.
        $filename = sprintf('%s/%s/controllers/%s.php', SYSROOT, APPNAME, $className);
        try {
            if (false === file_exists($filename)) {
                $msg = $filename . ': file can not found!';
                throw new BadRequestException($msg, BADREQUEST);
            }
        } catch (BadRequestException $e) {
//            ErrorFunc::catchAfter($e);
            F_util::catchfunc4001($e);
        }

        // クラスインスタンス生成.
        $controllerInstarnce = new $fullControllerName();
        return $controllerInstarnce;
    }


     /**
     * リクエストインスタンス生成処理.
     */
    public function getRequestInstance(string $controller): Request # chg ()-->($controller_name)
    {
        // 一文字目のみ大文字に変換＋"Request".
        $className = ucfirst(strtolower($controller)) . 'Request'; # chg ($this->controller)-->($controller_name)

        //名前空間名付controllerクラス名を定義.
        $fullRequestName = '\\' . APPNAME . '\\request\\' . $className;

        // ファイル存在チェック.
        $filename = sprintf('%s/%s/request/%s.php', SYSROOT, APPNAME, $className);
        try {
            if (false === file_exists($filename)) {
                $msg = $filename . ': requestfunc file can not found!';
                throw new \LogicException($msg, LOGIC);
            }
        } catch (\LogicException $e) {
//            ErrorFunc::catchAfter($e);
            F_util::catchfunc($e);
        }

       //クラスインスタンス生成.
        $requestInstance = new $fullRequestName();

        return $requestInstance;

    }

    public function setController(ControllerBase $controllerInstance, string $action, Request $requestInstance)
    {
        $controllerInstance->setControllerAction($action);

        $controllerInstance->setRequestInstance($requestInstance);

    }

    public function controllerRun(ControllerBase $controllerInstance)
    {
        $controllerInstance->run();
    }
}
