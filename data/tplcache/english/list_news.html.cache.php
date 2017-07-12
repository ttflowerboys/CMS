<?php include $this->_include('header.html'); ?>
<div class="w"><?php $topcat = get_top_cat($catid); ?>
  <h1 class="pageTit"><?php echo $topcat[catname]; ?></h1>
  <div class="pageMain clearfix">
    <?php include $this->_include('aside.html'); ?>
    <div class="pageR">
      <ul class="newsList"><?php $return = $this->_listdata("catid=$catid page=$page"); extract($return); if (is_array($return))  foreach ($return as $key=>$xiao) { ?><li style="margin-top: -1px"><a class="items" href="<?php echo $xiao['url']; ?>" target="_blank"><?php echo $xiao['title']; ?></a><span class="time"><?php echo date("M.d,Y", $xiao['time']); ?></span></li><?php } ?></ul>
      <div class="listpage" ><?php echo $pagelist; ?></div>
    </div>
  </div> <!-- pageMain end -->
<?php include $this->_include('footer.html'); ?>