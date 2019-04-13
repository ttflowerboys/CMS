<?php
require_once(dirname(__FILE__)."/config.php");
// 1. include Uploadfile.class.php
require_once(DEDEINC."/webuploader/Uploadfile.class.php");
// 2. define XIAOCMS_PATH and SITE_PATH
define('XIAOCMS_PATH', DEDEROOT.'/uploads');
define('SITE_PATH',  get_a_url().'uploads/');

function get_a_url()
{
    $url = str_replace(array('\\', '//'), '/', $_SERVER['SCRIPT_NAME']);
    $po = strripos($url,'/');
    $url = substr($url,0,$po);
    $po = strripos($url,'/');
    return substr($url,0,$po+1);
}

// 3. core
$c = $_GET['c'];
$a = $_GET['a'];
if($c == 'uploadfile' && $a == 'ueditor' ){
    $uploadfile = new uploadfile;
    $uploadfile->ueditorAction();
}