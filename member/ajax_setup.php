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
    if($dopost=='pwd')
    {
        $formatOldpwd = trim($oldpwd);
        if($formatOldpwd==''){ tp_json("Please enter old password.",0); exit(); }

        $formatPwd = trim($userpwd);
        if($formatPwd==''){ tp_json("Please enter a new password.",0); exit(); }
        
        $formatPwdok = trim($userpwdok);
        if($formatPwdok==''){ tp_json("Please input the new password again.",0); exit(); }

        if($formatPwd != $formatPwdok) { tp_json('你两次输入的新密码不一致！',0);exit(); }

        //检查帐号
        // member/edit_baseinfo.php
        $row=$dsql->GetOne("SELECT  * FROM `#@__member` WHERE mid='".$cfg_ml->M_ID."'");
        if(!is_array($row) || $row['pwd'] != md5($oldpwd)) { tp_json('对不起，您的旧密码错误，请重新输入！',0);exit(); }
        
        $pwd = md5($formatPwd);
        $pwd2 = substr(md5($formatPwd),5,20);

        $query = "UPDATE `#@__member` SET pwd='$pwd' where mid='".$cfg_ml->M_ID."' ";
        $dsql->ExecuteNoneQuery($query);

        //如果是管理员，修改其后台密码
        if($cfg_ml->fields['matt']==10 && $pwd2!="")
        {
            $query2 = "UPDATE `#@__admin` SET pwd='$pwd2' where id='".$cfg_ml->M_ID."' ";
            $dsql->ExecuteNoneQuery($query2);
        }

        // 清除会员缓存
        $cfg_ml->DelCache($cfg_ml->M_ID);
        tp_json('恭喜，修改密码成功！',1,'/member/setup.php?type=pwd');
        exit();
    }

    tp_json("嗯哼，搞么斯！", 0);
    exit();
}
