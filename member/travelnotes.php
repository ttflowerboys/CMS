<?php
/**
 * @version        $Id: index.php 1 8:24 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
require_once(DEDEINC."/dedetag.class.php");
require_once(DEDEINC."/userlogin.class.php");
require_once(DEDEINC."/customfields.func.php");
require_once(DEDEMEMBER."/inc/inc_catalog_options.php");
require_once(DEDEMEMBER."/inc/inc_archives_functions.php");

$uid=empty($uid)? "" : RemoveXSS($uid); 
if(empty($action)) $action = '';
if(empty($aid)) $aid = '';
/**
 * 设置 channelid ，默认模型ID
 * typeid，栏目分类
 */
$channelid = isset($channelid) && is_numeric($channelid) ? $channelid : 22;
$typeid = isset($typeid) && is_numeric($typeid) ? $typeid : 4;

$menutype = 'mydede';
if ( preg_match("#PHP (.*) Development Server#",$_SERVER['SERVER_SOFTWARE']) )
{
    if ( $_SERVER['REQUEST_URI'] == dirname($_SERVER['SCRIPT_NAME']) )
    {
        header('HTTP/1.1 301 Moved Permanently');
        header('Location:'.$_SERVER['REQUEST_URI'].'/');
    }
}
//会员后台
if($uid=='')
{
    $iscontrol = 'yes';
    if(!$cfg_ml->IsLogin())
    {
        include_once(dirname(__FILE__)."/templets/index-login.htm");
    }
    else
    {

        $dpl = new DedeTemplate();
        switch ($type) {
            case 'update':
                $cInfos = $dsql->GetOne("SELECT * FROM `#@__channeltype` WHERE id='$channelid'; ");
                //如果限制了会员级别或类型，则允许游客投稿选项无效
                if($cInfos['sendrank']>0 || $cInfos['usertype']!='') CheckRank(0,0);
                //检查会员等级和类型限制
                if($cInfos['sendrank'] > $cfg_ml->M_Rank)
                {
                    $row = $dsql->GetOne("SELECT membername FROM `#@__arcrank` WHERE rank='".$cInfos['sendrank']."' ");
                    tp_json("对不起，需要[".$row['membername']."]才能在这个频道发布文档！",0);
                    exit();
                }
                if($cInfos['usertype']!='' && $cInfos['usertype'] != $cfg_ml->M_MbType)
                {
                    tp_json("对不起，需要[".$cInfos['usertype']."帐号]才能在这个频道发布文档！",0);
                    exit();
                }

                $tpl = dirname(__FILE__)."/templets/travelnotes_update.htm";
                break;
            default:
                $tpl = dirname(__FILE__)."/templets/travelnotes_index.htm";
                break;
        }
        $dpl->LoadTemplate($tpl);
        $dpl->display();
        
    }
}
