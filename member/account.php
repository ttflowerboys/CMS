<?php
/**
 * @version        $Id: index.php 1 8:24 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");

$uid=empty($uid)? "" : RemoveXSS($uid); 
if(empty($action)) $action = '';
if(empty($aid)) $aid = '';

if(empty($dopost)) $dopost = '';
if(empty($fmdo)) $fmdo = '';

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
        /** 用户信息 **/
        $sql = "SELECT mp.*,m.email FROM `#@__member_person` mp
                LEFT JOIN `#@__member` m ON mp.mid=m.mid
                WHERE mp.mid='".$cfg_ml->M_ID."'; ";
        
        $minfos = $dsql->GetOne($sql);

        $dpl = new DedeTemplate();
        switch ($type) {
            case 'experience':
                $tpl = dirname(__FILE__)."/templets/ucenter_experience.htm";
                break;
            case 'emergency':
                $tpl = dirname(__FILE__)."/templets/ucenter_emergency.htm";
                break;
            case 'shipaddr':
                $tpl = dirname(__FILE__)."/templets/ucenter_shipaddr.htm";
                break;
            default:
                $tpl = dirname(__FILE__)."/templets/ucenter_account.htm";
                break;
        }
        $dpl->LoadTemplate($tpl);
        $dpl->display();
    }
}