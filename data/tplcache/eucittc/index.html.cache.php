<?php include $this->_include('header.html'); ?>

  <div class="w">

    <h2 class="pageTit">新闻资讯 <span class="en"><b>/</b> NEWS</span></h2>

    <div class="clearfix">

      <div class="MainL"><?php $return = $this->_listdata("catid=12 order=time status=2"); extract($return); if (is_array($return))  foreach ($return as $key=>$xiao) { ?>

       <div class="indexFocus"><div class="focus"><a class="pic" href="<?php echo $xiao['url']; ?>"><img src="<?php echo image($xiao[thumb]); ?>" alt="<?php echo $xiao['title']; ?>" width="690"></a><h3 class="tit"><a href="<?php echo $xiao['url']; ?>"><?php echo $xiao['title']; ?></a></h3></div><div class="time"><?php echo date("Y.m.d", $xiao['time']); ?></div><p class="desc"><?php echo strcut($xiao[description],318); ?></p></div><?php } ?> <!-- indexFocus end -->

      <ul class="newsList"><?php $return = $this->_listdata("catid=13 order=time num=5"); extract($return); if (is_array($return))  foreach ($return as $key=>$xiao) { ?><li><a href="<?php echo $xiao['url']; ?>"><?php echo $xiao['title']; ?></a><span class="time"><?php echo date("Y.m.d", $xiao['time']); ?></span></li><?php } ?>

      </ul>

      <div class="newsListMore"><a href="<?php echo $cats[4][url]; ?>">+more</a></div>

      </div>

      <div class="MainR">

      	<div class="plan">

      	  <a href="<?php echo $cats[3][url]; ?>"><img src="./static/images/plan.jpg" alt="国际技术运河计划"></a>

      	  <div class="planMask"><a href="<?php echo $cats[3][url]; ?>">International <br> Technology Canal Plan <br>国际科技运河计划</a></div>

      	</div>

      	<ul class="indexIconList">

      		<li><a href="<?php echo $cats[10][url]; ?>"><i class="icon">&#xe900;</i><span>创新交流</span></a></li>

      		<li class="even"><a href="<?php echo $cats[26][url]; ?>"><i class="icon" style="font-weight: bold;">&#xe904;</i><span>创新资源</span></a></li>

      		<li><a href="<?php echo $cats[25][url]; ?>"><i class="icon">&#xe909;</i><span>创新金融</span></a></li>

      		<li class="even"><a href="<?php echo $cats[27][url]; ?>"><i class="icon">&#xe90a;</i><span>创新服务</span></a></li>

      	</ul>

        <div class="indexAd"><a href="<?php $this->block(8);?>"><img src="<?php $this->block(7);?>" alt=""></a></div>

      	<!-- <div class="indexBBS"><b class="en">2016 EU-China <br> Industrial Technology <br> Transfer Forum</b><b class="zn">欧盟-中国工业技术转移论坛</b><a href="http://cn.eucittf.org/" class="more">more</a>

        </div> -->

      </div>

    </div> <!-- end -->

<?php include $this->_include('footer.html'); ?>