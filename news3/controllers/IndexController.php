<?php

/**
 * news3 aplication ホームページ表示に係わるコントロールクラス.
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2020/07/
 */


namespace news3\controllers;

use framework3\mvc\ControllerBase;
use news3\request\IndexRequest;
use framework3\common\FactoryClass;


class IndexController extends ControllerBase
{
    public $factory = null;
    /*
     * 共通前処理.
     */
    protected function preAction(FactoryClass $fc)
    {
        $this->factory = $fc;
     // ビューの初期化。リクエストオブジェクト生成
//        $this->request = new IndexRequest();
        $this->request = FactoryClass::createClass0(IndexRequest::class);
    }


    public function indexAction()
    {
        // 動作確認用.
        echo '<br>' . 'indexAction() start!' . '<br>';
        if (false !== $this->request->getPost()) {
            echo '<br>' . 'post data=' . '<br>';
            var_dump($this->request->getPost());
        }
        if (false !== $this->request->getQuery()) {
            echo '<br>' . 'get data=' . '<br>';
            var_dump($this->request->getQuery());
        }

    }
}
