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
        if($givenname==''){ tp_json("Please enter your given name!",0); exit(); }
        if($surname==''){ tp_json("Please enter your Surname!",0); exit(); }
        if($preferredname==''){ tp_json("Please enter your Preferred Name!",0); exit(); }
        if($sex==''){ tp_json("Please select gender!",0); exit(); }
        if($birthday==''){ tp_json("Please choose your date of birth!",0); exit(); }
        if($passportno==''){ tp_json("Please enter your Passport No.!",0); exit(); }
        if($contactno==''){ tp_json("Please enter your Contact NO.!",0); exit(); }
        if($wechat==''){ tp_json("Please enter your Wechat ID.!",0); exit(); }
        if($location==''){ tp_json("Please select the current location!",0); exit(); }

        //检查帐号
        // member/edit_baseinfo.php
        $row=$dsql->GetOne("SELECT  * FROM `#@__member_person` WHERE mid='".$cfg_ml->M_ID."'");
        $addupquery = '';

        if($givenname != $row['givenname']) {
            $rs = CheckUserID($givenname,'Given Name',FALSE);
            if($rs!='ok') { tp_json($rs,0); exit(); }
            $addupquery .= ",givenname='$givenname'";
        }
        if($surname != $row['surname']) {
            $rs = CheckUserID($surname,'Surname',FALSE);
            if($rs!='ok') { tp_json($rs,0); exit(); }
            $addupquery .= ",surname='$surname'";
        }
        if($preferredname != $row['preferredname']) {
            $rs = CheckUserID($preferredname,'Preferred Name',FALSE);
            if($rs!='ok') { tp_json($rs,0); exit(); }
            $addupquery .= ",preferredname='$preferredname'";
        }
        
        //性别
        if( !in_array($sex, array('男','女')) ) { tp_json('Please select gender!',0);exit(); }
        
        if($birthday != $row['birthday']){ $addupquery .= ",birthday='$birthday'"; }
        if($passportno != $row['passportno']){ $addupquery .= ",passportno='$passportno'"; }
        if($contactno != $row['contactno']){  $addupquery .= ",contactno='$contactno'"; }
        if($wechat != $row['wechat']){
            $rs = CheckWechat($wechat);
            if($rs!='ok') { tp_json($rs,0); exit(); }
            $addupquery .= ",wechat='$wechat'";
        }
        if($location != $row['location']){  $addupquery .= ",address='$location'"; }

        $query1 = "UPDATE `#@__member_person` SET sex='$sex'{$addupquery} where mid='".$cfg_ml->M_ID."' ";
        $dsql->ExecuteNoneQuery($query1);

        // 清除会员缓存
        $cfg_ml->DelCache($cfg_ml->M_ID);
        tp_json('恭喜，基本资料更新成功！',1,'/member/account.php?type=experience');
        exit();
    }else if($dopost == 'experience'){
        $formatexp = trim($experience);
        if(formatexp==''){
            tp_json("Please enter your travel expectation!",0); exit(); 
        }else if(strlen($formatexp)<20){
            tp_json('Expectation of not less than 20 characters!',0);exit();
        }

        $query = "UPDATE `#@__member_person` SET experience='$formatexp' where mid='".$cfg_ml->M_ID."' ";
        $dsql->ExecuteNoneQuery($query);
        // 清除会员缓存
        $cfg_ml->DelCache($cfg_ml->M_ID);
        tp_json('恭喜，个人经历更新成功！',1,'/member/account.php?type=emergency');
        exit();
    }else if($dopost == 'emergency'){
        $addupquery = '';
        $formatName = trim($emename);
        if($formatName==''){ tp_json("Please enter contacter name.",0); exit(); }
        if($formatName != $row['emename']) {
            $rs = CheckUserID($formatName,'Contacter name',FALSE);
            if($rs!='ok') { tp_json($rs,0); exit(); }
            // $addupquery .= ",emename='$emename'";
        }
        $formatRel = trim($emerelationship);
        $formatContact = trim($emecontact);
        if($formatRel==''){ tp_json("Please enter relationship!",0); exit(); }
        if($formatContact==''){ tp_json("Please enter contact No.",0); exit(); }

        if($formatRel != $row['emerelationship']){  $addupquery .= ",emerelationship='$formatRel'"; }
        if($formatContact != $row['emecontact']){  $addupquery .= ",emecontact='$formatContact'"; }

        $query = "UPDATE `#@__member_person` SET emename='$formatName'{$addupquery} where mid='".$cfg_ml->M_ID."' ";
        $dsql->ExecuteNoneQuery($query);
        // 清除会员缓存
        $cfg_ml->DelCache($cfg_ml->M_ID);
        tp_json('恭喜，个人经历更新成功！',1,'/member');
        exit();
    }

    tp_json("嗯哼，搞么斯！", 0);
    exit();
}
