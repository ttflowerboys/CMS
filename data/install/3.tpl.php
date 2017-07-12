<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<title>Sunpun 企业建站版安装向导</title>
<link rel="stylesheet" type="text/css" href="./data/install/xiaocms.css" />
</head>
<body>
<div class="install-box">
  <div class="head"> Sunpuns 安装完成 </div>
  <div class="install">
					<div class="formitm">
						<label class="lab" >后台地址：</label>
						<div class="ipt"><a href="<?php echo $adminurl;?>admin/"><span class="red"><?php echo $adminurl;?>admin/</a></span></div>
					</div>
					<div class="formitm">
						<label class="lab" >后台账号：</label>
						<div class="ipt red"><?php echo $admin_name ;?></div>
					</div>
					<div class="formitm">
						<label class="lab" >后台密码：</label>
						<div class="ipt red"><?php echo $admin_pass ;?></div>
					</div>
		<div class="install-button"><a href="<?php echo $adminurl;?>admin/" class="button">登录后台</a></div>
  </div>
</div>
<div class="copyright">Copyright &copy; <?php echo date('Y'); ?> <a target="_blank" href="http://www.sunpun.com">www.sunpun.com</a> All Rights Reserved. </div>
</body>
</html>

