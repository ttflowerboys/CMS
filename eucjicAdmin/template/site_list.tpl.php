<?php include $this->admin_tpl('header');?>
<script type="text/javascript">
top.document.getElementById('position').innerHTML = '站点管理';
</script>
<div class="subnav">
	<div class="content-menu">
		<a href="<?php echo url('site'); ?>"  class="on"><em>全部站点</em></a>
		<?php if($this->menu('site-add')) { ;?>
		<a href="<?php echo url('site/add'); ?>" class="add"><em>添加站点</em></a>
    	<?php } ?>
	</div>
	<div class="bk10"></div>
	<form action="" method="post" name="myform">
	<table width="100%"  class="m-table m-table2 m-table-row">
	<thead class="m-table-thead s-table-thead">
	<tr>
		<th width="25" align="left">ID</th>
		<th align="left">版本名称</th>
		<th align="left">网站名称</th>
		<th align="left">域名</th>
		<th  width="80"  align="left">操作</th>
	</tr>
	</thead>
	<tbody >
	<?php if (is_array($list))  foreach ($list as $t) { ?>
	<tr >
		<td align="left"><?php echo $t['siteid']; ?></td>
		<td align="left"><?php echo $t['language']; ?></td>
		<td align="left"><a href="<?php echo url('site/edit',array('siteid'=>$t['siteid'])); ?>"><?php echo $t['site_name']; ?></a></td>
		<td align="left"> <?php echo $t['site_domain']; ?></td>
		<td align="left">
		<a href="<?php echo url('site/edit',array('siteid'=>$t['siteid'])); ?>">设置</a> | 
		<a  href="javascript:confirmurl('<?php  echo url('site/del/',array('siteid'=>$t['siteid']));?>','确定删除 『<?php echo $t['site_name']; ?> 』站点吗？')" >删除</a>
		</td>
		</td>
	</tr>
	<?php  } ?>
	</table>
	</form>
</div>
</body>
</html>