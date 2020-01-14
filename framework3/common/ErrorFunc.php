<?php
/**
 * 例外エラー処理、エラー種別を定義表示するクラス
 *
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2019/07/
 */
 
namespace framework3\common;


//use news3\views\MySmarty;
use function framework3\hs;
use framework3\mvc\BadRequestException;
use framework3\lib\html_view\htmlDts;
use framework3\mvc\MyvalidException;
use framework3\mvc\CreateException;


class ErrorFunc
{
    const E_DELIMITER = "-->";  # use debug mode
    const TEMP_NAME = "temp_exception"; # rendering base filename except ext
    const TITLE = "Throwable is"; # for rendering 
    const RENDER_FNAME = "CreateException"; # rendering function filename except ext.
    const EXCEP = array( ERROR => 'ErrorException'
                       , LOGIC => 'LogicException'
                       , BADFUNC => 'BadFunctionCallException'
                       , BADMETHOD => 'BadMethodCallException'
                       , DOMAIN=> 'DomainException'
                       , INVALID => 'InvalidArgumentException'
                       , LENGTH => 'LengthException'
                       , OUTOFRANGE => 'OutOfRangeException'
                       , RUNTIME => 'RuntimeException'
                       , OUTOFBOUNDS => 'OutOfBoundsException'
                       , OVERFLOW => 'OverflowException'
                       , RANGES => 'RangeException'
                       , UNDERFLOW => 'UnderflowException'
                       , UNEXPECTED => 'UnexpectedValueException'
                       , BADREQUEST => 'BadRequestException'
                       , MYVALID => 'MyvalidException'
                       );
                       
    const ELEBEL = array( E_ERROR  => 'E_ERROR' 
                        , E_WARNING => 'E_WARNING'
                        , E_PARSE => 'E_PARSE'
                        , E_NOTICE => 'E_NOTICE'
                        , E_CORE_ERROR => 'E_CORE_ERROR'
                        , E_CORE_WARNING => 'E_CORE_WARNING'
                        , E_COMPILE_ERROR => 'E_COMPILE_ERROR'
                        , E_COMPILE_WARNING => 'E_COMPILE_WARNING'
                        , E_USER_ERROR => 'E_USER_ERROR'
                        , E_USER_WARNING => 'E_USER_WARNING'
                        , E_USER_NOTICE => 'E_USER_NOTICE'
                        , E_STRICT => 'E_STRICT'
                        , E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR'
                        , E_DEPRECATED => 'E_DEPRECATED'
                        , E_USER_DEPRECATED => 'E_USER_DEPRECATED'
                        , E_ALL => 'E_ALL'
                        );  
                        
    protected static $_instance;
    
    
    
    /**
     * return self instance
     *
     * @return $_instance
     */
    public static function getInstance() : self
    {   
        if(is_null(static::$_instance)){
            static::$_instance = new static();
        }
       return static::$_instance;
    }
    
    
    /**
     * create string that is connected exception variables as error message from exception object 
     * @param \Exception $e
     * @return string $str
     */
    protected static function connect_ex_str(\throwable $e) : string  
    {
        $str = "throwable is=>"; 
        if (array_key_exists($e->getCode(), self::EXCEP)) {
            $ex_name = self::EXCEP[$e->getCode()];
        }else{
            $ex_name = $e->getCode();
            if (empty($ex_name)) {
                $ex_name = "undefined throwable";
            }
            $ex_name = '['. get_class($e). ']'. $ex_name;
        }
        
        $replacement = '??';
        $ex_message = str_replace(self::E_DELIMITER, $replacement, $e->getMessage());
        
        if (ERROR === $e->getCode()) {
            try {
                if (array_key_exists($e->getSeverity(), self::ELEBEL)) {
                    $ex_message = '['. self::ELEBEL[$e->getSeverity()]. ']'. $ex_message;
                } else {
                    $msg = "set_error_handler mistake!";
                    throw new \DomainException ($msg, DOMAIN);
                }
            } catch(\DomainException $e) {
                    ErrorFunc::catchAfter($e);  
            }
        }
    
        $str .= sprintf('%s<br/>%s%s<br/>%s%s(%s)<br/>%s%s<br/>----<br/>'
                            ,$ex_name
                            ,self::E_DELIMITER
                            ,$ex_message
                            ,self::E_DELIMITER
                            ,$e->getFile()
                            ,$e->getLine()
                            ,self::E_DELIMITER
                            ,$e->getTraceAsString()
                            );
        return $str;
    
    } 
    
    
    /**
     * can not clone this class
     *
     */
    public final function __clone() 
    {
        try {
            throw new RuntimeException ('Clone is not allowed against ' . get_class($this),
        RUNTIME);
        } catch(\RuntimeException $e) {
            self::catchAfter($e);   
        }
    }
   
   
    /**
     * processing after catch exception
     * @param \Throwable $e
     */
    public static function catchAfter(\Throwable $e) 
    {   
        if (defined('DBG')) {       
            $ex_str = self::connect_ex_str($e);
            $GLOBALS['exceptions'] .= $ex_str;
            
            if (method_exists($e, 'getRetUrl') && !empty($e->getRetUrl())) { # for MyvalidException
                $GLOBALS['ret_url'] = $e->getRetUrl();
            }
            
        } else {        
            static::$_instance->funcByCode($e);
        }
    }
    
    
    /**
     * processing when production mode is running to catch exception or error
     * @param \Throwable $e
     */
    protected function funcByCode(\Throwable $e) 
    {
        if (!defined('DBG')) {
            $error_code = $e->getCode();
        
            if ($error_code === BADREQUEST) {
                self::case_badrequest($e);
            
            } else if (!strcmp(get_class($e), "PDOException")) { # for database
                self::case_PDO($e);
                
            } else {
                $_class = (int)($error_code/100);
            
                switch ($_class) {
                    case 1:
                        self::case_error($e);
                        break;
                    case 3:
                        self::case_logic($e);
                    
                        break;
                    case 4:
                        self::case_runtime($e);
                        break;
                    default: # 一番外側からcatchされた漏れたexception
                }
            }
        }
        
        try {
            $add_msg = self::connect_ex_str($e);
            $msg = "undefined exception code is follows =>"."<hr>". $add_msg. "<hr>" ;
            throw new \DomainException($msg, DOMAIN);
            
            } catch(\DomainException $e) {
                self::catchAfter($e);
            }
                        
    }
   
   
    /**
     * case BadRequestException processing
     *
     * @param BadRequestException $e
     */
    protected static function case_badrequest(BadRequestException $e) 
    {
        $dts = [];
        $id_name = BADREQUEST;
        
        //header("HTTP/1.0 404 Not Found");
        http_response_code(404);
        $dts[] = "uncorrect request or unknown file access!";
        $dts[] = "";
            
        self::display($id_name, $dts);
//      self::logWrite($e);
        exit();
    }
    
    
    /**
     * case error processing
     *
     * @param \ErrorException $e
     */
    protected static function case_error(\ErrorException $e) 
    {
        $dts = [];
        $id_name = ERROR ;
        
        $dts[] = "unknown programing error!";
        $dts[] = "";
        
        http_response_code(500);    
        self::display($id_name, $dts);
        self::logWrite($e);
        exit();
    }
    
    
    
    /**
     * case LogicException processing
     *
     * @param \LogicException $e
     */
    protected static function case_logic(\LogicException $e) 
    {
        $dts = [];
        $id_name = LOGIC ;
        
        $dts[] = "unknown programing logical error!";
        $dts[] = "";
        
        http_response_code(500);
        self::display($id_name, $dts);
        self::logWrite($e);
        exit();
    }
    
    
    /**
     * case RuntimeException processing
     *
     * @param \RuntimeException $e
     */
    protected static function case_runtime(\RuntimeException $e) 
    {
        $dts = [];
        $id_name = RUNTIME ;
        
        $dts[] = "unknown programing  runtime error!";
        $dts[] = "";
        
        http_response_code(500);
        self::display($id_name, $dts);
//      self::logWrite($e);
        exit();
        
    }
    
    
    /**
     * case PDOException processing
     *
     * @param \PDOtimeException $e
     */ 
    protected static function case_PDO(\PDOException $e) 
    {   
        $dts = [];
        $id_name = "pdo" ;
        
        $dts[] = "databases error!";
        $dts[] = "";
        
        http_response_code(500);
        self::display($id_name, $dts);
        self::logWrite($e); 
        exit();
    }
    
    
    /**
     * display global variable 'exception','ret_url' that was seted by Exception classes in development mode
     * 
     */
    public static function dispAll() {
        echo '<hr>';        
        echo $GLOBALS['exceptions'];
        if(!empty($GLOBALS['ret_url'])){
        //if run at public space then is nesessary security check   
            echo 'ret_url='.$GLOBALS['ret_url'];
            echo "<a href=".$GLOBALS['ret_url'].">戻る</a>";  
            echo PHP_EOL;   
        }
    }
    
    
    /*
     * エラー、例外を表示する。 for use smarty
     * @param array \throwable $ex
     */  
    public static function dispError(\Throwable $ex)
    { 
        $view = new MySmarty();
        
        $code = get_class($ex);
       
        //view smarty
        $view->assign( "code", $code );
        $view->assign( "ex", $ex );
        
        //display
       $view->display( "exception_view.tpl" );   
        
    }
    
    
    /**
     * エラー情報をログに出力
     * @param \Throwable $e
     */
    protected static function logWrite(\Throwable $e)
    {
        if (array_key_exists($code, self::EXCEP)) {
            $ex_name = self::EXCEP[$code];
        } else {
            $ex_name = $code;
        }
        
        $msg = sprintf('Exception:%s %s in %s (%s)'
                , $ex_name
                , $e->getMessage()
                , $e->getFile()
                , $e->getLine()
                );
        error_log(hs($msg), 0); # ログを出力
    }
    
    
    /**
     * エラー情報（production mode）
     *
     * @param string id_name, array dts
     */  
    protected static function display(string $id_name, array $dts) 
    {
        $obj = new htmlDts(self::TITLE, $id_name, $dts);
        
        $obj->display(self::RENDER_FNAME, self::TEMP_NAME, $obj);
    }
}
