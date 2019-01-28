<?php
require_once(dirname(__FILE__)."/../include/common.inc.php");
require_once(DEDEMEMBER."/config.php");
$uid = $cfg_ml->M_LoginID;
$tpl = '<div class="unlogin"><a href="javascript:;" data-url="/plus/login_popup.php" class="js_showAlertBtn">登录</a> / <a href="/member/register.php">注册</a></div>';

if($uid){
    $tpl = '<div class="islogin">';
    $tpl .= '<dl class="uNav">';
    $tpl .= '<dt><a class="uname" href="'. $cfg_memberurl.'/index.php">'.$uid.'</a></dt>';
    $tpl .= '<dd>';
    $tpl .= '<a href="/member/">个人资料</a>';
    $tpl .= '<a href="/member/orders.php">我的订单</a>';
    $tpl .= '<a href="/member/travelnotes.php">我的日记</a>';
    $tpl .= '<a href="/member/maillog.php">我的信箱</a>';
    $tpl .= '<a href="/member/setup.php">设置</a>';
    $tpl .= '<a href="/member/index_do.php?fmdo=login&dopost=exit">安全退出</a>';
    $tpl .= '</dd>';
    $tpl .= '</dl></div>';
}
echo "document.write('".$tpl."');";
exit();
?>