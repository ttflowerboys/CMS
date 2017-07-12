<?php include $this->_include('header.html'); ?>
<div class="w"><?php $topcat = get_top_cat($catid); ?>
  <h1 class="pageTit"><?php echo $topcat[catname]; ?></h1>
  <div class="pageMain clearfix">
    <?php include $this->_include('aside.html'); ?>
    <div class="pageR">
      <div class="postMain">
        <h1 class="postTit"><?php echo $title; ?></h1>
        <div class="postMeta"><span class="time"><?php echo date("Y.m.d", $time); ?></span></div>
        <div><?php echo $content; ?></div>      
      </div>
    </div>
  </div> <!-- pageMain end -->
<?php include $this->_include('footer.html'); ?>