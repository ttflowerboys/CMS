<?php
/**
 * 投票模块
 *
 * @version        $Id: vote_add.php 1 23:54 2010年7月20日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require(dirname(__FILE__)."/config.php");
require_once(DEDEADMIN.'/inc/inc_archives_functions.php');
if(file_exists(DEDEDATA.'/template.rand.php'))
{
    require_once(DEDEDATA.'/template.rand.php');
}
if(empty($dopost)) $dopost = "";
if(empty($isarc))  $isarc = 1; 
if($dopost=="save" && $isarc == 1)
{
    if(trim($title) == '')
    {
        ShowMsg('标题不能为空', '-1');
        exit();
    }
    if(empty($aid)){
        ShowMsg('请检查数据是否非法', '-1');
        exit();
    }
    $pubDate = GetMkTime($pubDate);
    if(empty($click)) $click = ($cfg_arc_click=='-1' ? mt_rand(50, 200) : $cfg_arc_click);

    $title = dede_htmlspecialchars(cn_substrR($title,$cfg_title_maxlen));

    $litpic = "";
    if(!empty($thumb)){
        $litpic = $thumb;
    }

    $body = addslashes(stripslashes($body));

    //处理body字段自动摘要、自动提取缩略图等
    $inQuery = "UPDATE `#@__org_news` SET
    title   = '$title'   ,
    pubdate = '$pubDate' ,
    click   = '$click'   ,
    body    = '$body'    ,
    litpic  = '$litpic'
    WHERE aid='$aid'; ";
    if(!$dsql->ExecuteNoneQuery($inQuery))
    {
        ShowMsg("更新失败，请检查！","-1");
        exit();
    }
    ShowMsg("编辑成功！","org_news_main.php?issel=1&oid=".$cid."&aid=".$channelid);
    
    exit();
}


//读取归档信息
$arcQuery = "SELECT * FROM `#@__org_news` WHERE aid='$aid'";
$arcRow = $dsql->GetOne($arcQuery);

$pubDate = $arcRow['pubdate'];
$pubDate = GetDateTimeMk($pubDate);

$setting = array(
    'type' => 'gif,png,jpg',
    'size' => '510',
    'preview'=>1
);
$Thumbs = field_file('thumb', $arcRow['litpic'], $setting);
include DedeInclude('templets/org_news_edit.htm');