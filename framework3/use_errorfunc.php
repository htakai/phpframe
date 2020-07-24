<?php
//フレームワークで使用する定数定義

namespace framework3;


require_once __DIR__ . '/common/ErrorFunc.php';
require_once __DIR__ . '/common/F_util.php';

use framework3\common\ErrorFunc;
use framework3\common\F_util;

//Exception code
define("ERROR", 110); # ErrorException

define("LOGIC", 300); # LogicException
define("BADFUNC", 310); # BadFunctionCallException
define("BADMETHOD", 320); # BadMethodCallException
define("DOMAIN", 330); # DomainException
define("INVALID", 340); # InvalidArgumentException
define("LENGTH", 350); # LengthException
define("OUTOFRANGE", 360); # OutOfRangeException

define("RUNTIME", 400); # RuntimeException
define("OUTOFBOUNDS", 410); # OutOfBoundsException
define("OVERFLOW", 420); # OverflowException
define("RANGES", 430); # RangeException
define("UNDERFLOW", 440); # UnderflowException
define("UNEXPECTED", 450); # UnexpectedValueException
define("BADREQUEST", 4001); # BadRequestException
define("MYVALID", 5000); # MyvalidException

ErrorFunc::getInstance();
