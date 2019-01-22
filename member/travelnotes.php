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

/**
 * copy from member/content_list.php
 */
CheckRank(0,0);
require_once(DEDEINC."/typelink.class.php");
require_once(DEDEINC."/datalistcp.class.php");
require_once(DEDEMEMBER."/inc/inc_list_functions.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

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
                $dpl->LoadTemplate($tpl);
                $dpl->display();
                break;
            case 'edit':
                //读取归档信息
                $arcQuery = "SELECT arc.*,ch.addtable,ch.fieldset,arc.mtype as mtypeid,ch.arcsta
                FROM `#@__archives` arc LEFT JOIN `#@__channeltype` ch ON ch.id=arc.channel
                WHERE arc.id='$aid' And arc.mid='".$cfg_ml->M_ID."'; ";
                $row = $dsql->GetOne($arcQuery);
                if(!is_array($row))
                {
                    ShowMsg("读取文章信息出错!","-1");
                    exit();
                }
                else if($row['arcrank']>=0)
                {
                    $dtime = time();
                    $maxtime = $cfg_mb_editday * 24 *3600;
                    if($dtime - $row['senddate'] > $maxtime)
                    {
                        ShowMsg("这篇文档已经锁定，你不能再修改它！","-1");
                        exit();
                    }
                }
                $addRow = $dsql->GetOne("SELECT * FROM `{$row['addtable']}` WHERE aid='$aid'; ");
                $tpl = DEDEMEMBER."/templets/travelnotes_edit.htm";
                $dpl->LoadTemplate($tpl);
                $dpl->display();
                break;
            default:
                $positionname = '';
                $menutype = 'content';
                $mid = $cfg_ml->M_ID;
                $tl = new TypeLink($cid);
                $cInfos = $tl->dsql->GetOne("Select arcsta,issend,issystem,usertype From `#@__channeltype`  where id='$channelid'; ");
                if(!is_array($cInfos))
                {
                    ShowMsg('模型不存在', '-1');
                    exit();
                }
                $arcsta = $cInfos['arcsta'];
                $dtime = time();
                $maxtime = $cfg_mb_editday * 24 *3600;

                //禁止访问无权限的模型
                if($cInfos['usertype'] !='' && $cInfos['usertype']!=$cfg_ml->M_MbType)
                {
                    ShowMsg('你无权限访问该部分', '-1');
                    exit();
                }

                if($cid==0)
                {
                    $row = $tl->dsql->GetOne("Select typename From #@__channeltype where id='$channelid'");
                    if(is_array($row))
                    {
                        $positionname = $row['typename'];
                    }
                }
                else
                {
                    $positionname = str_replace($cfg_list_symbol,"",$tl->GetPositionName())." ";
                }
                $whereSql = " where arc.channel = '$channelid' And arc.mid='$mid' ";
                if($keyword!='')
                {
                    $keyword = cn_substr(trim(preg_replace("#[><\|\"\r\n\t%\*\.\?\(\)\$ ;,'%-]#", "", stripslashes($keyword))),30);
                    $keyword = addslashes($keyword);
                    $whereSql .= " And (arc.title like '%$keyword%') ";
                }
                if($cid!=0) $whereSql .= " And arc.typeid in (".GetSonIds($cid).")";


                //增加分类查询
                if($arcrank == '1'){
                    $whereSql .= " And arc.arcrank >= 0";
                }else if($arcrank == '-1'){
                    $whereSql .= " And arc.arcrank = -1";
                }else if($arcrank == '-2'){
                    $whereSql .= " And arc.arcrank = -2";
                }

                $classlist = '';
                $dsql->SetQuery("SELECT * FROM `#@__mtypes` WHERE `mid` = '$cfg_ml->M_ID';");
                $dsql->Execute();
                while ($row = $dsql->GetArray())
                {
                    $classlist .= "<option value='content_list.php?channelid=".$channelid."&mtypesid=".$row['mtypeid']."'>".$row['mtypename']."</option>\r\n";
                }
                if($mtypesid != 0 )
                {
                    $whereSql .= " And arc.mtype = '$mtypesid'";
                }
                $query = "select arc.id,arc.typeid,arc.senddate,arc.flag,arc.ismake,arc.channel,arc.arcrank,
                        arc.click,arc.title,arc.color,arc.litpic,arc.pubdate,arc.mid,arc.writer,tp.typename,ch.typename as channelname
                        from `#@__archives` arc
                        left join `#@__arctype` tp on tp.id=arc.typeid
                        left join `#@__channeltype` ch on ch.id=arc.channel
                    $whereSql order by arc.senddate desc ";
                $dlist = new DataListCP();
                $dlist->pageSize = 20;
                $dlist->SetParameter("dopost","listArchives");
                $dlist->SetParameter("keyword",$keyword);
                $dlist->SetParameter("cid",$cid);
                $dlist->SetParameter("channelid",$channelid);
                $dlist->SetTemplate(DEDEMEMBER."/templets/travelnotes_index.htm");
                $dlist->SetSource($query);
                $dlist->Display();
                break;
        }
    }
}
