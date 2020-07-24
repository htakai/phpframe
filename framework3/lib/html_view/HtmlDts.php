<?php
/**
 * define html variable data that will be embeded into the template file.
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/06/
 */


namespace framework3\lib\html_view;

use framework3\common\ErrorFunc;

class HtmlDts
{
    private $title; # for title html tag.
    private $name;  # for body html tag id property.
    private $dts = []; # embeded data.


    /*
     * construct.
     *
     * @param string titile
     * @param string name
     * @param array dt  --->array is the third demension array[mark block][tag block][tag]
     */
    public function __construct(string $title, string $name, array $dt = null)
    {
        $this->name = $name;
        $this->title = $title;
		if (isset($dt)) {
			$this->dts = $dt;
		}

    }


    /*
     * get title.
     *
     * @return string title
     */
    public function getTitle(): string
    {
        return $this->title;
    }


    /*
     * get name.
     *
     * @return string name --->page id name
     */
    public function getName(): string
    {
        return $this->name;
    }


    /*
     * get data.
     *
     * @return array dts --->third demension array
     */
    public function getDts(): ?array
    {
        return $this->dts;
    }


    /*
     * addDtblock.
     *
     * @param array $dt_block
     */
    public function addDtblock(array $dt_block): void
    {
        $this->dts[] = $dt_block;
    }


    /*
     * unshiftDtblock.
     *
     * @param array $dt_block
     */
    public function unshiftDtblock(array $dt_block): void
    {
        array_unshift ($this->dts, $dt_block);
    }


    /*
     * addDtTag.
     *
     * @param int $block_num
     * @param array $dt_tag
     */
    public function addDtTag(int $block_num, array $dt_tag): void
    {
        $this->dts[$block_num][] = $dt_tag;
    }


    /*
     * unshiftDtTag.
     *
     * @param int $block_num
     * @param array $dt_tag
     */
    public function unshiftDtTag(int $block_num, array $dt_tag): void
    {
        array_unshift ($this->dts[$block_num], $dt_tag);
    }


    /*
     * execute display processing.
     *
     * @param string $render_fname  view processing class name
     * @param string $temp_name  view template file name
     * @param htmlDts $htmldts_obj
	 * @return $obj operating object for rendering.
     */
    public function display(string $render_fname, string $temp_name, htmlDts $htmldts_obj): CreateHtml
    {
        $obj = $this->createRenderObj($render_fname, $temp_name, $htmldts_obj);
        $dt = $htmldts_obj->getDts();
        if (!is_array($dt[0])) { # 一次元配列の場合
            $obj->view($dt);
        } else { # htmlタグ生成の場合
            $obj->view();
        }
		
		return $obj;
    }


    /**
     * createRenderObj.
     *
     * @param string $render_fname  view processing class name
     * @param string $temp_name  view template file name
     * @param htmlDts $htmldts_obj
     * @return $render_fname obj
     */
    private function createRenderObj(string $render_fname, string $temp_name, htmlDts $htmldts_obj): CreateHtml
    {
        $render_fullname = '\\' . APPNAME . '\\views\\' . $render_fname;

        return new $render_fullname($temp_name, $htmldts_obj);
    }
}
