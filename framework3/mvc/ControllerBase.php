<?php
/**
 * コントローラー親クラス.
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2018/07/
 */


namespace framework3\mvc;

use framework3\common\FactoryClass;

abstract class ControllerBase
{
    protected $action; # アクション名
    protected $view = null;  # 子クラスからセットされるsmarty obj
    protected $request; # request オブジェクト


    // コンストラクタ.
    public function __construct()
    {
    }


    /*
     * アクションの文字列設定.
     * @param string action
     * @return boolean true
     */
    public function setControllerAction(string $action) : bool
    {
        $this->action = $action;
        return true; #chg
    }


    /*
     * リクエストオブジェクトインスタンスをプロパティにセット.
     *
     * @param Request obj
     */
    public function setRequestInstance(Request $obj)
    {
        $this->request = $obj;
    }


    /*
     * 処理実行.
     */
    public function run(): void
    {
        $fc = FactoryClass::getNew();
        // 共通前処理
        $this->preAction($fc);

        // アクションメソッド
        $methodName = sprintf('%sAction', $this->action);

        $this->$methodName();  # 子クラスでメソッドを実装、モデルオブジェを使い必要データを収集、加工、登録などの処理をし表示処理をする。
    }


    // 共通前処理（オーバーライド前提）**表示、処理が必要の場合は子クラスで定義.
    // ビューの初期化.
    // たとえば、$this->view = new MySmarty();.
    // requestデータのサニダイズ.
    abstract protected function preAction(FactoryClass $fc);

}
