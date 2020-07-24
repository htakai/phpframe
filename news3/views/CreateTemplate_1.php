<?php
/**
 * 1 mark replace processing for template file.
 */


namespace news3\views;


use framework3\lib\html_view\CreateHtml;


class CreateTemplate_1 extends CreateHtml
{
    // replacement mark , able to rewrite!.
    const REPLACE1 = "#c1#";

    /*
     * display html page
     * @param string $contents
     * @return void
     */
    public function view (array $contents=null): void
    {
        $tempfile_path = $this->retTempFilePath();
        $cache = $this->createCacheFilename($tempfile_path);

        if (!is_file($cache)) {
            $temp_html = file_get_contents($tempfile_path);
            if (empty($contents)) {
                $obj = $this->factory_createTagStr();
                $contents = $this->getCreatehtmls($obj);
            }

            $search = array(
                            parent::TITLE,
                            parent::PAGE,
                            self::REPLACE1,
                            );  # able to rewrite!

            $replace = array($this->title, $this->id_name, $contents[0]); # able to rewrite!

            $new = str_replace($search, $replace, $temp_html);

            file_put_contents($cache, $new, LOCK_EX);
        }
        require $cache;
    }
}
