      <div class="sixteen columns" id="bottom">
        <p>mygoare &copy; 2013 · <a href="<?php echo base_url(); ?>about" >关于</a> · <a href="<?php echo base_url(); ?>user/handbook">用户手册</a><!-- · <a href="javascript:void(0)" >反馈</a>--></p>
      </div>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.form.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.cookie.js"></script>
    <script type="text/javascript">
      var data = data || {};
      var data = {
        base_url      : '<?php echo base_url() ?>',
        url_path_name : window.location.path,
        file_max      : <?php echo isset($_SESSION["user_login"])?10:5 ?>
      };
    </script>
    <script src="<?php echo base_url(); ?>assets/js/main.js"></script>
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-37219536-2']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
    <link href='http://fonts.googleapis.com/css?family=Crimson+Text:400italic' rel='stylesheet' type='text/css'>
  </body>
</html>
