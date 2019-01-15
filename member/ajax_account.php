<?php
/**
 * 空间操作
 * 
 * @version        $Id: space_action.php 1 15:18 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */

require_once(dirname(__FILE__)."/config.php");

$uid=empty($uid)? "" : RemoveXSS($uid); 

if(!isset($dopost)) $dopost = '';
if(empty($fmdo)) $fmdo = '';

/**
 * 个人资料
 */
if(!$cfg_ml->IsLogin()){
    tp_json("操作有误！", 0);
    exit();
}else{
    // 1. 基本资料
    if($dopost=='account')
    {
        tp_json("你输入的用户名不合法！", 0);
        exit();
    }
    
    tp_json("嗯哼！", 0);
    exit();
}




