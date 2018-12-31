<?php
/**
 * 会员注册
 * 
 * @version        $Id: resetpassword.php 1 8:38 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
require_once DEDEINC.'/membermodel.cls.php';
if($cfg_mb_allowreg=='N')
{
    ShowMsg('系统关闭了新用户注册！', 'index.php');
    exit();
}

if(empty($dopost)) $dopost = '';
if(empty($fmdo)) $fmdo = '';

//success
if($fmdo=='user' && $dopost == 'success'){
    include(DEDEMEMBER."/templets/reg-success.htm");
    exit();
}else{
    include(dirname(__FILE__)."/templets/register.htm");
    exit();
}