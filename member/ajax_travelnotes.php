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
require_once(DEDEINC."/dedetag.class.php");
require_once(DEDEINC."/userlogin.class.php");
require_once(DEDEINC."/customfields.func.php");
require_once(DEDEMEMBER."/inc/inc_catalog_options.php");
require_once(DEDEMEMBER."/inc/inc_archives_functions.php");
$menutype = 'content';
$uid=empty($uid)? "" : RemoveXSS($uid); 

/**
 * 业务参考：/member/article_add.php
 */
if(!$cfg_ml->IsLogin()){
    tp_json("操作有误！", 0);
    exit();
}else{

    if(empty($dopost))
    {
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
        tp_json("糟糕，出错了！", 0);
        exit();
    }
    else if($dopost=='save')
    {
        include(DEDEMEMBER.'/inc/archives_check_do.php');

        //分析处理附加表数据
        $inadd_f = $inadd_v = '';
        if(!empty($dede_addonfields))
        {
            $addonfields = explode(';', $dede_addonfields);
            $inadd_f = '';
            $inadd_v = '';
            if(is_array($addonfields))
            {
                foreach($addonfields as $v)
                {
                    if($v=='')
                    {
                        continue;
                    }
                    $vs = explode(',', $v);
                    if(!isset(${$vs[0]}))
                    {
                        ${$vs[0]} = '';
                    }
                    ${$vs[0]} = GetFieldValueA(${$vs[0]}, $vs[1],0);
                    $inadd_f .= ','.$vs[0];
                    $inadd_v .= " ,'".${$vs[0]}."' ";
                }
            }
        }

        if (empty($dede_fieldshash) || $dede_fieldshash != md5($dede_addonfields.$cfg_cookie_encode))
        {
            tp_json('数据校验不对，程序返回!', 0);
            exit();
        }
        
        // 这里对前台提交的附加数据进行一次校验
        // $fontiterm = PrintAutoFieldsAdd($cInfos['fieldset'],'autofield', FALSE);
        // if ($fontiterm != $inadd_f)
        // {
        //     tp_json("提交表单同系统配置不相符,请重新提交！", 0);
        //     exit();
        // }
        
        //处理图片文档的自定义属性
        if($litpic!='')
        {
            $flag = 'p';
        }
        $body = AnalyseHtmlBody($body, $description);
        $body = HtmlReplace($body, -1);

        //生成文档ID
        $arcID = GetIndexKey($arcrank, $typeid, $sortrank, $channelid, $senddate, $mid);
        if(empty($arcID))
        {
            tp_json("无法获得主键，因此无法进行后续操作！",0);
            exit();
        }

        //保存到主表
        $inQuery = "INSERT INTO `#@__archives`(id,typeid,sortrank,flag,ismake,channel,arcrank,click,money,title,shorttitle,
    color,writer,source,litpic,pubdate,senddate,mid,description,keywords,mtype)
    VALUES ('$arcID','$typeid','$sortrank','$flag','$ismake','$channelid','$arcrank','0','$money','$title','$shorttitle',
    '$color','$writer','$source','$litpic','$pubdate','$senddate','$mid','$description','$keywords','$mtypesid'); ";
        if(!$dsql->ExecuteNoneQuery($inQuery))
        {
            $gerr = $dsql->GetError();
            $dsql->ExecuteNoneQuery("DELETE FROM `#@__arctiny` WHERE id='$arcID' ");
            tp_json("把数据保存到数据库主表 `#@__archives` 时出错，请联系管理员。",0);
            exit();
        }

        //保存到附加表
        $addtable = trim($cInfos['addtable']);
        if(empty($addtable))
        {
            $dsql->ExecuteNoneQuery("DELETE FROM `#@__archives` WHERE id='$arcID'");
            $dsql->ExecuteNoneQuery("DELETE FROM `#@__arctiny` WHERE id='$arcID'");
            tp_json("没找到当前模型[{$channelid}]的主表信息，无法完成操作！。",0);
            exit();
        }
        else
        {
            $inquery = "INSERT INTO `{$addtable}`(aid,typeid,userip,redirecturl,templet,body{$inadd_f}) Values('$arcID','$typeid','$userip','','','$body'{$inadd_v})";
            if(!$dsql->ExecuteNoneQuery($inquery))
            {
                $gerr = $dsql->GetError();
                $dsql->ExecuteNoneQuery("DELETE FROM `#@__archives` WHERE id='$arcID'");
                $dsql->ExecuteNoneQuery("DELETE FROM `#@__arctiny` WHERE id='$arcID'");
                tp_json("把数据保存到数据库附加表 `{$addtable}` 时出错，请联系管理员！",0);
                exit();
            }
        }

        //增加积分
        $dsql->ExecuteNoneQuery("UPDATE `#@__member` set scores=scores+{$cfg_sendarc_scores} WHERE mid='".$cfg_ml->M_ID."' ; ");
        //更新统计
        countArchives($channelid);

        //生成HTML
        InsertTags($tags, $arcID);
        $artUrl = MakeArt($arcID, TRUE);
        if($artUrl=='') $artUrl = $cfg_phpurl."/view.php?aid=$arcID";

        
        #api{{
        if(defined('UC_API') && @include_once DEDEROOT.'/api/uc.func.php')
        {
            //推送事件
            $feed['icon'] = 'thread';
            $feed['title_template'] = '<b>{username} 在网站发布了一篇文章</b>';
            $feed['title_data'] = array('username' => $cfg_ml->M_UserName);
            $feed['body_template'] = '<b>{subject}</b><br>{message}';
            $url = !strstr($artUrl,'http://') ? ($cfg_basehost.$artUrl) : $artUrl;
            $feed['body_data'] = array('subject' => "<a href=\"".$url."\">$title</a>", 'message' => cn_substr(strip_tags(preg_replace("/\[.+?\]/is", '', $description)), 150));        
            $feed['images'][] = array('url' => $cfg_basehost.'/images/scores.gif', 'link'=> $cfg_basehost);
            uc_feed_note($cfg_ml->M_LoginID,$feed);

            $row = $dsql->GetOne("SELECT `scores`,`userid` FROM `#@__member` WHERE `mid`='".$cfg_ml->M_ID."' AND `matt`<>10");
            uc_credit_note($row['userid'], $cfg_sendarc_scores);
        }
        #/aip}}
        
        //会员动态记录
        $cfg_ml->RecordFeeds('add', $title, $description, $arcID);
        
        ClearMyAddon($arcID, $title);
        
        //返回成功信息
        tp_json("成功发布文章！", 1, '/member/travelnotes.php');
        exit();
    }

    tp_json("嗯哼，搞么斯！", 0);
    exit();
}
