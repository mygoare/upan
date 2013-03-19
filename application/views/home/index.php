<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta name="description" content="upan,云U盘,享受云的空间,upan.us" >
    <meta name="author" content="mygoare" >
    <title>云U盘--Let's enjoy the cloud - upan.us</title>

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
  <body>
    <div class="container center">
      <div class="sixteen columns" id="header">
        <h1 class="remove-bottom" id="title" title="回首页"><a href="<?php echo base_url(); ?>">Upan.us</a></h1>
        <h5>let's enjoy the cloud.</h5>
        <div id="nav">
          <ul>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url(); ?>user">User</a></li>
            <li><a href="<?php echo base_url(); ?>about">About</a></li>
          </ul>
        </div>
      </div>
      <div class="eight columns entry_hover entry">
        <h4>Select your file and upload.</h4>
        <form id="upload_file_form" enctype="multipart/form-data" method="post">
          <a class="button"><span>Upload your file</span><input name="file" type="file" id="upload_file" title="文件大小小于5M" /></a>
        </form>
      </div>
      <div class="eight columns entry_hover entry">
        <h4>Input your code and get your file.</h4>
        <form id="input_code_form">
          <input id="input_code" placeholder="input your code here..." type="text" value="" />
          <input style="display:none;" type="submit" />
        </form>
      </div>
      <div class="sixteen columns entry" id="file_code">
        <h4>Please remember your code:</h4>
        <h3>secd</h3>
      </div>
      <div class="sixteen columns" id="bottom">
        <p>mygoare &copy; 2013 · <a href="<?php echo base_url(); ?>about" >About</a> · <a href="" >Feedback</a></p>
      </div>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script type="text/javascript">
      var upload_url = '<?php echo site_url('home/upload_file'); ?>';
    </script>
    <script src="<?php echo base_url(); ?>assets/js/main.js"></script>
  </body>
</html>
