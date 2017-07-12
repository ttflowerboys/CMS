<?php include $this->admin_tpl('header');?>

<div class="subnav">
	<div class="content-menu">
		<a href="<?php echo url('site'); ?>"  class="on"><em>全部区块</em></a>
		<?php if($this->menu('block-add')) { ;?>
		<a href="<?php echo url('site/add'); ?>" class="add"><em>添加区块</em></a>
    	<?php } ?>
	</div>
	<div class="bk10"></div>
		<form action="" method="post">
		<input name="id" type="hidden" value="<?php echo $data['id']; ?>">
		<table width="100%" class="table_form">
				<tr>
					<th width="100"><font color="red">*</font>版本名称： </th>
					<td><input class="input-text" type="text" name="data[language]" value="<?php echo $data['language']; ?>" size="30"/><div class="onShow">如：中文版 英文版</div></td>
				</tr>
				<tr>
					<th width="100"><font color="red">*</font>网站名称： </th>
					<td><input class="input-text" type="text" name="data[site_name]" value="<?php echo $data['site_name']; ?>" size="30"/><div class="onShow">网站名称</div></td>
				</tr>
				<tr>
					<th width="100"><font color="red">*</font>网站域名： </th>
					<td><input class="input-text" type="text" name="data[site_domain]" value="<?php echo $data['site_domain']; ?>" size="30"/><div class="onShow">如www.xiaocms.com</div></td>
				</tr>
				<tr>
					<th>默认模板： </th>
					<td><select  class="select"  name="data[site_theme]">
					<?php if (is_array($theme)) { foreach ($theme as $t) { ?>
					<option value="<?php echo $t; ?>" <?php if ($data['site_theme']==$t) { ?>selected<?php } ?>><?php echo $t; ?></option>
					<?php }  }  ?>
					</select> <font color="red">*</font>语言包文件：<input class="input-text" type="text" name="data[site_language]" value="<?php echo $data['site_language']; ?>" size="10"/><div class="onShow">存放在\data\languages\目录下 如英文填写en 中文填写cn 更多的自己扩展</div></td>
				</tr>
				<tr>
					<th>首页标题： </th>
					<td><input class="input-text" type="text" name="data[site_title]" value="<?php echo $data['site_title']; ?>" size="70"/></td>
				</tr>
				<tr>
					<th>关键字：</th>
					<td class="y-bg"><input class="input-text" type="text" name="data[site_keywords]" value="<?php echo $data['site_keywords']; ?>" size="70"/></td>
				</tr>
				<tr>
					<th>网站描述：</th>
					<td><textarea name="data[site_description]" rows="3" cols="70" class="text"><?php echo $data['site_description']; ?></textarea></td>
				</tr>



		<tr>
			<th>&nbsp;</th>
			<td><input class="button" type="submit" name="submit" value="提交" /></td>
		</tr>
		</table>
		</form>
</div>
<script type="text/javascript">top.document.getElementById('position').innerHTML = '站点编辑';</script>

</body>
</html>