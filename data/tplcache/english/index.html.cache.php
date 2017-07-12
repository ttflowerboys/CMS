<?php include $this->_include('header.html'); ?>
  <div class="w">
    <h2 class="pageTit">NEWS</h2>
    <div class="clearfix">
      <div class="MainL"><?php $return = $this->_listdata("catid=35 order=time num=1 status=2"); extract($return); if (is_array($return))  foreach ($return as $key=>$xiao) { ?>
       <div class="indexFocus"><div class="focus"><a class="pic" href="<?php echo $xiao['url']; ?>"><img src="<?php echo image($xiao[thumb]); ?>" alt="<?php echo $xiao['title']; ?>" width="690"></a><h3 class="tit"><a href="<?php echo $xiao['url']; ?>"><?php echo $xiao['title']; ?></a></h3></div><div class="time"><?php echo date("M.d,Y", $xiao['time']); ?></div><p class="desc"><?php echo strcut($xiao[description],318); ?></p></div><?php } ?> <!-- indexFocus end -->

      <ul class="newsList"><?php $return = $this->_listdata("catid=36 order=time num=5"); extract($return); if (is_array($return))  foreach ($return as $key=>$xiao) { ?><li><a href="<?php echo $xiao['url']; ?>"><?php echo $xiao['title']; ?></a><span class="time"><?php echo date("M.d,Y", $xiao['time']); ?></span></li><?php } ?>
      </ul>
      <div class="newsListMore"><a href="<?php echo $cats[17][url]; ?>">+more</a></div>
      </div>
      <div class="MainR">
      	<div class="plan">
      	  <a href="<?php echo $cats[33][url]; ?>"><img src="./static/images/plan.jpg" alt="International Technology Canal"></a>
      	  <div class="planMask"><a href="<?php echo $cats[33][url]; ?>">International <br> Technology Canal Plan</a></div>
      	</div>
      	<ul class="indexIconList">
      		<li><a href="<?php echo $cats[29][url]; ?>"><i class="icon">&#xe900;</i><span>Innovation Exchange</span></a></li>
      		<li class="even"><a href="<?php echo $cats[31][url]; ?>"><i class="icon" style="font-weight: bold;">&#xe904;</i><span>Innovation Resource</span></a></li>
      		<li><a href="<?php echo $cats[30][url]; ?>"><i class="icon" style="text-shadow: 0 0 1px #939393;">&#xe90b;</i><span>Innovation Funding</span></a></li>
      		<li class="even"><a href="<?php echo $cats[32][url]; ?>"><i class="icon">&#xe90a;</i><span>Innovation Service</span></a></li>
      	</ul>
        <div class="indexAd"><a href="<?php $this->block(9);?>"><img src="<?php $this->block(6);?>" alt=""></a></div>
      	<!-- <div class="indexBBS"><b class="en" style="margin-top: 22px;">2016 EU-China <br> Industrial Technology <br> Transfer Forum</b><a href="http://en.eucittf.org/" class="more">more</a>
        </div> -->
      </div>
    </div> <!-- end -->
<?php include $this->_include('footer.html'); ?>