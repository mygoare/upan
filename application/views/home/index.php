      <div class="eight columns entry_hover entry">
        <h4>选择你的文件 & 上传到云</h4>
        <form id="upload_file_form" enctype="multipart/form-data" method="post">
          <a class="button"><span>选择文件</span><input name="file" type="file" id="upload_file" title="文件大小小于5M" /></a>
          <span class="error file_upload_error"></span>
        </form>
      </div>
      <div class="eight columns entry_hover entry">
        <h4>输入提取码 & 下载文件</h4>
        <form id="input_code_form">
          <span class="code_notice_box"></span>
          <input id="input_code" name="input_code" placeholder="输入提取码" type="text" />
          <input style="display:none;" type="submit" />
        </form>
      </div>
      <div class="sixteen columns entry" id="file_code">
        <p class="toggle-notice">提取码是区分大小写的</p>
        <div id="slug"></div>
        <div class="toggle_sel">
          <img class="show_slug" src="<?php echo base_url() ?>assets/images/slug_sel.png" data="" name="" title="提取码" /><small>提取码</small>
          <img class="create_qr" src="<?php echo base_url() ?>assets/images/qr.png" title="生成二维码" /><small>二维码</small>
          <img class="send_email" src="<?php echo base_url() ?>assets/images/send_email.png" title="发邮件" /><small>发邮件</small>
          <img class="send_mobile" src="<?php echo base_url() ?>assets/images/send_mobile.png" title="发短信" /><small>发短信</small>
        </div>
        <!--<p><small>不想记提取码？<a href="">点这里</a>。</small></p>-->
      </div>
      <div class="sixteen columns entry" id="get_file">
        <h4>马上开始下载...</h4>
        <h6>还有 <span>5</span> 秒 <small>如果没有自动开始下载，请点击 <a id="file_url" href="">这里</a></small></h6>
      </div>
