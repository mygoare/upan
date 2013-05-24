<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta name="description" content="upan,云U盘,享受云的空间,upan.us" >
    <meta name="author" content="mygoare" >
    <title>云U盘--享受云的空间 - upan.us</title>

    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/base.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/skeleton.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/layout.css">

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Favicons
    ================================================== -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
    <link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url(); ?>assets/images/apple-touch-icon-114x114.png">

    <link media="screen" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
  </head>
      <!--<div style="width:100%; height:100%; position:absolute; background:#eee; z-index:10; opacity:0.6;filter:alpha(opacity=60);"></div>-->
      <!--<div class="float_layer" style="position:absolute; width:400px; height:200px; left:50%; margin-left:-200px; background-color:#ccc; top:50%; margin-top:-100px; z-index:1000;">-->
      <!--</div>-->
  <body>
    <div class="recommend_browder"><p>推荐使用Chrome浏览器，获得更好的用户体验！</p></div>
    <div class="container center">
      <div class="sixteen columns" id="header">
        <h1 class="remove-bottom" id="title" title="回首页"><a href="<?php echo base_url(); ?>">Upan.us</a></h1>
        <h5>云U盘，享受云的空间！</h5>
        <div id="nav">
          <ul>
            <li><a href="<?php echo base_url(); ?>" title="home">首页</a></li>
            <li><a href="<?php echo base_url(); ?>about" title="about">关于</a></li>
            <?php if ($this->session->userdata('logged_in')) { ?>
            <li><a href="<?php echo base_url(); ?>user" title="user"><?php echo $this->session->userdata('username') ?></a></li>
            <?php } else { ?>
            <li><a href="<?php echo base_url(); ?>user/login" title="user">用户</a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
