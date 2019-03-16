<?php
/**
 * @version        $Id: index.php 1 8:24 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/../include/common.inc.php");
require_once(DEDEMEMBER."/config.php");

if(empty($aid)) $aid = '';

$arcID = $aid = (isset($aid) && is_numeric($aid)) ? $aid : 0;
if($aid==0) die(" Request Error! ");

$sql = "SELECT * FROM `#@__org_news` WHERE aid='".$aid."'; ";
$minfos = $dsql->GetOne($sql);

$pubdate = GetMkTime($pubdate);

$dpl = new DedeTemplate();
$tpl = include_once(DEDETEMPLATE.'/default/article_oview.htm');        

$dpl->LoadTemplate($tpl, TRUE);
$dpl->display();