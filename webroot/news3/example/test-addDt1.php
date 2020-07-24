<?php

/**
 * aplication start file
 * 
 * @author Hiroyuki Takai <watashitakai@gmail.com>
 * @since 2018/07/
 */
require_once '../../../news3/config.php';
require_once '../../../framework3/runfirst.php';

use framework3\lib\html_view\htmlDts;
use news3\views\create2sec1;

$title = "タイトルです";
$id_name = "1234";
$htmldts = new htmlDts($title, $id_name);

var_dump($htmldts->getDts());
//echo '<hr>';

$dt = ['takai', 'hiroyuki'];

$htmldts->addDtblock($dt);

var_dump($htmldts->getDts());




