<?php if ($member) { ?>
您好，<?php echo $member['username']; ?>&nbsp;&nbsp;&nbsp;
<a href="<?php echo $site_url; ?>member/">个人中心</a>&nbsp;&nbsp;&nbsp;
<a href="<?php echo $site_url; ?>member<?php echo url('login/out'); ?>">安全退出</a>
<?php } else { ?>
<a href="<?php echo $site_url; ?>member<?php echo url('register'); ?>">免费注册</a>&nbsp;&nbsp;&nbsp;
<a href="<?php echo $site_url; ?>member<?php echo url('login'); ?>">会员登录</a>&nbsp;&nbsp;&nbsp;
<a href="<?php echo $site_url; ?>member<?php echo url('login/qqlogin'); ?>">QQ登录</a>&nbsp;&nbsp;&nbsp;

<a href="<?php echo $site_url; ?>index.php?c=post">游客投稿</a>&nbsp;&nbsp;&nbsp;
<?php } ?>