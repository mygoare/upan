    </div>
    <script src="http://libs.baidu.com/jquery/1.9.0/jquery.min.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script type="text/javascript">
      var data = data || {};
      var data = {
        upload_url    : '<?php echo site_url('home/upload_file'); ?>',
        get_file_url  : '<?php echo site_url('home/get_file') ?>',
        url_path_name : window.location.path
      };
    </script>
    <script src="<?php echo base_url(); ?>assets/js/main.js"></script>
  </body>
</html>
