<?php

/**
 * news3 aplication ホームページ表示に係わるコントロールクラス /post.
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2018/07/
 */


namespace news3\controllers;

use framework3\mvc\ControllerBase;
use news3\request\PostRequest;


class PostController extends ControllerBase
{
    /*
     * 共通前処理.
     */
    protected function preAction()
    {
     // ビューの初期化。リクエストオブジェクト生成
        $this->request = new PostRequest();
    }


    public function indexAction()
    {
        // 動作確認用.
        echo '<br>' . 'PostController->indexAction() start!' . '<br>';
        if (false !== $this->request->getPost()) {
            echo '<br>' . 'post data=' . '<br>';
            var_dump($this->request->getPost());
        }
        if (false !== $this->request->getQuery()) {
            echo '<br>' . 'get data=' . '<br>';
            var_dump($this->request->getQuery());
        }

    }
    
    public function chkWorkAction() 
    {
        
    }
}
