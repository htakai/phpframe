<?php
/**
 * create parts of html tags
 * 
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/06/
 */
 
 
namespace framework3\lib\html_view;


use framework3\common\ErrorFunc;
use function framework3\hs;
use function framework3\url_attr;
 
 
class CreateTagStr
{ 
    const IMG_EXT = ".png";  # ext that can create image
    const TDLINK_INDEX = 1;  # index that is setting link for td tag
    const IMG_DIR = HOST. APPNAME. '/imgs/';
    
    private $dt;
    
    
    /**
     * construct
     *
     * @param $array dt  target data of array 
     */
    public function __construct ( array $dt)
    {       
        $this->dt = $dt;            
    }
    
    
    /**
     * create string of html tag 
     *
     * @param array dt  --->array is need for the third demension
     * @return array block  
     *  array[block][section][tag]
     */
    public function create_htmlstr( array $dt = null)  : array
    {   
        if ( empty($dt) ) {
            $dt = $this->dt;
        }
        $block = [];
        for ($i=0; $i<count($dt); $i++) {   
            $section = [];
            for ($j =0; $j<count($dt[$i]); $j++) {
                $targets = $dt[$i][$j];
                $type = array_shift($targets);  # pick up type $target[0] equal pick up $dt[$i][$j][0]
                
                try {   
                    switch ($type) {
                        case "plain"  :
                            $tag = self::createPlain($targets);
                            break;
                        case "tag"  :
                            $tag = self::createTag($targets);
                            break;
                        case "ul" :
                            $parts = self::createStrParts($targets);
                            $tag = self::createUL($parts);
                            break;
                        case "ol" :
                            $parts = self::createStrParts($targets);
                            $tag = self::createOL($parts);
                            break;  
                        case "img" :                        
                            $tag = self::createIMG($targets[0]);                                                
                            break;
                        case "dl" :
                            $tag = self::createDL($targets);
                            break;
                        case "table" :
                            $tag = self::createTable($targets);
                            break;
                        default :
                            $msg = "do not defined function!";
                            throw new \DomainException ($msg, DOMAIN);
                    }
                } catch(\DomainException $e) {
                        ErrorFunc::catchAfter($e);  
                }
                    
                $section[] = $tag;
            }
            $block[] = $section;
        }
        return $block;
    }       
    
    
    /**
      * case string that is not nessesary to html tag
      *
      * @param array dts 
      * @return string
      */
    public static function createPlain (array $dts) : string
    {
        $ret_html = "";     
        for ($i=0; $i<count($dts); $i++) {  
            $flg = false;
            try {
                foreach($dts[$i] as $key => $value) {
                    //<a href={$value}>を生成  
                    if ($key==="link" && !empty($value)) {
                        $ret_html = '<a href="'. url_attr($value). '">'.$ret_html;
                        $flg = true;
                    //$valueを組み込む   
                    }else if ($key==="str" && isset($value)) {
                        $ret_html = $ret_html.'<?= hs("'.$value.'")?>'; 
                    }else {
                        $msg = "do not parse tag use!";
                        throw new \DomainException ($msg, DOMAIN);
                    }
                }
                //a開始タグ生成されていれば、a閉じタグを生成
                if($flg) {
                    $ret_html .= "</a>";
                }
                $ret_html .= "\n";
                
            } catch(\DomainException $e) {
                        ErrorFunc::catchAfter($e);  
            }
                    
        }
        
        return $ret_html;   
    }
    
    
    /**
     * create ul,li　tag
     *
     * @param array lis 
     * @return string buffer --->created html part 
     */
    public static function createUL (array $lis) : string
    {
        ob_start();
        echo "\n".'<ul>'."\n";
        for ($i=0; $i<count($lis); $i++) {
            echo '<li>';
            echo $lis[$i];
            echo '</li>'."\n";
        }
        echo '</ul>';
        $buffer = ob_get_clean();
        
        return $buffer;
    }
    
    
    /**
     * create ol,li　tag
     *
     * @param array lis 
     * @return string buffer --->created html part 
     */
    public static function createOL (array $lis) : string
    {
        ob_start();
        echo "\n".'<ol>'."\n";
        for ($i=0; $i<count($lis); $i++) {
            echo '<li>';
            echo $lis[$i];
            echo '</li>'."\n";
        }
        echo '</ol>'."\n";
        $buffer = ob_get_clean();
        
        return $buffer;
    }
    
    
    /**
     * create img　tag
     *
     * @param array file --->only png file! name except this ext 
     * @return string tag --->created html part 
     */
    public static function createIMG (array $file) : string
    {
        $tag = '<img src="'. self::IMG_DIR. '<?=hs("'.$file['name'].'") ?>'.self::IMG_EXT.'" alt="<?=hs("'.$file['alt'].'")?>">';
        if (isset($file['link'])) {
            $str = url_attr($file['link']);
            $tag = '<a href="'. url_attr($file['link']). '">'. $tag. "</a>";
        }
            
        return "\n". $tag;
    }
    
    
    /**
     * create dl,dt,dd　tag
     *
     * @param array dls 
     * @return string buffer --->created html part 
     */
    public static function createDl (array $dls) : string
    { 
        ob_start();
        echo "\n".'<dl>'."\n";
        for ($i=0; $i<count($dls); $i++){
            echo '<dt><?=hs("'.$dls[$i]['dt'].'") ?></dt>'."\n";
            if (isset($dls[$i]['link'])) {
                echo "<dd>"
                . '<a href="'. url_attr($dls[$i]['link']). '">'
                . '<?=hs("'.$dls[$i]['dd'].'")?>'
                . "</a>"
                ."</dd>"."\n";
            } else {                
                echo '<dd><?=hs("'.$dls[$i]['dd'].'") ?></dd>'."\n";
            }
        }
        echo '</dl>';
        $buffer = ob_get_clean();
        
        return $buffer; 
    }
    
    
    /**
     * create general　tag
     *
     * @param array tags --->tags is for setting key ,you must only select into this $taglist without 'link'
     * @return string ret_html --->created html part 
     */
    public static function createTag (array $tags) : string
    {
        $taglist = ["p","h1","h2","h3","h4","h5","h6","li","span","mark","strong","small",];
        $ret_html = "";
        $flg = false;
        
        for ($i=0; $i<count($tags); $i++) { 
            try {
                foreach($tags[$i] as $key => $value) {
                    //<a href={$value}>を生成  
                    if ($key==="link" && !empty($value)) {
                        $ret_html .= '<a href="'. url_attr($value). '">';
                        $flg = true;
                    //<{$key}>$value</{$key}>を生成    
                    } else if (false !== array_search($key, $taglist)) {                    
                        if (empty($value)) {
                            exit('str did not write on!');
                        }
                        $str = '<'.$key.'>';                
                        $ret_html = $str. $ret_html.'<?= hs("'.$value.'")?>'; 
                        //a開始タグ生成されていれば、a閉じタグを生成
                        if($flg) {
                            $ret_html .= "</a>";
                            $flg = false;
                        }
                        $ret_html .= '</'.$key.'>'."\n";
                    } else {
                        $msg = "do not parse tag use!";
                        throw new \DomainException ($msg, DOMAIN);
                    }           
                }
            } catch(\DomainException $e) {
                        ErrorFunc::catchAfter($e);  
            }
                    
        }
        
        return $ret_html;
    }  

    
    /**
     * create table　tag
     *
     * @param array tbls 
     * @return string buffer --->created html part 
     */
    public static function createTable (array $tbls) :string
    {
        ob_start();
        echo '<table>';
        echo '<caption><?=hs("'.$tbls['caption'].'")?></caption>'."\n";
        echo "\n".'<tr>'."\n";
        for ($i=0; $i<count($tbls['th']); $i++) {
            echo '<th><?=hs("'.$tbls['th'][$i].'")?></th>';
        }
        echo "\n".'</tr>'."\n";
        for ($i=0; $i<count($tbls['td']); $i++) {
            echo '<tr>'."\n";
            $link = "";
            //keyがtdのときインデックス0にリンクデータが入っている
            for ($j=0; $j<count($tbls['td'][0]); $j++) {
                if ($j===0) {
                    if (!empty($tbls['td'][$i][0])) {
                        $link = $tbls['td'][$i][0];
                    }
                    continue;
                } 
                if ($j === self::TDLINK_INDEX && !empty($link)) {
                    echo '<td><a href="'. url_attr($link). '"><?=hs("'.$tbls['td'][$i][$j].'")?></a></td>';
                    continue;
                }
                echo '<td><?=hs("'.$tbls['td'][$i][$j].'")?></td>';
            }       
            echo "\n".'</tr>'."\n";     
        }
        echo '</table>'."\n";
        $buffer = ob_get_clean();
        
        return $buffer; 
    }
    
    
    /**
     * create add link part tag for 'li' or 'ol' tag
     *
     * @param array dts 
     * @return array ret_htmls --->created link html part 
     */
    public static function createStrParts (array $dts) : array
    { 
        $ret_htmls = [];
        for ($i=0; $i<count($dts); $i++) {  
            $ret_html = "";
            $flg = false;
            foreach($dts[$i] as $key => $value) {       
                if ($key==="link" && !empty($value)) {
                    $ret_html .= '<a href="'. url_attr($value). '">';
                    $flg = true;
                }else if ($key==="str") {
                    if (empty($value)) {
                        exit('str das not write on!');
                    }
                    $ret_html .= '<?=hs("'.$value.'")?>';
                    if ($flg) {
                        $ret_html .= "</a>";
                        $flg = false;
                    }       
                }   
            }
            $ret_htmls[] = $ret_html;   
        }
        
        return $ret_htmls;
    }
}
