<?php

    /**
     * 認証情報を操作する CertifiDaoクラス
     *
     * ce_id    TINYINT  AUTO_INCREMENT PRIMARY KEY
     * ce_name  TINYTEXT
     * ce_pword TINYBLOB    大文字小文字区別
     */

namespace news3\models;

use framework3\mvc\DB;
use framework3\mvc\Dao;
use framework3\mvc\MyvalidException;
use framework3\mvc\Session;
use framework3\common\F_util;
use news3\common\MyvalidExceptionChild;
use news3\common\AppErrorFunc;


class CertifiDao extends Dao
{
    private $session; # 認証情報格納処理用オブジェクト
    private $dsn;  # db問い合わせ情報
    private $ret_url;  # 認証失敗時のリターンアドレス.


    /*
     * コンストラクタ
     *
     * @param Session $session.
     * @param $ret_url 送信元のアドレス、または失敗時に戻るアドレス.
     * @param $dsn dsn情報を示す名称名(config.phpにて定義している).
     */
    public function __construct(Session $session, $ret_url = null, $dsn = DSN1)
    {
        $this->session = $session;
        $this->dsn = $dsn;
        if (!isset($ret_url)) {
            $this->ret_url = F_util::esc_url($_SERVER['HTTP_HOST']);  # ホストアドレスのリンク表示のセットに使われる。
        } else {
            $this->ret_url = $ret_url;
        }
    }


    /*
     * 認証処理
     *
     * @param $name
     * @param $password
     * @return bool
     */
    public function admin_execute(string $name, string $password): bool
    {
        //アカウントで検索
        $sql = "SELECT * FROM certifi WHERE ce_name=:ce_name";
        $params = ["ce_name" => $name];
        $stmt = DB::prepare_select($sql, false, $params, $this->dsn);
        try {
            $error = "";
            $num = "";
            if ($row = $stmt->fetch()) {
                // アカウントが一致.
                if ($name === $row['ce_name']) {
                    $password_hash = $row['ce_pword'];
                    //パスワードが一致
                    if (password_verify($password, $password_hash)) {
                        return true;
                    } else {
                        $error = "password mismatch!";
                        $num = __LINE__;  # エラー文字列の生成箇所をエラー文字列に付加することによって、キャッシュ表示データの判別に使われる。
                    }
                } else {
                    $error = "user mistake!";
                    $num = __LINE__;
                }
            } else {
                $error = "user not find!";
                $num = __LINE__;
            }
            $msg = MyvalidException::createMsg($num, $error);
            throw new MyvalidExceptionChild($msg, MYVALID);

            } catch (MyvalidExceptionChild $e) {
            $e->customFunction($this->ret_url);
            AppErrorFunc::getInstance();
            AppErrorFunc::catchAfter($e);
        }
        return false;
    }



    /*
     * データベースに登録されているpass情報を変更する
     * @param $name
     * @param $newpass
     * @return bool
     */
    public function chgPass(string $name, string $newpass): bool
    {
        //指定usernameのパスワードを更新
        $sql = "UPDATE certifi SET ce_pword=:ce_pword WHERE ce_name=:ce_name";
        $params = [["ce_name" => $name,
                    "ce_pword" => password_hash($newpass, PASSWORD_DEFAULT)]
                  ];
        $cnt = DB::prepare_not_getdt($sql, $params, $this->dsn);
        if (1 === $cnt) {
                return true;
        }
        return false;
    }


    /*
     * ユーザ情報をデータベースに登録する。
     * @param $name
     * @param $newpass
     * @return bool
     */
    public function addUser($name, $newpass): bool
    {
        //ユーザ情報を登録する
        $sql = "INSERT INTO certifi (ce_name, ce_pword) VALUES (:name, :pass)";
        $newpass = password_hash($newpass, PASSWORD_DEFAULT);
        $params = [["name" => $name, "pass" => $newpass]
                  ];
        $cnt = DB::prepare_not_getdt($sql, $params, $this->dsn);
        if (1 === $cnt) {
            return true;
        }
        return false;
    }


    public function deleteUser($name)
    {
        $sql = "DELETE FROM certifi WHERE ce_name = :ce_name";
        $params = [[ce_name => $name]];
        $cnt = DB::prepare_not_getdt($sql, $params, $this->dsn);
        if (1 === $cnt) {
            return true;
        }
        return false;
    }


    private function getPass($name): string
    {
        $sql = "SELECT ce_pword from certifi where ce_name = :ce_name";
        $params = [['ce_name' => $name]];
        $rets = DB::prepare_select($sql, true, $params, $this->dsn);
        return $rets[0][0]['ce_pword'];
    }
}
