<?php
/**
 * @version        $Id: index_do.php 1 8:24 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
if(empty($token)) $token = '';

/*********************
function check_email()
*******************/
if($token)
{
    $row = $dsql->GetOne("SELECT email,passexptime FROM `#@__member` WHERE passtoken='{$token}' ");
    if(!is_array($row))
    {
        $str = "链接已过期，请重新发送邮件！";
        $str .= "<script>setTimeout(function(){ window.location.href='/'; }, 3000)</script>";
        exit($str);
    }
    if(time()>$row['passexptime']){
        $str = "链接已过期，请重新发送邮件！";
        $str .= "<script>setTimeout(function(){ window.location.href='/'; }, 3000)</script>";
        exit($str);
    }
    
    // 清除会员缓存
    $showsetpass = true;
    $email = $row['email'];
    $setpass = "<script>\r";
    $setpass .= "$(function(){\r";
    $setpass .= "    $.ajax({\r";
    $setpass .= "        type: 'post',\r";
    $setpass .= "        url: '/plus/setpass.php?random=Math.random()',\r";
    $setpass .= "        data: {\r";
    $setpass .= "           email:'{$email}',\r";
    $setpass .= "        },\r";
    $setpass .= "        timeout:90000,\r";
    $setpass .= "        dataType : 'html',\r";
    $setpass .= "        success:function(o){\r";
    $setpass .= "            $('body').append(o);\r";
    $setpass .= "        }\r";
    $setpass .= "    })\r";
    $setpass .= "})\r";
    $setpass .= "</script>";
    require_once(DEDEMEMBER."/templets/index-login.htm");
    exit();
}
else
{
    $str = "链接已过期，请重新发送邮件！";
    $str .= "<script>setTimeout(function(){ window.location.href='/'; }, 3000)</script>";
    exit($str);
}