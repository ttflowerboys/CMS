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
if(empty($isarc))  $isarc = 0; 
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
    $oid = $aid;
    $pubDate = GetMkTime($pubDate);
    if(empty($click)) $click = ($cfg_arc_click=='-1' ? mt_rand(50, 200) : $cfg_arc_click);

    $title = dede_htmlspecialchars(cn_substrR($title,$cfg_title_maxlen));

    $litpic = "";
    if(!empty($thumb)){
        $litpic = $thumb;
    }

    $body = addslashes(stripslashes($body));
    //处理body字段自动摘要、自动提取缩略图等
    $inQuery = "INSERT INTO #@__org_demand(title,pubdate,click,body,oid,project,litpic)
    VALUES('$title','$pubDate',$click,'$body','$oid','$project','$litpic'); ";
    if(!$dsql->ExecuteNoneQuery($inQuery))
    {
        ShowMsg("发布失败，请检查数据是否非法！","-1");
        exit();
    }
    $aid = $dsql->GetLastID();
    ShowMsg("发布成功！","org_demand_main.php?issel=1&oid=".$oid."&aid=".$aid);

    exit();
}
$pubDate = time();
$pubDate = GetDateTimeMk($pubDate);

$project = '';
if(!empty($channelid) && !empty($aid)){
    $query = "SELECT * FROM `#@__channeltype` WHERE id='".$channelid."'";
    $cInfos = $dsql->GetOne($query);
    
    $addtable = $cInfos['addtable'];
    $addRow = $dsql->GetOne("SELECT * FROM `$addtable` WHERE aid='$aid'");

    $project = $addRow['project'];
}
$setting = array(
    'type' => 'gif,png,jpg',
    'size' => '510',
    'preview'=>1
);
$Thumbs = field_file('thumb', '', $setting);
include DedeInclude('templets/org_demand_add.htm');