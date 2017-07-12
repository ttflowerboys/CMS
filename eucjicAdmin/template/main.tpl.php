<?php include $this->admin_tpl('header');?>
<script type="text/javascript">$(function(){$.getScript("<?php echo $client_url;?>");});</script>
<?php if(!is_file(DATA_DIR . 'cache' . DS."category.cache.php")) echo '<script type="text/javascript">location.href="'. url('index/cache') .'";</script>';?>

<!--未授权用户请不要私自更改版权 ，否则后果自负！-->

<script type="text/javascript">
$(function(){
	$.getScript("http://www.xiaocms.com/index.php?c=index&a=news");
	$.getScript("http://www.xiaocms.com/index.php?c=index&a=help");
}); 
</script>

<div class="subnav">
<div class="lf mr10" style="width:48%">
	
    <div class="bk10"></div>
	<table width="100%"   class="m-table m-table2 m-table-row">
	<thead class="m-table-thead s-table-thead">
	<tr>
		<th align="left">系统信息</th>
	</tr>
	</thead>
	<tbody >
		<tr >
		<td align="left">当前域名：<?php echo $_SERVER['HTTP_HOST']?></td>
		</tr>
		<tr >
		<td align="left">上传限制：<?php echo $sysinfo['fileupload']?></td>
		</tr>
		<tr >
		<td align="left">运行环境：<?php echo $_SERVER['SERVER_SOFTWARE'];?></td>
		</tr>
		<tr >
		<td align="left" style="border-bottom: 0px;">mysql版本：<?php echo $this->db->getServerVersion()?></td>
		</tr>
		</tbody>
	</table>
</div>

</div>
</body>
</html>