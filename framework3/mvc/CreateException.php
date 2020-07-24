<?php

/**
 * render for view of exception.
 */

namespace framework3\mvc;

use framework3\lib\html_view\CreateHtml;

class CreateException extends CreateHtml
{
    //replacement mark.
    const REPLACE1 = "#contents#";
    const REPLACE2 = "#url#";

    /*
     * display html page.
     * @param string $contents
     * @return void
     */
    public function view (array $contents = null): void
    {
        $temp = $this->retTempFilePath();

        //create filename for rendering use template file path.
        $cache = $this->createCacheFilename($temp);

        if (!is_file($cache)) {
            $temp_php = file_get_contents($temp);
            if (empty($contents)) {
                $contents = $this->getCreatehtmls();
            }

            $search = array(
                            parent::TITLE,
                            parent::PAGE,
                            self::REPLACE1,
                            self::REPLACE2,
                            );

            $replace = array($this->title, $this->id_name, $contents[0], $contents[1]); # match up replacement mark.
            $new = str_replace($search, $replace, $temp_php);

            file_put_contents($cache, $new, LOCK_EX);
        }
        require $cache;
    }
}
