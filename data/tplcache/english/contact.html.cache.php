<?php include $this->_include('header.html'); ?>
<!--   <div class="innerBanner"></div>
</div> -->
<div class="w"><?php $topcat = get_top_cat($catid); ?>
  <h1 class="pageTit"><?php echo $topcat[catname]; ?></h1>
  <div class="pageMain clearfix">
    <div class="pageL"><div class="conPic"><img src="./static/images/qr.jpg" alt="二维码" ></div></div>
    <div class="pageR">
      <div class="postMain"><?php echo $content; ?></div>
    </div>
  </div> <!-- pageMain end -->
<?php include $this->_include('footer.html'); ?>