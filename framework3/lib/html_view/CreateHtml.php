<?php
/**
 * process creating html tag parent class
 * 
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/06/
 */
 
 
namespace framework3\lib\html_view;
 
 
use framework3\lib\html_view\CreateTagStr;
use framework3\lib\html_view\HtmlDts;
 
    
abstract class CreateHtml {
        
    const TEMPFILE_DIR = SYSROOT .'/'. APPNAME . '/views/mytemplate/';
    const VIEW_CACHE_DIR = self::TEMPFILE_DIR. "cache/";
    //replacement mark  
    const TITLE = "#title#";
    const PAGE = "#id_name#";
        
    protected $templete;
    protected $title;
    protected $id_name; # for page id name
    private $parts_dts = array(array());
    
    
    /**
     * construct
     *
     * @param string temp_name  -->template file name without extension
     *        htmlDts dt    
     */
    public function __construct(string $temp_name, htmlDts $dt)
    {
        try {
            if (!is_file(self::TEMPFILE_DIR .$temp_name.'.php')) {
                $msg = 'can\'t read file: ' . $temp_name;
                throw new BadRequestException($msg, BADREQUEST);
            }
        } catch(BadRequestException $e) {
            ErrorFunc::catchAfter($e);  
        }   
            
        $this->template = $temp_name;
        $this->title = $dt->getTitle();
        $this->id_name = $dt->getName();
        if (defined('NOCACHE')) {
            $this->cacheFree();
        }
        $this->parts_dts = $dt->getDts();   # third array demension
    }
        
        
    /**
      * cache free processing use uniq id name
      *
      * @return string 
      */
    protected function cacheFree() : string
    {
    //但しAPPNAME/views/template dir/cacheのファイル数が増えてくるので注意。
        $this->id_name = date("His").$this->id_name;

        return $this->id_name;
    }
    
    
    /**
      * return template file path
      *
      * @return string file path
      */
    protected function retTempFilePath() : string 
    {
        $path = self::TEMPFILE_DIR. $this->template. '.php';
            
        return $path;
    }
    
    
    /**
      * create cache file name
      * 
      * @param string $path
      * @return string path
      */          
    protected function createCacheFilename(string $path) : string
    {
        $file =  self::VIEW_CACHE_DIR .$this->id_name .sha1_file($path);
            
        return $file;
    }
        
        
    /**
     * get connect html parts data by block and build up for each block html statement
     *
     * @retrun array contents 
     */
    public function getCreatehtmls() : array
    {           
        $html_strs = $this->factory_createTagStr();         
        $contents = array_fill(0, count($html_strs), null); 
            
        for ($i=0; $i<count($html_strs); $i++) {
            for ($j=0; $j<count($html_strs[$i]); $j++) {
                if (!empty($html_strs[$i][$j])) {
                    $contents[$i] = $contents[$i].$html_strs[$i][$j];
                }
            }
        }               
        return $contents;
    }
        
        
    /**
     * createTagStr object factory and get html parts
     *
     * @param array dts
     * @return third demension array of html parts
     */
    public function factory_createTagStr (array $dts=null) : array
    {
        if (empty($dts)) {
            $obj = new CreateTagStr($this->parts_dts);
        } else {
            $obj = new CreateTagStr ($dts);  # for append 
        }
        
        return  $obj->create_htmlstr();         
    }
        
        
    /**
     * it is necesary to define child class that is inheritance used this class
     */
    abstract function view();           
}
    