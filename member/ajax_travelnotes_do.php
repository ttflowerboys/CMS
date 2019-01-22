<?php
/**
 * 文档管理
 * 
 * @version        $Id: archives_do.php 1 13:52 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
require_once(DEDEINC."/dedetag.class.php");
require_once(DEDEINC."/customfields.func.php");
require_once(DEDEMEMBER."/inc/inc_catalog_options.php");
require_once(DEDEMEMBER."/inc/inc_archives_functions.php");
if(empty($dopost)) $dopost = '';

$aid = isset($aid) && is_numeric($aid) ? $aid : 0;
$channelid = isset($channelid) && is_numeric($channelid) ? $channelid : 22;

/*-----------------
function delStow()
删除收藏
------------------*/
if($dopost=="delStow")
{
    CheckRank(0,0);
    $type=empty($type)? 'sys' : trim($type);
    $ENV_GOBACK_URL = empty($_COOKIE['ENV_GOBACK_URL']) ? "mystow.php" : $_COOKIE['ENV_GOBACK_URL'];
    $dsql->ExecuteNoneQuery("DELETE FROM #@__member_stow WHERE aid='$aid' AND mid='".$cfg_ml->M_ID."' AND type='$type';");
    //更新用户统计
    $row = $dsql->GetOne("SELECT COUNT(*) AS nums FROM `#@__member_stow` WHERE `mid`='".$cfg_ml->M_ID."' ");
    $dsql->ExecuteNoneQuery("UPDATE #@__member_tj SET `stow`='$row[nums]' WHERE `mid`='".$cfg_ml->M_ID."'");
        
    tp_json("成功删除一条收藏记录！",1 ,$ENV_GOBACK_URL);
    exit();
}

/*-----------------
function addArchives()
添加投稿
------------------*/
else if($dopost=="addArc")
{
    if($channelid==1)
    {
        $addcon = 'article_add.php?channelid='.$channelid;
    }
    else if($channelid==2)
    {
        $addcon = 'album_add.php?channelid='.$channelid;
    }
    else if($channelid==3)
    {
        $addcon = 'soft_add.php?channelid='.$channelid;
    }
    else
    {
        $row = $dsql->GetOne("SELECT useraddcon FROM `#@__channeltype` WHERE id='$channelid' ");
        if(!is_array($row))
        {
            ShowMsg("模型参数错误!","-1");
            exit();
        }
        $addcon = $row['useraddcon'];
        if(trim($addcon)=='')
        {
            $addcon = 'archives_add.php';
        }
        $addcon = $addcon."?channelid=$channelid";
    }
    header("Location:$addcon");
    exit();
}
/*------------------------------
function _SaveArticle(){  }
------------------------------*/
else if($dopost=='save')
{
    include(DEDEMEMBER.'/inc/archives_check_edit_do.php');

    //分析处理附加表数据
    $inadd_f = '';
    if(!empty($dede_addonfields))
    {
        $addonfields = explode(';',$dede_addonfields);
        if(is_array($addonfields))
        {
            foreach($addonfields as $v)
            {
                if($v=='')
                {
                    continue;
                }
                $vs = explode(',',$v);
                if(!isset(${$vs[0]}))
                {
                    ${$vs[0]} = '';
                }
                ${$vs[0]} = GetFieldValueA(${$vs[0]},$vs[1],$aid);
                $inadd_f .= ','.$vs[0]." ='".${$vs[0]}."' ";
            }
        }
    }
    
    $body = AnalyseHtmlBody($body,$description);
    $body = HtmlReplace($body,-1);

    //处理图片文档的自定义属性
    if($litpic!='') $flag = 'p';

    //更新数据库的SQL语句
    $upQuery = "UPDATE `#@__archives` SET
             ismake='$ismake',
             arcrank='$arcrank',
             typeid='$typeid',
             title='$title',
             litpic='$litpic',
             description='$description',
             mtype = '$mtypesid',
             keywords='$keywords',            
             flag='$flag'
      WHERE id='$aid' AND mid='$mid'; ";
    if(!$dsql->ExecuteNoneQuery($upQuery))
    {
        tp_json("把数据保存到数据库主表时出错，请联系管理员！".$dsql->GetError(), 0);
        exit();
    }
    if($addtable!='')
    {
        $upQuery = "UPDATE `$addtable` SET typeid='$typeid',body='$body'{$inadd_f},userip='$userip' WHERE aid='$aid' ";
        if(!$dsql->ExecuteNoneQuery($upQuery))
        {
            tp_json("更新附加表 `$addtable`  时出错，请联系管理员！",0);
            exit();
        }
    }
    UpIndexKey($aid, $arcrank, $typeid, $sortrank, $tags);
    tp_json("成功更改文章！",1, '/member/travelnotes.php');
    exit();
}

/*--------------------
function delArchives()
删除文章
--------------------*/
else if($dopost=="delArc")
{
    CheckRank(0,0);
    include_once(DEDEMEMBER."/inc/inc_batchup.php");
    $ENV_GOBACK_URL = empty($_COOKIE['ENV_GOBACK_URL']) ? 'content_list.php?channelid=' : $_COOKIE['ENV_GOBACK_URL'];


    $equery = "SELECT arc.channel,arc.senddate,arc.arcrank,ch.maintable,ch.addtable,ch.issystem,ch.arcsta FROM `#@__arctiny` arc
               LEFT JOIN `#@__channeltype` ch ON ch.id=arc.channel WHERE arc.id='$aid' ";

    $row = $dsql->GetOne($equery);
    if(!is_array($row))
    {
        ShowMsg("你没有权限删除这篇文档！","-1");
        exit();
    }
    if(trim($row['maintable'])=='') $row['maintable'] = '#@__archives';
    if($row['issystem']==-1)
    {
        $equery = "SELECT mid FROM `{$row['addtable']}` WHERE aid='$aid' AND mid='".$cfg_ml->M_ID."' ";
    }
    else
    {
        $equery = "SELECT mid,litpic from `{$row['maintable']}` WHERE id='$aid' AND mid='".$cfg_ml->M_ID."' ";
    }
    $arr = $dsql->GetOne($equery);
    if(!is_array($arr))
    {
        ShowMsg("你没有权限删除这篇文档！","-1");
        exit();
    }

    if($row['arcrank']>=0)
    {
        $dtime = time();
        $maxtime = $cfg_mb_editday * 24 *3600;
        if($dtime - $row['senddate'] > $maxtime)
        {
            ShowMsg("这篇文档已经锁定，你不能再删除它！","-1");
            exit();
        }
    }

    $channelid = $row['channel'];
    $row['litpic'] = (isset($arr['litpic']) ? $arr['litpic'] : '');

    //删除文档
    if($row['issystem']!=-1) $rs = DelArc($aid);
    else $rs = DelArcSg($aid);

    //删除缩略图
    if(trim($row['litpic'])!='' && preg_match("#^".$cfg_user_dir."/{$cfg_ml->M_ID}#", $row['litpic']))
    {
        $dsql->ExecuteNoneQuery("DELETE FROM `#@__uploads` WHERE url LIKE '{$row['litpic']}' AND mid='{$cfg_ml->M_ID}' ");
        @unlink($cfg_basedir.$row['litpic']);
    }

    if($rs)
    {
        //更新用户记录
        countArchives($channelid);
        //扣除积分
        $dsql->ExecuteNoneQuery("Update `#@__member` set scores=scores-{$cfg_sendarc_scores} where mid='".$cfg_ml->M_ID."' And (scores-{$cfg_sendarc_scores}) > 0; ");
        tp_json("成功删除一篇文档！",1);
        exit();
    }
    else
    {
        tp_json("删除文档失败！",0);
      exit();
    }
    exit();
}

/*-----------------
function viewArchives()
查看文章
------------------*/
else if($dopost=="viewArchives")
{
    CheckRank(0,0);
    if($type==""){
        header("location:".$cfg_phpurl."/view.php?aid=".$aid);
    }else{
        header("location:/book/book.php?bid=".$aid);
    }
}

/*--------------
function DelUploads()
删除上传的附件
----------------*/
else if($dopost=="delUploads")
{
    CheckRank(0,0);
    if(empty($ids))
    {
        $ids = '';
    }

    $tj = 0;
    if($ids=='')
    {
        $arow = $dsql->GetOne("SELECT url,mid FROM `#@__uploads` WHERE aid='$aid'; ");
        if(is_array($arow) && $arow['mid']==$cfg_ml->M_ID)
        {
            $dsql->ExecuteNoneQuery("DELETE FROM `#@__uploads` WHERE aid='$aid'; ");
            if(file_exists($cfg_basedir.$arow['url']))
            {
                @unlink($cfg_basedir.$arow['url']);
            }
        }
        $tj++;
    }
    else
    {
        $ids = explode(',',$ids);
        foreach($ids as $aid)
        {
            $aid = preg_replace("#[^0-9]#", "", $aid);
            $arow = $dsql->GetOne("SELECT url,mid From #@__uploads WHERE aid='$aid'; ");
            if(is_array($arow) && $arow['mid']==$cfg_ml->M_ID)
            {
                $dsql->ExecuteNoneQuery("DELETE FROM `#@__uploads` WHERE aid='$aid'; ");
                $tj++;
                if(file_exists($cfg_basedir.$arow['url']))
                {
                    @unlink($cfg_basedir.$arow['url']);
                }
            }
        }
    }
    ShowMsg("成功删除 $tj 个附件！",$ENV_GOBACK_URL);
    exit();
}