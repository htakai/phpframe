<?php
/**
 * replace 2 sections.
 */

namespace news3\views;


use framework3\lib\html_view\CreateHtml;


class CreateCode2 extends CreateHtml
{
    // replacement mark.
    const REPLACE1 = "#p1#";
    const REPLACE2 = "#p2#";


    /*
     * display html page
     * @param string $contents
     * @return void
     */
    public function view (array $contents=null): void
    {
        $temp = parent::TEMPFILE_DIR . $this->template . '.php';

        //create filename for rendering use template file path.
        $cache = $this->createCacheFilename($temp);

        if (!is_file($cache)) {
            $temp_html = file_get_contents($temp);
            if (empty($contents)) {
                $obj = $this->factory_createTagStr();
                $contents = $this->getCreatehtmls($obj);
            }

            $search = array( parent::TITLE,
                             parent::PAGE,
                             self::REPLACE1,
                             self::REPLACE2
                           );
            $replace = array($this->title, $this->id_name, $contents[0], $contents[1]);
            $new = str_replace($search, $replace, $temp_html);

            file_put_contents($cache, $new, LOCK_EX);
        }
        require $cache;
    }
}
