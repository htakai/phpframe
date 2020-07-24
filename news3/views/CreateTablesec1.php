<?php
/**
 * 2mark replace processing for table tag.
 */


namespace news3\views;


use framework3\lib\html_view\CreateHtml;


class CreateTablesec1 extends CreateHtml
{
    //replacement mark.
    const REPLACE1 = "#h2-1#";
    const REPLACE2 = "#table1#";

    /**
     * display html page.
     * @param string $contents
     * @return void
     */
    public function view (array $contents = null): void
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
                            self::REPLACE2,
                            );
            $replace = array($this->title, $this->id_name, $contents[0], $contents[1]);
            $new = str_replace($search, $replace, $temp_html);

            file_put_contents($cache, $new, LOCK_EX);
        }
        require $cache;
    }
}
