<?php
/**
 * replace 2 sections
 */


namespace news3\views;


use framework3\lib\html_view\CreateHtml;

class Create2sec1 extends CreateHtml
{
    // replacement mark
    const REPLACE1 = "#c1#";
    const REPLACE2 = "#c2#";

    /*
     * display html page
     *
     * @param array $contents
     * @return void
     */
    public function view (array $contents = null): void
    {
        $tempfile_path = $this->retTempFilePath();

        // create filename for rendering use template file path.
        $cache = $this->createCacheFilename($tempfile_path);

        if (!is_file($cache) ) { # that is new create file
            $temp_html = file_get_contents($tempfile_path);
            if (empty($contents)) { # for no argument that is case of third demension data processing
                $obj = $this->factory_createTagStr();
                $contents = $this->getCreatehtmls($obj);
            }

            //replace processing use template file
            $search = array(parent::TITLE,
                            parent::PAGE,
                            self::REPLACE1,
                            self::REPLACE2,
                           );
            $replace = array($this->title, $this->id_name, $contents[0], $contents[1]);
            $new = str_replace($search, $replace, $temp_html);

            file_put_contents($cache, $new, LOCK_EX);
        }

        // else if alredy created cache file then excute cached file.
        require $cache;
    }
}
