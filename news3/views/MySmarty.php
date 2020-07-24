<?php
/**
 * Smarty拡張クラス
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/07/
 * <script src="https://gist.github.com/htakai/d38b9c7b3568bddac71fbe5a69e8ac72.js"></script>
 */
namespace news3\views;

use framework3\common\ErrorFunc;
use framework3\common\F_util;

//Smartyクラスを継承MySmartyクラスを作成します。smarty本体はbootstrap.phpにて読み込まれる。
final class MySmarty extends \Smarty
{
    public function __construct()
    {

        parent::__construct();
        //テンプレートファイル格納ディレクトリ設定
        $dir = __DIR__ . '/templates';

        try {
            if (!is_dir($dir)) {
                $msg = $dir . ' can not found!';
                throw new \LogicException($msg, LOGIC);
            }
        } catch (\LogicException $e) {
//            ErrorFunc::catchAfter($e);
            F_util::catchfunc($e);
        }

        $this->template_dir = $dir;

        //コンパイル、キャッシュファイル格納ディレクトリ設定
        $dir = __DIR__ . '/templates_c';

        try {
            if (!is_dir($dir)) {
                $msg = $dir . ' can not found!';
                throw new \LogicException($msg, LOGIC);
            }
        } catch (\LogicException $e) {
//            ErrorFunc::catchAfter($e);
            F_util::catchfunc($e);
        }

        $this->compile_dir = __DIR__ . '/templates_c';

        //デフォルトですべての出力をHTMLエスケープします。
        $this->escape_html = true;

   }

}
