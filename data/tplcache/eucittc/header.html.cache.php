<!DOCTYPE html>

<html lang="zh-cn">

<head>

  <meta charset="UTF-8">

  <title><?php echo $site_title; ?></title>

  <meta name="keywords" content="<?php echo $site_keywords; ?>" />

  <meta name="description" content="<?php echo $site_description; ?>" />

  <link rel="stylesheet" href="./static/css/style.css">

</head>

<body>

  <div class="header">

    <div class="w clearfix">

  	  <h1 class="logo"><a href="<?php echo $site_url; ?>" title="<?php echo $site_name; ?>"><img src="./static/images/logo.gif" alt=""></a></h1>

  	  <div class="sLanguage"><a href="http://cn.eucjic.org/">中</a>|<a href="http://en.eucjic.org/">English</a></div>

  	</div>

  </div> <!-- header end -->

  <div class="rel">

    <div class="navW">

      <ul class="w nav">

        <li><a class="sub" href="<?php echo $site_url; ?>">首页</a></li><?php $return = $this->_category("num=5");  if (is_array($return))  foreach ($return as $key=>$xiao) { $allchildids = @explode(',', $xiao['allchildids']);    $current = in_array($catid, $allchildids);?><li class="<?php if ($current) { ?>subCur<?php } ?>"><a class="sub" href="<?php echo $xiao['url']; ?>"><?php echo $xiao['catname']; ?></a></li><?php } ?>

      </ul>

    </div>    

    <div class="banner">

      <div class="js-sCont"><ul><li><a href="<?php $this->block(10);?>"><img src="<?php $this->block(4);?>" alt=""></a></li></ul></div>

      <div class="js-sDot"><ul><li></li></ul></div>

    </div>

  </div> <!-- end -->