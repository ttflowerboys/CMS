<?php
require_once(dirname(__FILE__)."/../include/common.inc.php");
require_once(DEDEMEMBER."/config.php");
$uid = $cfg_ml->M_LoginID;
$uid = ($uid) ? $uid : '游客';
echo "document.write('".$uid."');";
exit();
?>