<?php
/**
 * create parts of html tags.
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/06/
 */


namespace framework3\lib\html_view;


use framework3\common\ErrorFunc;
use framework3\common\F_util;


class CreateTagStr
{
    const IMG_EXT = ".png";  # ext that can create image.
    const TDLINK_INDEX = 1;  # index that is setting link for td tag.
    const IMG_DIR = "imgs/";

    private $dt;


    /*
     * construct.
     *
     * @param $array dt  target data of array.
     */
    public function __construct (array $dt = null)
    {
        if (isset($dt)) {
            $this->dt = $dt;
        }
    }


    /*
     * create string of html tag .
     *
     * @param array dt  --->array is need for the third demension.
     * @return array block
     *  array[block][section][tag]
     */
    public function create_htmlstr(array $dt = null): array
    {
        if (empty($dt)) {
            $dt = $this->dt;
        }
        $block = [];
        for ($i = 0; $i < count($dt); $i++) {
            $section = [];
            for ($j = 0; $j < count($dt[$i]); $j++) {
                $targets = $dt[$i][$j];
                $type = array_shift($targets); # pick up type $target[0] equal pick up $dt[$i][$j][0].
                try {
                    switch ($type) {
                        case "plain":
                            $tag = self::createPlain($targets);
                            break;
                        case "tag":
                            $tag = self::createTag($targets);
                            break;
                        case "ul":
                            $parts = self::createStrParts($targets);
                            $tag = self::createUL($parts);
                            break;
                        case "ol":
                            $parts = self::createStrParts($targets);
                            $tag = self::createOL($parts);
                            break;
                        case "img":
                            $tag = self::createIMG($targets[0]);
                            break;
                        case "dl":
                            $tag = self::createDL($targets);
                            break;
                        case "table":
                            $tag = self::createTable($targets);
                            break;
                        default:
                            $msg = "can not select defined function!";
                            throw new \DomainException ($msg, DOMAIN);
                    }
                } catch (\DomainException $e) {
//                    ErrorFunc::catchAfter($e);
                    F_util::catchfunc($e);
                }
                $section[] = $tag;
            }
            $block[] = $section;
        }
        return $block;
    }


    /*
     * case string that is not nessesary to html tag.
     *
     * @param array dts[][]
     * @return string
     */
    public static function createPlain (array $dts): string
    {
        try {
            if (is_array($dts[0])) {
                $ret_html = "";
                for ($i = 0; $i < count($dts); $i++) {
                    $flg = false;
                    foreach ($dts[$i] as $key => $value) {
                        //<a href={$value}>を生成
                        if ($key === "link" && !empty($value)) {
                            $ret_html = '<a href="' . '<?= F_util::esc_url("'.$value . '") ?>">' . $ret_html;
                            $flg = true;
                        //$valueを組み込む
                        } elseif ($key === "str" && isset($value)) {
                            $ret_html = $ret_html . '<?= F_util::hs("' . $value . '")?>';
                        } else {
                            $msg = "do not parse tag use!";
                            throw new \DomainException($msg, DOMAIN);
                        }
                    }
                // a開始タグ生成されていれば、a閉じタグを生成.
                    if ($flg) {
                        $ret_html .= "</a>";
                    }
                    $ret_html .= "\n";
                }
            } else {
                $msg = 'array is defined mistake!';
                throw new \DomainException($msg, DOMAIN);
            }
        } catch (\DomainException $e) {
//            ErrorFunc::catchAfter($e);
            F_util::catchfunc($e);
        }
        return trim($ret_html);
    }


    /*
     * create ul,li　tag.
     *
     * @param array lis
     * @return string buffer --->created html 'ul' part or ''.
     */
    public static function createUL(array $lis): string
    {
        $buffer = "";
        if (isset($lis[0]) ) {
            ob_start();
            echo "\n" . '<ul>' . "\n";
            for ($i = 0; $i < count($lis); $i++) {
                echo '  <li>';
                echo $lis[$i];
                echo '</li>' . "\n";
            }
            echo '</ul>';
            $buffer = ob_get_clean();
        }
        return $buffer;
    }


    /*
     * create ol,li　tag.
     *
     * @param array lis
     * @return string buffer --->created html 'ol' part or "".
     */
    public static function createOL(array $lis): string
    {
        $buffer = "";
        if (isset($lis[0]) ) {
            ob_start();
            echo "\n" . '<ol>' . "\n";
            for ($i = 0; $i < count($lis); $i++) {
                echo '  <li>';
                echo $lis[$i];
                echo '</li>' . "\n";
            }
            echo '</ol>';
            $buffer = ob_get_clean();
        }
        return $buffer;
    }


    /*
     * create img　tag.
     *
     * @param array file --->only png file! use filename excepted this ext
     * @return string tag --->created html img part or ''.
     */
    public static function createIMG(array $file): string
    {
        $tag = "";
        if (!empty($file['name'])) {
            $imgdir = SKM . $_SERVER['HTTP_HOST'] . '/'. APPNAME . '/' . self::IMG_DIR;
            $tag = '<img src="' . $imgdir . '<?=F_util::hs("'.$file['name'] . '") ?>' . self::IMG_EXT . '" alt="<?=F_util::hs("'.$file['alt'] . '")?>">';
            if (isset($file['link'])) {
                $tag = '<a href="' . '<?= F_util::esc_url("'.$file['link'] . '") ?>">' . $tag . "</a>";
            }
            $tag = "\n" . $tag;
        }
        return $tag;
    }


    /*
     * create dl,dt,dd　tag.
     *
     * @param array dls
     * @return string buffer --->created html part
     */
    public static function createDl(array $dls): string
    {
        $buffer = "";
        if (!empty($dls[0]['dt'])) {
            ob_start();
            echo "\n" . '<dl>' . "\n";
            for ($i = 0; $i < count($dls); $i++) {
                if (!empty($dls[$i]['dt'])) {
                    echo ' <dt><?= F_util::hs("'.$dls[$i]['dt'].'") ?></dt>'. "\n";
                    if (isset($dls[$i]['dd'])) {
                        echo '  <dd>';
                        $link_flg = false;
                        if (!empty($dls[$i]['link'])) {
                            echo '<a href="'.'<?= F_util::esc_url("'.$dls[$i]['link']. '") ?>">';
                            $link_flg = true;
                        }
                        echo '<?= F_util::hs("'.$dls[$i]['dd'] . '") ?>';
                        if ($link_flg) {
                            echo '</a>';
                        }
                        echo '</dd>' . "\n";
                    }
                }
            }
            echo '</dl>' . "\n";
            $buffer = ob_get_clean();
        }
        return $buffer;
    }


    /*
     * create general　tag.
     *
     * @param array tags --->tags is for setting key ,you must only select into this $taglist without 'link'.
     * @return string ret_html --->created html part
     */
    public static function createTag (array $tags): string
    {
        $taglist = ["p", "h1", "h2", "h3", "h4", "h5", "h6", "li", "span", "mark", "strong", "small",];
        $ret_html = "";
        $flg = false;

        for ($i = 0; $i < count($tags); $i++) {
            try {
                foreach ($tags[$i] as $key => $value) {
                    // <a href={$value}>を生成.
                    if ($key === "link" && !empty($value)) {
                        $ret_html .= '<a href="' . '<?= F_util::esc_url("'.$value.'") ?>">';
                        $flg = true;
                    // <{$key}>$value</{$key}>を生成.
                    } elseif (false !== array_search($key, $taglist)) {
                        if (empty($value)) {
                            $ret_html = "";
                            break 2;
                        }
                        $str = "\n".'<' . $key . '>';
                        $ret_html = $str . $ret_html . '<?= F_util::hs("'.$value.'")?>';
                        // a開始タグ生成されていれば、a閉じタグを生成.
                        if ($flg) {
                            $ret_html .= "</a>";
                            $flg = false;
                        }
                        $ret_html .= '</' . $key . '>' . "\n";
                    } else {
                        $msg = "do not parse tag use!";
                        throw new \DomainException ($msg, DOMAIN);
                    }
                }
            } catch (\DomainException $e) {
//                ErrorFunc::catchAfter($e);
                F_util::catchfunc($e);
            }
        }
        return $ret_html;
    }


    /*
     * create table　tag.
     *
     * @param array tbls
     * @return string buffer --->created html part
     */
    public static function createTable (array $tbls): string
    {
        $buffer = "";
        if (isset($tbls['td'])) {
            ob_start();
            echo '<table>';
            if (!empty($tbls['caption'])) {
                echo "\n" . '  <caption><?= F_util::hs("'.$tbls['caption'] . '") ?></caption>' . "\n";
            }
            if (count($tbls['th']) > 0) {
                echo '  <tr>' . "\n";
                for ($i = 0; $i < count($tbls['th']); $i++) {
                    echo '    <th><?= F_util::hs("'.$tbls['th'][$i] . '") ?></th>'. "\n";
                }
                echo '  </tr>' . "\n";
            }
            for ($i = 0; $i < count($tbls['th']); $i++) {
                echo '  <tr>' . "\n";
                $link = "";
                // keyがtdのときインデックス0にリンクデータが入っている$tbls['td'][0]はリンクデータ.
                // 実データはインデックス1以降に入れることになる.
                for ($j = 0; $j < count($tbls['td'][0]); $j++) {
                    if ($j === 0) {
                        if (!empty($tbls['td'][$i][0])) {
                            $link = $tbls['td'][$i][0];
                        }
                        continue;
                    }
                    // リンクデータを実データと結びつける処理.
                    if ($j === self::TDLINK_INDEX && !empty($link)) {
                        echo '    <td><a href="' . '<?= F_util::esc_url("'. $link .'") ?>">'. '<?= F_util::hs("'.$tbls['td'][$i][$j] .'") ?></a></td>'."\n";
                        continue;
                    }
                    echo '    <td><?= F_util::hs("' . $tbls['td'][$i][$j] . '") ?></td>'."\n";
                }
                echo '  </tr>' . "\n";
            }
            echo '</table>' . "\n";
            $buffer = ob_get_clean();
        }
        return $buffer;
    }


    /*
     * create add link part tag for 'li' or 'ol' tag.
     *
     * @param array dts[][]
     * @return array ret_htmls[] --->created link html part
     */
    public static function createStrParts (array $dts): array
    {
        if (is_array($dts[0])) {
            $ret_htmls = [];
            for ($i = 0; $i < count($dts); $i++) {
                $ret_html = '';
                $flg = false;
                foreach ($dts[$i] as $key => $value) {
                    if ($key === "link" && !empty($value)) {
                        $ret_html .= '<a href="' . F_util::esc_url($value) . '">';
                        $flg = true;
                    } elseif ($key === "str") {
                        try {
                            if (empty($value)) {
                                $msg = "hash str value empty!";
                                throw new \LogicException($msg, LOGIC);
                            }
                        } catch (\LogicException $e) {
//                          ErrorFunc::catchAfter($e);
                            F_util::catchfunc($e);
                        }
                        $ret_html .= '<?=F_util::hs("' . $value . '")?>';
                        if ($flg) {
                            $ret_html .= "</a>";
                            $flg = false;
                        }

                    }
                }
                $ret_htmls[] = trim($ret_html);
            }
        } else {
            try {
                $msg = 'array is defined mistake!';
                throw new \LogicException($msg, LOGIC);
            } catch (\LogicException $e) {
//              ErrorFunc::catchAfter($e);
                F_util::catchfunc($e);
            }
        }
        return $ret_htmls;
    }
}
